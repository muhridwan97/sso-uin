<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_application_releases
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_application_releases extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_application' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'major' => ['type' => 'INT', 'unsigned' => TRUE],
            'minor' => ['type' => 'INT', 'unsigned' => TRUE, 'default' => 0],
            'patch' => ['type' => 'INT', 'unsigned' => TRUE, 'default' => 0],
            'label' => ['type' => 'VARCHAR', 'constraint' => 50],
            'attachment' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => TRUE],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'release_date' => ['type' => 'DATE'],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP']
        ])
            ->add_field('CONSTRAINT fk_application_release_application FOREIGN KEY (id_application) REFERENCES prv_applications(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('application_releases');
        echo 'Migrate Migration_Create_table_application_releases' . PHP_EOL;

    }

    public function down()
    {
        $this->dbforge->drop_table('application_releases', TRUE);
        echo 'Rollback Migration_Create_table_application_releases' . PHP_EOL;
    }
}