<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_prv_users_add_password_expired_at
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_prv_users_add_password_expired_at extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('prv_users', [
            'password_expired_at' => ['type' => 'DATETIME', 'after' => 'last_logged_in', 'null' => true],
        ]);

        echo 'Migrate Migration_Alter_prv_users_add_password_expired_at' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_column('prv_users', 'password_expired_at');
        echo 'Rollback Migration_Alter_prv_users_add_password_expired_at' . PHP_EOL;
    }
}
