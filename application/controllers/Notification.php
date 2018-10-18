<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Notification
 */
class Notification extends App_Controller
{
    /**
     * Account constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show account preferences.
     */
    public function index()
    {
        $this->render('notification/index');
    }

}