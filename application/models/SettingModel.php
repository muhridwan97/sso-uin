<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingModel extends App_Model
{
    protected $table = 'settings';
    protected $id = 'key';

    /**
     * Retrieve all configuration keys.
     *
     * @param array $filters
     * @param bool $withTrashed
     * @return array
     */
    public function getAll($filters = [], $withTrashed = false)
    {
        $settings = $this->db->get($this->table)->result_array();
        $dataSettings = [];
        foreach ($settings as $data) {
            $dataSettings[$data['key']] = $data['value'];
        }
        return $dataSettings;
    }

    /**
     * Get single setting key.
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getByKey($key, $default = '')
    {
        $settings = $this->getAll();
        if (key_exists($key, $settings)) {
            return $settings[$key];
        }
        return $default;
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

        // create if setting key doesn't exist
        $setting = $this->getBy($condition, true);
        if(empty($setting)) {
            $data[$this->id] = $id;
            return $this->create($data);
        }

        if ($this->db->field_exists('updated_by', $this->table)) {
            $data['updated_by'] = AuthModel::loginData('id', 0);
        }
        if ($this->db->field_exists('updated_at', $this->table)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->update($this->table, $data, $condition);
    }
}