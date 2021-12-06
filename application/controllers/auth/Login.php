<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property ApplicationModel $application
 * @property AuthModel $auth
 * @property UserModel $user
 * @property UserTokenModel $userToken
 * @property UserApplicationModel $userApplication
 */
class Login extends App_Controller
{
    protected $layout = 'layouts/auth';
    private $logger;

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApplicationModel', 'application');
        $this->load->model('AuthModel', 'auth');
        $this->load->model('UserModel', 'user');
        $this->load->model('UserTokenModel', 'userToken');
        $this->load->model('UserApplicationModel', 'userApplication');

        $this->logger = AppLogger::auth(Login::class);
    }

    /**
     * Show default login page.
     */
    public function index()
    {
        if (_is_method('post')) {
            if ($this->validate()) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember');

                // we limiting login attempt based setting as follow,
                // check if throttle expired is set and not passed yet
                $rateLimit = 10; // minutes
                $maxTries = 3; // attempt
                $throttleExpired = $this->session->userdata('auth.throttle_expired');
                if (!empty($throttleExpired)) {
                    // reset throttle counter if $rateLimit passed
                    $minutesLock = difference_date(date('Y-m-d H:i'), $throttleExpired, '%r%i');
                    if ($minutesLock <= 0) {
                        $this->session->unset_userdata(['auth.throttle', 'auth.throttle_expired']);
                    }
                } else {
                    $minutesLock = 0;
                }

                // check if total login is reached the max to trigger limiting
                $throttle = if_empty($this->session->userdata('auth.throttle'), 1);
                if ($throttle > $maxTries) {
                    if (empty($throttleExpired)) {
                        $throttleExpired = date('Y-m-d H:i', strtotime($rateLimit . ' minute'));
                        $this->session->set_userdata('auth.throttle_expired', $throttleExpired);
                        $minutesLock = difference_date(date('Y-m-d H:i'), $throttleExpired, '%r%i');
                    }

					// log when too many attempt
					$this->logger->warning("User is locked, too many attempt", [
						'user' => compact('username', 'password'),
						'throttle' => $throttle,
						'max' => $maxTries,
						'lock_minutes' => $minutesLock,
					]);

                    flash('danger', 'You attempt to many login, your session is locked for ' . $minutesLock . ' minute(s)');
                } else {
                    $authenticated = $this->auth->authenticate($username, $password, $remember);

                    if ($authenticated === UserModel::STATUS_PENDING || $authenticated === UserModel::STATUS_SUSPENDED) {
						$throttle++;
						$this->session->set_userdata('auth.throttle', $throttle);

						// log inactive user
						$this->logger->notice("User is inactive or pending", [
							'user' => compact('username', 'password'),
							'status' => $authenticated,
							'throttle' => $throttle,
							'max' => $maxTries,
						]);

                        flash('danger', 'Your account has status <strong>' . $authenticated . '</strong>, please contact our administrator');
                    } else {
						if ($authenticated) {
							// check if password expired
							$passwordExpiredDays = get_setting('password_expiration_days');
							$user = AuthModel::loginData();
							if ($passwordExpiredDays > 0 && !$user['password_never_expired']) {
								$dayBeforeExpired = difference_date(date('Y-m-d'), format_date($user['password_expired_at']));
								if ($dayBeforeExpired <= 0) {
									// force clear session because password expired
									$this->auth->logout();

									$changePasswordVerification = get_setting('email_verification_after_password_expired_days');
									if ($changePasswordVerification > 0) {
										$passwordVerifiedAt = date('Y-m-d', strtotime(format_date($user['password_expired_at']) . ' +' . $changePasswordVerification . ' day'));
										$dayBeforeVerification = difference_date(date('Y-m-d'), format_date($passwordVerifiedAt));
										if ($dayBeforeVerification <= 0) {
											// log password expired (need verification)
											$this->logger->warning("User password is expired, need verification", [
												'user' => $user,
												'throttle' => $throttle,
												'need_email_verification' => $changePasswordVerification > 0,
												'diff_before_verification' => $dayBeforeVerification,
												'password_should_be_verified_at' => $passwordVerifiedAt,
											]);

											// reset password by email verification
											flash('danger', 'Password expired, must verify email to reset the password', 'auth/password/forgot-password?expired=1&email=' . base64_encode($user['email']));
										}
									}

									// offer change password
									$token = $this->userToken->create($user['email'], UserTokenModel::TOKEN_PASSWORD);

									// log password expired (ask for reset immediately)
									$this->logger->notice("User password is expired, change password now", [
										'user' => $user,
										'throttle' => $throttle,
										'token' => $token,
										'diff_before_verification' => $dayBeforeVerification ?? null,
										'password_should_be_verified_at' => $passwordVerifiedAt ?? null,
									]);

									if ($token == false) {
										flash('danger', 'Password expired, create token failed', 'auth/login');
									}
									flash('danger', 'Your password expired', 'auth/password/reset/' . $token . '?expired=1');
								}
							}

                            // remove login throttle if exist
                            $this->session->unset_userdata(['auth.throttle', 'auth.throttle_expired']);

                            // decide where application to go after login
                            $intended = urldecode($this->input->get('redirect'));

                            // check if redirect url is registered applications
                            $appFound = false;
                            if (!empty($intended)) {
                                $whitelistedApps = $this->application->getAll();
                                $whitelistedApps[] = ['url' => site_url('/')];

                                $parsedUrl = parse_url($intended);
                                $basedUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                                foreach ($whitelistedApps as $application) {
                                    $matchBaseUrl = (rtrim($application['url'], '/') == rtrim($basedUrl, '/'));
                                    $partOfUrl = (strpos($intended, $application['url']) !== false);
                                    if ($matchBaseUrl || $partOfUrl) {
                                        $appFound = true;
                                    }
                                }
                            } else {
                                $appFound = true;
                            }

                            if ($appFound) {

                                // redirect to default application setting
                                $defaultUserApplication = $this->userApplication->getBy([
                                    'id_user' => AuthModel::loginData('id'),
                                    'is_default' => 1
                                ], true);
                                $defaultApplication = get_setting('default_application');

                                // log login success
								$this->logger->info("User [{$username}] successfully logged in", [
									'user' => $user,
									'intended' => $defaultUserApplication['url'] ?? $defaultApplication ?? $intended
								]);

                                if (!empty($defaultUserApplication)) {
                                    $defaultApp = $this->application->getById($defaultUserApplication['id_application']);
                                    redirect($defaultApp['url']);
                                } else if (!empty($defaultApplication)) {
                                    redirect($defaultApplication);
                                }

                                // redirect to intended page if no default application is set up
                                if (empty($intended)) {
                                    redirect("app");
                                }
                                redirect($intended);
                            }

							// log login redirected to unknown url
							$this->logger->notice("User successfully logged in, but redirected to unknown url", [
								'user' => $user,
								'intended' => $intended
							]);

                            flash('danger', 'App ' . $intended . ' is not registered in whitelisted app, proceed with careful.', 'app');

                        } else {
                            $additionalInfo = '';
                            if ($throttle == $maxTries) {
                                $additionalInfo = ', your session will be locked';
                            } elseif ($throttle == ($maxTries - 1)) {
                                $additionalInfo = ', you have last login try';
                            }
                            flash('danger', 'Username and password mismatch' . $additionalInfo);

                            $throttle++;
                            $this->session->set_userdata('auth.throttle', $throttle);

							// log invalid credentials
							$this->logger->warning("User login failed", [
								'user' => compact('username', 'password'),
								'throttle' => $throttle
							]);
                        }
                    }
                }
            }
        }

        $this->render('auth/login');
    }

    /**
     * Return validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'username' => 'trim|required',
            'password' => 'trim|required'
        ];
    }

}
