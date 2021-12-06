<?php

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\HostnameProcessor;
use Monolog\Processor\WebProcessor;

class AppLogger
{
	/**
	 * Get default logger.
	 *
	 * @param null $name
	 * @return Logger
	 */
	public static function default($name = null)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$accessHandler = new RotatingFileHandler(APPPATH . "logs/access/access.log");
		$errorHandler = new StreamHandler(APPPATH . "logs/errors/error.log", Logger::ERROR);

		$logger
			->pushHandler($accessHandler)
			->pushHandler($errorHandler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

	/**
	 * Get auth logger.
	 *
	 * @param null $name
	 * @return Logger
	 */
	public static function auth($name = null)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$handler = new RotatingFileHandler(APPPATH . "logs/auth/auth.log");

		$logger
			->pushHandler($handler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

}
