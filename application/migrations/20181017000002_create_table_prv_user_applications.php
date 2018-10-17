<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_prv_roles
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_prv_user_applications extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'id_application' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'is_default' => ['type' => 'INT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP']
        ])
            ->add_field('CONSTRAINT fk_user_application_user FOREIGN KEY (id_user) REFERENCES prv_users(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_user_application_application FOREIGN KEY (id_application) REFERENCES prv_applications(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('prv_user_applications');
        echo 'Migrate Migration_Create_table_prv_user_applications' . PHP_EOL;

    }

    public function down()
    {
        $this->dbforge->drop_table('prv_user_applications', TRUE);
        echo 'Rollback Migration_Create_table_prv_user_applications' . PHP_EOL;
    }
}