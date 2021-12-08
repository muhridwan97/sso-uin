<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_Exceptions extends CI_Exceptions
{
	private $logger;

	public function __construct()
	{
		parent::__construct();

		$this->logger = AppLogger::default(App_Exceptions::class);
	}

	public function log_exception($severity, $message, $filepath, $line)
	{
		parent::log_exception($severity, $message, $filepath, $line);

		$this->logger->error('Level: ' . ($this->levels[$severity] ?? '') . ' --> ' . $message . ' ' . $filepath . ' ' . $line);
	}

	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		parent::show_error($heading, $message, $template, $status_code);

		$message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
		$this->logger->error($message, [
			'status' => $status_code
		]);
	}

	public function show_404($page = '', $log_error = TRUE)
	{
		parent::show_404($page, $log_error);

		if (is_cli()) {
			$heading = 'Not Found';
			$message = 'The controller/method pair you requested was not found.';
		} else {
			$heading = '404 Page Not Found';
			$message = 'The page you requested was not found.';
		}
		$this->logger->error($message, [
			'heading' => $heading,
		]);
	}
}
