<?php

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class AppLogger
{
	/**
	 * Get default logger.
	 *
	 * @param null $name
	 * @param bool $includeStdOut
	 * @return Logger
	 */
	public static function default($name = null, $includeStdOut = true)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$accessHandler = new RotatingFileHandler(APPPATH . "logs/access/app.log", 0, Logger::DEBUG, true, 0666);
		$errorHandler = new RotatingFileHandler(APPPATH . "logs/errors/error.log", 0, Logger::ERROR, true, 0666);

		$logger
			->pushHandler($accessHandler)
			->pushHandler($errorHandler)
			->pushProcessor(new WebProcessor());

		if ($includeStdOut) {
			$logger->pushHandler(new StreamHandler("php://stdout"));
		}

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

		$handler = new RotatingFileHandler(APPPATH . "logs/auth/auth.log", 0, Logger::DEBUG, true, 0666);

		$logger
			->pushHandler($handler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

	/**
	 * Get database insert, update, delete logger.
	 *
	 * @param null $name
	 * @return Logger
	 */
	public static function databaseDML($name = null)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$handler = new RotatingFileHandler(APPPATH . "logs/database/dml.log", 0, Logger::DEBUG, true, 0666);

		$logger
			->pushHandler($handler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

	/**
	 * Get database select logger.
	 *
	 * @param null $name
	 * @return Logger
	 */
	public static function databaseDQL($name = null)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$handler = new RotatingFileHandler(APPPATH . "logs/database/dql.log", 0, Logger::DEBUG, true, 0666);

		$logger
			->pushHandler($handler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

}
