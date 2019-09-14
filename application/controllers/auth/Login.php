<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property ApplicationModel $application
 * @property AuthModel $auth
 * @property UserModel $user
 * @property UserApplicationModel $userApplication
 */
class Login extends App_Controller
{
    protected $layout = 'layouts/auth';

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApplicationModel', 'application');
        $this->load->model('AuthModel', 'auth');
        $this->load->model('UserModel', 'user');
        $this->load->model('UserApplicationModel', 'userApplication');
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
                    flash('danger', 'You attempt to many login, your session is locked for ' . $minutesLock . ' minute(s)');
                } else {
                    $authenticated = $this->auth->authenticate($username, $password, $remember);

                    if ($authenticated === UserModel::STATUS_PENDING || $authenticated === UserModel::STATUS_SUSPENDED) {
                        flash('danger', 'Your account has status <strong>' . $authenticated . '</strong>, please contact our administrator');
                    } else {
                        if ($authenticated) {
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