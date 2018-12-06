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

                $authenticated = $this->auth->authenticate($username, $password, $remember);

                if ($authenticated === UserModel::STATUS_PENDING || $authenticated === UserModel::STATUS_SUSPENDED) {
                    flash('danger', 'Your account has status <strong>' . $authenticated . '</strong>, please contact our administrator');
                } else {
                    if ($authenticated) {
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
                        flash('danger', 'Username and password mismatch.');
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