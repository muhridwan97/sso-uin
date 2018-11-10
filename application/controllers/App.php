<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property ApplicationModel $application
 */
class App extends App_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('ApplicationModel', 'application');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $redirectTo = get_setting('default_application');
        $referrer = $this->agent->referrer();
        $isRedirectFromLogin = $referrer == site_url('auth/login');
        $requestAppIndex = $this->uri->segment(1);

        if (!empty($redirectTo)) {
            if ($isRedirectFromLogin || empty($requestAppIndex)) {
                redirect(get_setting('default_application'));
            }
        }

        $applications = $this->application->getByUser(AuthModel::loginData('id'));

        $this->render('application/card', compact('applications'));
    }
}
