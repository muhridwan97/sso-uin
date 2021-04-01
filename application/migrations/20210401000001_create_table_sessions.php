<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_sessions
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_sessions extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'VARCHAR', 'constraint' => '128'],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => '45'],
            'id_user' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE, 'default' => 0],
            'timestamp' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'default' => 0],
            'data' => ['type' => 'BLOB'],
            'user_agent' => ['type' => 'TEXT', 'null' => TRUE],
            'is_mobile' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'null' => TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('sessions');
        echo 'Migrating Migration_Create_table_sessions' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('sessions',TRUE);
        echo 'Rollback Migration_Create_table_sessions' . PHP_EOL;
    }
}
