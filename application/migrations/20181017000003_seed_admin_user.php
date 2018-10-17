<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Seed_master_base
 * @property CI_DB_query_builder $db
 */
class Migration_Seed_admin_user extends CI_Migration
{
    public function up()
    {
        $this->db->insert('prv_users', [
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sso.app',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'status' => 'ACTIVATED'
        ]);

        echo '--Seeding Migration_Seed_admin_user' . PHP_EOL;
    }

    public function down()
    {
        $this->db->delete('prv_users', ['username' => 'admin']);
        echo 'Rollback Migration_Seed_admin_user' . PHP_EOL;
    }
}