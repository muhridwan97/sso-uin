<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Seed_setting_password_expiration_days
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Seed_setting_password_expiration_days extends CI_Migration
{
    public function up()
    {
        $this->db->insert_batch('settings', [
            [
                'key' => 'password_expiration_days',
                'description' => 'Expired day after last changing password'
            ],
            [
                'key' => 'email_verification_after_password_expired_days',
                'description' => 'User must verification their account when password expired'
            ],
            [
                'key' => 'auto_suspended_inactive_days',
                'description' => 'Auto suspended when no login in days'
            ],
        ]);

        echo '--Seeding Migration_Seed_setting_password_expiration_days' . PHP_EOL;
    }

    public function down()
    {
        $this->db->delete('settings', ['key' => 'password_expiration_days']);
        $this->db->delete('settings', ['key' => 'email_verification_after_password_expired_days']);
        echo 'Rollback Migration_Seed_setting_password_expiration_days' . PHP_EOL;
    }
}
