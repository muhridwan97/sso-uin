<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property ApplicationModel $application
 * @property UserApplicationModel $userApplication
 */
class App extends App_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('ApplicationModel', 'application');
        $this->load->model('UserApplicationModel', 'userApplication');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $redirectTo = get_setting('default_application');
        $isRedirectFromLogin = $this->agent->referrer() == site_url('auth/login');
        $defaultUserApplication = $this->userApplication->getBy([
            'id_user' => AuthModel::loginData('id'),
            'is_default' => 1
        ], true);

        if ($isRedirectFromLogin) {
            if (!empty($defaultUserApplication)) {
                $defaultApp = $this->application->getById($defaultUserApplication['id_application']);
                redirect($defaultApp['url']);
            } else if (!empty($redirectTo)) {
                redirect(get_setting('default_application'));
            }
        }

        $applications = $this->application->getByUser(AuthModel::loginData('id'));

        $this->render('application/card', compact('applications'));
    }
}
