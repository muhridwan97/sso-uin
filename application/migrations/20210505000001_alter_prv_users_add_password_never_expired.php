<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_prv_users_add_password_never_expired
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_prv_users_add_password_never_expired extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('prv_users', [
            'password_never_expired' => ['type' => 'INT', 'constraint' => 1, 'after' => 'password_expired_at', 'default' => 0],
        ]);

        echo 'Migrate Migration_Alter_prv_users_add_password_never_expired' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_column('prv_users', 'password_never_expired');
        echo 'Rollback Migration_Alter_prv_users_add_password_never_expired' . PHP_EOL;
    }
}
