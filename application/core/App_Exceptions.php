<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_Exceptions extends CI_Exceptions
{
	private $logger;

	public function __construct()
	{
		parent::__construct();

		$this->logger = AppLogger::default(App_Exceptions::class, false);
	}

	public function log_exception($severity, $message, $filepath, $line)
	{
		$this->logger->error('Level: ' . ($this->levels[$severity] ?? '') . ' --> ' . $message . ' ' . $filepath . ' ' . $line);

		parent::log_exception($severity, $message, $filepath, $line);
	}

	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		$messageError = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
		$this->logger->error($messageError, [
			'status' => $status_code
		]);
		return parent::show_error($heading, $message, $template, $status_code);
	}

	public function show_404($page = '', $log_error = TRUE)
	{
		if (is_cli()) {
			$headingError = 'Not Found';
			$messageError = 'The controller/method pair you requested was not found.';
		} else {
			$headingError = '404 Page Not Found';
			$messageError = 'The page you requested was not found.';
		}
		$this->logger->error($messageError, [
			'heading' => $headingError,
		]);

		parent::show_404($page, $log_error);
	}
}
