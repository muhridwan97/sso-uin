<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRoleModel extends App_Model
{
    protected $table = 'prv_user_roles';

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'prv_roles.role',
            ])
            ->join('prv_roles', 'prv_roles.id = prv_user_roles.id_role', 'left');
    }
}