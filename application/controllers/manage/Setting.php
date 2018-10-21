<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting
 * @property SettingModel $setting
 */
class Setting extends App_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('SettingModel', 'setting');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        if (_is_method('put')) {
            if ($this->validate()) {
                $settings = $this->input->post();

                $this->db->trans_start();

                if(key_exists('_method', $settings)) {
                    unset($settings['_method']);
                }

                foreach ($settings as $key => $value) {
                    $this->setting->update(['value' => $value], $key);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status()) {
                    flash('success', 'Settings successfully updated', 'manage/setting');
                } else {
                    flash('danger', __('entity_error'));
                }
            }
        }

        $setting = $this->setting->getAll();

        $this->render('setting/index', compact('setting'));
    }

    /**
     * General validation rule.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'meta_keywords' => 'trim|required|max_length[300]|regex_match[/^[a-zA-Z\-,]+$/]',
            'meta_description' => 'trim|required|max_length[300]',
            'email_bug_report' => 'trim|required|max_length[50]',
            'email_support' => 'trim|required|max_length[50]',
        ];
    }
}
