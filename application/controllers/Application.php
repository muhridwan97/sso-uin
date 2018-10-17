<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Application
 */
class Application extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        echo 'application select';
    }
}
