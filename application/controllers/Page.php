<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends App_Controller
{
    protected $layout = 'layouts/static';

    public function __construct()
    {
        parent::__construct();

        $this->setFilterMethods([
            'help' => 'GET',
            'terms' => 'GET'
        ]);
    }

    /**
     * Show legal terms and agreement.
     */
    public function terms()
    {
        $this->render('page/agreement');
    }

    /**
     * Show help page.
     */
    public function help()
    {
        $this->render('page/help');
    }
}