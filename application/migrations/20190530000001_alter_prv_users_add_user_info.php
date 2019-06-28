<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_prv_users_add_user_info extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('prv_users', [
            'device_id' => ['type' => 'VARCHAR', 'constraint' => '500', 'after' => 'status', 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => '50', 'after' => 'device_id', 'null' => true],
            'last_logged_in' => ['type' => 'DATETIME', 'after' => 'ip_address', 'null' => true],
        ]);

        echo 'Migrate Migration_Alter_prv_users_add_user_info' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_column('prv_users', 'device_id');
        $this->dbforge->drop_column('prv_users', 'ip_address');
        $this->dbforge->drop_column('prv_users', 'last_logged_in');
        echo 'Rollback Migration_Alter_prv_users_add_user_info' . PHP_EOL;
    }
}