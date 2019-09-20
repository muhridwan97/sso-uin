<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Seed_role_base
 * @property CI_DB_query_builder $db
 */
class Migration_Seed_initial_role_permission extends CI_Migration
{
    public function up()
    {
        $this->db->insert_batch('prv_permissions', [
            [
                'module' => 'admin', 'submodule' => 'admin', 'permission' => PERMISSION_ALL_ACCESS,
                'description' => 'Access all feature without specific rule'
            ],
            [
                'module' => 'setting', 'submodule' => 'account', 'permission' => PERMISSION_ACCOUNT_EDIT,
                'description' => 'Setting account profile'
            ],
            [
                'module' => 'setting', 'submodule' => 'application', 'permission' => PERMISSION_SETTING_EDIT,
                'description' => 'Setting application preference'
            ],

            [
                'module' => 'master', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_VIEW,
                'description' => 'View role data'
            ],
            [
                'module' => 'master', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_CREATE,
                'description' => 'Create new role'
            ],
            [
                'module' => 'master', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_EDIT,
                'description' => 'Edit role'
            ],
            [
                'module' => 'master', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_DELETE,
                'description' => 'Delete role'
            ],


            [
                'module' => 'master', 'submodule' => 'user', 'permission' => PERMISSION_USER_VIEW,
                'description' => 'View user data'
            ],
            [
                'module' => 'master', 'submodule' => 'user', 'permission' => PERMISSION_USER_CREATE,
                'description' => 'Create new user'
            ],
            [
                'module' => 'master', 'submodule' => 'user', 'permission' => PERMISSION_USER_EDIT,
                'description' => 'Edit user'
            ],
            [
                'module' => 'master', 'submodule' => 'user', 'permission' => PERMISSION_USER_DELETE,
                'description' => 'Delete user'
            ],

            [
                'module' => 'application', 'submodule' => 'application', 'permission' => PERMISSION_APPLICATION_VIEW,
                'description' => 'View application data'
            ],
            [
                'module' => 'application', 'submodule' => 'application', 'permission' => PERMISSION_APPLICATION_CREATE,
                'description' => 'Create new application'
            ],
            [
                'module' => 'application', 'submodule' => 'application', 'permission' => PERMISSION_APPLICATION_EDIT,
                'description' => 'Edit application'
            ],
            [
                'module' => 'application', 'submodule' => 'application', 'permission' => PERMISSION_APPLICATION_DELETE,
                'description' => 'Delete application'
            ],

            [
                'module' => 'application', 'submodule' => 'release', 'permission' => PERMISSION_RELEASE_VIEW,
                'description' => 'View release data'
            ],
            [
                'module' => 'application', 'submodule' => 'release', 'permission' => PERMISSION_RELEASE_CREATE,
                'description' => 'Create new release'
            ],
            [
                'module' => 'application', 'submodule' => 'release', 'permission' => PERMISSION_RELEASE_EDIT,
                'description' => 'Edit release'
            ],
            [
                'module' => 'application', 'submodule' => 'release', 'permission' => PERMISSION_RELEASE_DELETE,
                'description' => 'Delete release'
            ],

        ]);

        echo '--Seeding Migration_Seed_initial_role_permission' . PHP_EOL;
    }

    public function down()
    {
        $this->db->delete('prv_permissions', ['module' => 'admin']);
        $this->db->delete('prv_permissions', ['module' => 'setting']);
        $this->db->delete('prv_permissions', ['module' => 'master']);
        $this->db->delete('prv_permissions', ['module' => 'application']);
        echo 'Rollback Migration_Seed_initial_role_permission' . PHP_EOL;
    }
}