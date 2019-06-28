<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Model extends CI_Model
{
    protected $table = '';
    protected $id = 'id';
    protected $filteredFields = ['*'];
    protected $filteredMaps = [];

    /**
     * Set field to filtered list.
     *
     * @param $fields
     */
    protected function addFilteredField($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if (!in_array($field, $this->filteredFields)) {
                    $this->filteredFields[] = $field;
                }
            }
        } else {
            if (!in_array($fields, $this->filteredFields)) {
                $this->filteredFields[] = $fields;
            }
        }
    }

    /**
     * Set field to map as filter list.
     *
     * @param $key
     * @param $field
     */
    protected function addFilteredMap($key, $field)
    {
        $this->filteredMaps[$key] = $field;
    }

    /**
     * Get base query of table.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return $this->db->select([$this->table . '.*'])->from($this->table);
    }

    /**
     * Get all data model.
     *
     * @param array $filters
     * @param bool $withTrashed
     * @return mixed
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
                foreach ($this->filteredFields as $filteredField) {
                    if ($filteredField == '*') {
                        $fields = $this->db->list_fields($this->table);
                        foreach ($fields as $field) {
                            $baseQuery->or_having($this->table . '.' . $field . ' LIKE', '%' . trim($filters['search']) . '%');
                        }
                    } else {
                        $baseQuery->or_having($filteredField . ' LIKE', '%' . trim($filters['search']) . '%');
                    }
                }
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

            if (key_exists('date_from', $filters) && !empty($filters['date_from'])) {
                if ($this->db->field_exists('created_at', $this->table)) {
                    $baseQuery->where($this->table . '.created_at>=', format_date($filters['date_from']));
                }
            }

            if (key_exists('date_to', $filters) && !empty($filters['date_to'])) {
                if ($this->db->field_exists('created_at', $this->table)) {
                    $baseQuery->where($this->table . '.created_at<=', format_date($filters['date_to']));
                }
            }

            if (!empty($this->filteredMaps)) {
                foreach ($this->filteredMaps as $filterKey => $filterField) {
                    if (key_exists($filterKey, $filters) && !empty($filters[$filterKey])) {
                        $baseQuery->where_in($filterField, $filters[$filterKey]);
                    }
                }
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

            //$totalData = $this->db->count_all_results();

            $querySelect = $this->db->get_compiled_select();
            $totalQuery = $this->db->query("SELECT COUNT(*) AS total_record FROM ({$querySelect}) AS report");
            $totalRows = $totalQuery->row_array();
            if (!empty($totalRows)) {
                $totalData = $totalRows['total_record'];
            } else {
                $totalData = 0;
            }

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
        }

        if (key_exists('sort_by', $filters) && !empty($filters['sort_by'])) {
            if (key_exists('order_method', $filters) && !empty($filters['order_method'])) {
                $baseQuery->order_by($filters['sort_by'], $filters['order_method']);
            } else {
                $baseQuery->order_by($filters['sort_by'], 'asc');
            }
        } else {
            $baseQuery->order_by($this->table . '.' . $this->id, 'desc');
        }

        $data = $baseQuery->get()->result_array();

        $this->db->flush_cache();

        return $data;
    }

    /**
     * Get single model data by id with or without deleted record.
     *
     * @param $modelId
     * @param bool $withTrashed
     * @return mixed
     */
    public function getById($modelId, $withTrashed = false)
    {
        $baseQuery = $this->getBaseQuery();

        $baseQuery->where($this->table . '.' . $this->id, $modelId);

        if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
            $baseQuery->where($this->table . '.is_deleted', false);
        }

        return $baseQuery->get()->row_array();
    }

    /**
     * Get data by custom condition.
     *
     * @param $conditions
     * @param bool $resultRow
     * @param bool $withTrashed
     * @return array
     */
    public function getBy($conditions, $resultRow = false, $withTrashed = false)
    {
        $baseQuery = $this->getBaseQuery()->order_by($this->table . '.id', 'asc');

        $baseQuery->where($conditions);

        if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
            $baseQuery->where($this->table . '.is_deleted', false);
        }

        if ($resultRow) {
            return $baseQuery->get()->row_array();
        }

        return $baseQuery->get()->result_array();
    }

    /**
     * Ser
     * @param $keyword
     * @param int $limit
     * @param bool $withTrashed
     * @return array
     */
    public function search($keyword, $limit = 10, $withTrashed = false)
    {
        $baseQuery = $this->getBaseQuery();

        foreach ($this->filteredFields as $filteredField) {
            if ($filteredField == '*') {
                $fields = $this->db->list_fields($this->table);
                foreach ($fields as $field) {
                    $baseQuery->or_having($this->table . '.' . $field . ' LIKE', '%' . trim($keyword) . '%');
                }
            } else {
                $baseQuery->or_having($filteredField . ' LIKE', '%' . trim($keyword) . '%');
            }
        }

        if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
            $baseQuery->where($this->table . '.is_deleted', false);
        }

        if (!empty($limit)) {
            $baseQuery->limit($limit);
        }

        return $baseQuery->get()->result_array();
    }

    /**
     * Get total model data.
     *
     * @param bool $withTrashed
     * @return int
     */
    public function getTotal($withTrashed = false)
    {
        $query = $this->db->from($this->table);

        if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
            $query->where($this->table . '.is_deleted', false);
        }

        return $query->count_all_results();
    }

    /**
     * Create new model.
     *
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        if (key_exists(0, $data) && is_array($data[0])) {
            $hasCreatedBy = $this->db->field_exists('created_by', $this->table);
            $hasCreatedAt = $this->db->field_exists('created_at', $this->table);
            foreach ($data as &$datum) {
                if ($hasCreatedBy) {
                    $datum['created_by'] = AuthModel::loginData('id', 0);
                }
                if ($hasCreatedAt) {
                    $datum['created_at'] = date('Y-m-d H:i:s');
                }
            }
            return $this->db->insert_batch($this->table, $data);
        }
        if ($this->db->field_exists('created_by', $this->table)) {
            $data['created_by'] = AuthModel::loginData('id', 0);
        }
        if ($this->db->field_exists('created_at', $this->table)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update model.
     *
     * @param $data
     * @param $id
     * @return bool
     */
    public function update($data, $id)
    {
        $condition = is_null($id) ? null : [$this->id => $id];
        if (is_array($id)) {
            $condition = $id;
        }
        if ($this->db->field_exists('updated_by', $this->table)) {
            $data['updated_by'] = AuthModel::loginData('id', 0);
        }
        if ($this->db->field_exists('updated_at', $this->table)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->update($this->table, $data, $condition);
    }

    /**
     * Delete model data.
     *
     * @param int|array $id
     * @param bool $softDelete
     * @return bool
     */
    public function delete($id, $softDelete = false)
    {
        if ($softDelete && $this->db->field_exists('is_deleted', $this->table)) {
            return $this->db->update($this->table, [
                'is_deleted' => true,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => AuthModel::loginData('id')
            ], (is_array($id) ? $id : [$this->id => $id]));
        }
        return $this->db->delete($this->table, (is_array($id) ? $id : [$this->id => $id]));
    }

}