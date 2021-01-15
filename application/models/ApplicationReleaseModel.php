<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplicationReleaseModel extends App_Model
{
    protected $table = 'application_releases';

    const LABEL_DRAFT = 'DRAFT';
    const LABEL_ALPHA = 'ALPHA';
    const LABEL_BETA = 'BETA';
    const LABEL_RC = 'RC';
    const LABEL_RELEASE = 'RELEASE';

    const LABELS = [self::LABEL_DRAFT, self::LABEL_ALPHA, self::LABEL_BETA, self::LABEL_RC, self::LABEL_RELEASE];

    /**
     * Get base query of application release.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'prv_applications.title AS application_title',
                'CONCAT("v", major, ".", minor, ".", patch) AS version',
                'DATEDIFF(CURDATE(), release_date) AS release_age'
            ])
            ->join('prv_applications', 'prv_applications.id = application_releases.id_application');
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

            if (key_exists('application', $filters) && !empty($filters['application'])) {
                $baseQuery->where($this->table . '.id_application', $filters['application']);
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
                $baseQuery->order_by('created_at', 'desc');
                $baseQuery->order_by('version', 'desc');
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
}
