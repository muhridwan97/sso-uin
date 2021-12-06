<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
	private $logger;

    public function __construct()
    {
        parent::__construct();
        $this->logger = AppLogger::default(Migrate::class);

        if (is_cli()) {
			$this->logger->info("Migration module is initiating");
            echo 'Migration module is initiating...' . PHP_EOL;
        } else {
			$this->logger->warning("This module is CLI only!");
            echo "This module is CLI only!" . PHP_EOL;
            die();
        }
        $this->load->dbforge();
    }

    /**
     * Create new database by config value.
     * @param bool $dropOldDb
     */
    public function init($dropOldDb = true)
    {
        $dbName = $this->db->database;
        if ($dropOldDb) {
            $this->dbforge->drop_database($dbName);
        }
        $this->dbforge->create_database($dbName);

        $this->db = $this->load->database('default', true);

		$this->logger->info("Migration init database");
    }

    /**
     * Run migration to latest version.
     */
    public function index()
    {
		$this->logger->info('Migration is started');
        $this->load->library('migration');
        if ($this->migration->latest() === FALSE) {
			$this->logger->error($this->migration->error_string());
            show_error($this->migration->error_string());
        } else {
			$this->logger->info('Migration is completed');
            echo 'Migration complete.' . PHP_EOL;
        }
    }

    /**
     * Run migration to specific version.
     * @param $target_version
     */
    public function to($target_version = null)
    {
		$this->logger->info('Migration to ' . $target_version . ' is started');
        $this->load->library('migration');
        if (is_null($target_version)) {
			$this->logger->error('Missing argument version migration');
            echo 'Missing argument version migration.' . PHP_EOL;
        } else {
            if ($this->migration->version($target_version) === FALSE) {
				$this->logger->error($this->migration->error_string());
                show_error($this->migration->error_string());
            } else {
				$this->logger->info('Migration to version ' . $target_version . ' is completed');
                echo 'Migration to version ' . $target_version . ' complete.' . PHP_EOL;
            }
        }
    }

    /**
     * Rollback migration version.
     */
    public function rollback()
    {
		$this->logger->info('Migration rollback is started');
        $this->load->library('migration');
        if ($this->migration->version(0) === FALSE) {
			$this->logger->error($this->migration->error_string());
            show_error($this->migration->error_string());
        } else {
			$this->logger->info('Rollback database is completed');
            echo 'Rollback database complete.' . PHP_EOL;
        }
    }

    /**
     * Rollback and migrate database.
     */
    public function reset()
    {
		$this->logger->info('Migration reset is started');
        $this->rollback();
        $this->index();
		$this->logger->info('Migration reset is completed');
    }

    /**
     * Recreating database and migrate.
     */
    public function fresh()
    {
		$this->logger->info('Migration refresh is started');
        $this->init();
        $this->index();
		$this->logger->info('Migration refresh is completed');
    }
}
