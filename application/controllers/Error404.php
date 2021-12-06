<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller
{
	private $logger;

    public function __construct()
    {
        parent::__construct();

        $this->logger = AppLogger::default(Error404::class);
    }

    public function index()
    {
    	$this->logger->warning("Page not found");
    	
        http_response_code(404);
        $this->load->view('errors/html/error_404.php');
    }
}
