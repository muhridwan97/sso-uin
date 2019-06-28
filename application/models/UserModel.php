<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends App_Model
{
    protected $table = 'prv_users';
    protected $filteredMaps = ['user_type' => 'prv_users.user_type'];

    const STATUS_PENDING = 'PENDING';
    const STATUS_ACTIVATED = 'ACTIVATED';
    const STATUS_SUSPENDED = 'SUSPENDED';

    /**
     * Get base query of table.
     *
     * @return CI_DB_query_builder
     */
    public function getBaseQuery()
    {
        return $this->db->select([
            'prv_users.*',
            'parent_users.name AS parent_user'
        ])
            ->from($this->table)
            ->join('prv_users AS parent_users', 'parent_users.id = prv_users.id_user', 'left')
            ->order_by($this->id, 'desc');
    }

    /**
     * Check if given email is unique.
     *
     * @param $email
     * @param int $exceptId
     * @return bool
     */
    public function isUniqueEmail($email, $exceptId = 0)
    {
        $user = $this->db->get_where($this->table, [
            'email' => $email,
            'id != ' => $exceptId
        ]);

        if ($user->num_rows() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Check if given username is unique.
     *
     * @param $username
     * @param int $exceptId
     * @return bool
     */
    public function isUniqueUsername($username, $exceptId = 0)
    {
        $user = $this->db->get_where($this->table, [
            'username' => $username,
            'id != ' => $exceptId
        ]);

        if ($user->num_rows() > 0) {
            return false;
        }
        return true;
    }
}
