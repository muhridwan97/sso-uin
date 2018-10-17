<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Automate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (is_cli()) {
            echo 'Automate module is initiating...' . PHP_EOL;
        } else {
            echo "This module is CLI only!" . PHP_EOL;
            die();
        }
    }

    /**
     * Clean old temp upload files.
     * call in terminal: `php index.php automate clean-old-temp 14`
     *
     * @param int $age in days
     */
    public function clean_old_temp($age = 7)
    {
        $this->load->helper('directory');

        $path = './uploads/temp/';
        $map = directory_map($path, 1);
        $totalOldFiles = 0;
        $totalOldDirs = 0;
        $today = new DateTime();

        foreach ($map as $file) {
            if (is_dir($path . $file)) {
                $stat = stat($path . $file);
                $dirTimestamp = new DateTime(date("F d Y H:i:s.", $stat['mtime']));
                $dirInterval = $today->diff($dirTimestamp)->format('%R%a');
                if (intval($dirInterval) <= -$age) {
                    if (@rmdir($path . $file)) {
                        echo 'Directory: ' . ($path . $file) . ' was deleted' . PHP_EOL;
                        $totalOldDirs++;
                    }
                }
            }

            $fileTimestamp = new DateTime(date("F d Y H:i:s.", filectime($path . $file)));
            $interval = $today->diff($fileTimestamp)->format('%R%a');
            if (intval($interval) <= -$age && $file != '.gitkeep') {
                if (file_exists($path . $file)) {
                    if (@unlink($path . $file)) {
                        echo 'File: ' . ($path . $file) . ' was deleted' . PHP_EOL;
                        $totalOldFiles++;
                    }
                }
            }
        }
        echo $totalOldFiles . ' files and ' . $totalOldDirs . ' directories were deleted (more than ' . $age . ' days old)' . PHP_EOL;
    }
}