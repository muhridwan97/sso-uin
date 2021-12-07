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
	 * @return Logger
	 */
	public static function default($name = null)
	{
		$logger = new Logger(if_empty($name, AppLogger::class));

		$accessHandler = new RotatingFileHandler(APPPATH . "logs/access/app.log", 0, Logger::DEBUG, true, 0646);
		$errorHandler = new StreamHandler(APPPATH . "logs/errors/error.log", Logger::ERROR);

		$logger
			->pushHandler($accessHandler)
			->pushHandler($errorHandler)
			->pushHandler(new StreamHandler("php://stdout"))
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

		$handler = new RotatingFileHandler(APPPATH . "logs/auth/auth.log", 0, Logger::DEBUG, true, 0646);

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

		$handler = new RotatingFileHandler(APPPATH . "logs/database/dml.log", 0, Logger::DEBUG, true, 0646);

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

		$handler = new RotatingFileHandler(APPPATH . "logs/database/dql.log", 0, Logger::DEBUG, true, 0646);

		$logger
			->pushHandler($handler)
			->pushProcessor(new WebProcessor());

		return $logger;
	}

}
