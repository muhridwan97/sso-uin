<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Application
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
        $applications = $this->application->getAll();

        $this->render('app/index', compact('applications'));
    }
}
