<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends App_Model
{
    protected $table = 'prv_users';

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
        ])
            ->from($this->table)
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
        $currentPage = 1;
        $perPage = 15;

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

            if (key_exists('status', $filters) && !empty($filters['status'])) {
                if ($this->db->field_exists('status', $this->table)) {
                    $baseQuery->where($this->table . '.status', $filters['status']);
                }
            }

            if (key_exists('users', $filters) && !empty($filters['users'])) {
                if ($this->db->field_exists('id_user', $this->table)) {
                    $baseQuery->where_in($this->table . '.id_user', $filters['users']);
                }
            }

            if (key_exists('page', $filters) && !empty($filters['page'])) {
                $currentPage = $filters['page'];
            }

            if (key_exists('per_page', $filters) && !empty($filters['per_page'])) {
                $perPage = $filters['per_page'];
            }
        }
        $this->db->stop_cache();

        if (key_exists('page', $filters) && !empty($filters['page'])) {
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
