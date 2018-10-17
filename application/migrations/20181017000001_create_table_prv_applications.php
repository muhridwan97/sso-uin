<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_prv_applications
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_prv_applications extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'title' => ['type' => 'VARCHAR', 'constraint' => 50],
            'color' => ['type' => 'VARCHAR', 'constraint' => 50],
            'icon' => ['type' => 'VARCHAR', 'constraint' => 300],
            'url' => ['type' => 'VARCHAR', 'constraint' => 500],
            'order' => ['type' => 'INT', 'unsigned' => TRUE],
            'version' => ['type' => 'VARCHAR', 'constraint' => 50],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'is_deleted' => ['type' => 'INT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_by'=> ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE]
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('prv_applications');
        echo 'Migrate Migration_Create_table_prv_applications' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('prv_applications');
        echo 'Rollback Migration_Create_table_prv_applications' . PHP_EOL;
    }
}