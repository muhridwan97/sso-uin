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
            'parent_users.name AS parent_user',
            'GROUP_CONCAT(DISTINCT prv_roles.role) AS roles'
        ])
            ->from($this->table)
            ->join('prv_users AS parent_users', 'parent_users.id = prv_users.id_user', 'left')
            ->join('prv_user_roles', 'prv_user_roles.id_user = prv_users.id', 'left')
            ->join('prv_roles', 'prv_roles.id = prv_user_roles.id_role', 'left')
            ->group_by('prv_users.id')
            ->order_by($this->id, 'desc');
    }

    /**
     * Get all data model.
     *
     * @param array $filters
     * @param bool $withTrashed
     * @return array|mixed
     */
    public function getAll($filters = [], $withTrashed = false)
    {
        $this->db->start_cache();

        $baseQuery = $this->getBaseQuery();

        if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
            $baseQuery->where($this->table . '.is_deleted', false);
        }

        if (!empty($filters)) {
            if (key_exists('query', $filters) && $filters['query']) {
                return $baseQuery;
            }

            if (key_exists('search', $filters) && !empty($filters['search'])) {
                $baseQuery->group_start();
                foreach ($this->filteredFields as $filteredField) {
                    if ($filteredField == '*') {
                        $fields = $this->db->list_fields($this->table);
                        foreach ($fields as $field) {
                            $baseQuery->or_like($this->table . '.' . $field, trim($filters['search']));
                        }
                    } else {
                        $baseQuery->or_like($filteredField, trim($filters['search']));
                    }
                }
                $baseQuery->group_end();
            }

            if (key_exists('statuses', $filters) && !empty($filters['statuses'])) {
                $baseQuery->where_in($this->table . '.status', $filters['statuses']);
            }

            if (key_exists('date_from', $filters) && !empty($filters['date_from'])) {
                $baseQuery->where($this->table . '.created_at>=', format_date($filters['date_from']));
            }

            if (key_exists('date_to', $filters) && !empty($filters['date_to'])) {
                $baseQuery->where($this->table . '.created_at<=', format_date($filters['date_to']));
            }

            if (key_exists('user_type', $filters) && !empty($filters['user_type'])) {
                $baseQuery->where('prv_users.user_type', $filters['user_type']);
            }

            if (key_exists('role', $filters) && !empty($filters['role'])) {
                $baseQuery->where('prv_roles.id', $filters['role']);
            }
        }
        $this->db->stop_cache();

        if (key_exists('per_page', $filters) && !empty($filters['per_page'])) {
            $perPage = $filters['per_page'];
        } else {
            $perPage = 25;
        }

        if (key_exists('page', $filters) && !empty($filters['page'])) {
            $currentPage = $filters['page'];

            $totalData = $this->db->count_all_results();

            if (key_exists('sort_by', $filters) && !empty($filters['sort_by'])) {
                if (key_exists('order_method', $filters) && !empty($filters['order_method'])) {
                    $baseQuery->order_by($filters['sort_by'], $filters['order_method']);
                } else {
                    $baseQuery->order_by($filters['sort_by'], 'asc');
                }
            } else {
                $baseQuery->order_by($this->table . '.' . $this->id, 'desc');
            }
            $pageData = $baseQuery->limit($perPage, ($currentPage - 1) * $perPage)->get()->result_array();

            $this->db->flush_cache();

            return [
                '_paging' => true,
                'total_data' => $totalData,
                'total_page_data' => count($pageData),
                'total_page' => ceil($totalData / $perPage),
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'data' => $pageData
            ];
        } else {
            $baseQuery->order_by($this->table . '.' . $this->id, 'desc');
        }

        $data = $baseQuery->get()->result_array();

        $this->db->flush_cache();

        return $data;
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
