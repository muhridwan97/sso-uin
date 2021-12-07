<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Automate
 * @property UserModel $user
 */
class Automate extends CI_Controller
{
	private $logger;

	public function __construct()
	{
		parent::__construct();
		$this->logger = AppLogger::default(Automate::class);

		if (is_cli()) {
			$this->logger->info("Automate module is initiating");
		} else {
			$this->logger->warning("This module is CLI only!");
			die();
		}

		$this->load->model('UserModel', 'user');
	}

	/**
	 * Clean old temp upload files.
	 * call in terminal: `php index.php automate clean-old-temp 14`
	 *
	 * @param int $age in days
	 * @throws Exception
	 */
	public function clean_old_temp($age = 7)
	{
		$this->logger->info("Automate:clean_old_temp({$age}) is started");

		$this->load->helper('directory');

		$path = './uploads/temp/';
		$map = directory_map($path, 1);
		$totalOldFiles = 0;
		$totalOldDirs = 0;
		$today = new DateTime();

		$this->logger->info("Directory list", is_array($map) ? $map : [$map]);

		foreach ($map as $file) {
			if (is_dir($path . $file)) {
				$stat = stat($path . $file);
				$dirTimestamp = new DateTime(date("F d Y H:i:s.", $stat['mtime']));
				$dirInterval = $today->diff($dirTimestamp)->format('%R%a');
				if (intval($dirInterval) <= -$age) {
					if (@rmdir($path . $file)) {
						$this->logger->warning('Directory: ' . ($path . $file) . ' was deleted');
						$totalOldDirs++;
					}
				}
			}

			$fileTimestamp = new DateTime(date("F d Y H:i:s.", filectime($path . $file)));
			$interval = $today->diff($fileTimestamp)->format('%R%a');
			if (intval($interval) <= -$age && $file != '.gitkeep') {
				if (file_exists($path . $file)) {
					if (@unlink($path . $file)) {
						$this->logger->warning('File: ' . ($path . $file) . ' was deleted');
						$totalOldFiles++;
					}
				}
			}
		}
		$this->logger->info($totalOldFiles . ' files and ' . $totalOldDirs . ' directories were deleted (more than ' . $age . ' days old)');
		$this->logger->info("Automate:clean_old_temp({$age}) is completed");
	}

	/**
	 * Suspend inactive users.
	 */
	public function auto_suspend_inactive_users()
	{
		$autoSuspend = get_setting('auto_suspended_inactive_days');
		if ($autoSuspend > 0) {
			$this->user->update(['status' => UserModel::STATUS_SUSPENDED], [
				'user_type' => 'EXTERNAL',
				'NOW() > DATE_ADD(IFNULL(last_logged_in, created_at), INTERVAL ' . $autoSuspend . ' DAY)' => null
			]);
			echo $this->db->affected_rows() . ' users suspended';
		}
	}
}
