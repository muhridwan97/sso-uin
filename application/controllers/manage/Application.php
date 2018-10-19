<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Application
 * @property ApplicationModel $application
 * @property Uploader $uploader
 * @property Exporter $exporter
 */
class Application extends App_Controller
{
    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('ApplicationModel', 'application');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Set validation rules.
     *
     * @param int $applicationId
     * @return array
     */
    protected function _validation_rules($applicationId = 0)
    {
        return [
            'title' => 'trim|required|max_length[50]',
            'color' => 'trim|required|max_length[50]',
            'icon' => 'trim|required|max_length[50]',
            'url' => 'trim|required|valid_url|max_length[50]',
            'order' => 'trim|required|is_natural_no_zero',
            'version' => 'trim|required|max_length[20]',
            'description' => 'trim|required|max_length[35]',
        ];
    }

    /**
     * Show application data.
     */
    public function index()
    {
        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $applications = $this->application->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Application', $applications);
        }

        $this->render('application/index', compact('applications'));
    }

    /**
     * Show data application.
     *
     * @param $id
     */
    public function view($id)
    {
        $application = $this->application->getById($id);

        $this->render('application/view', compact('application'));
    }

    /**
     * Show form create application.
     */
    public function create()
    {
        $applications = $this->application->getAll();

        $this->render('application/create', compact('applications'));
    }

    /**
     * Save application data.
     */
    public function save()
    {
        if ($this->validate()) {
            $title = $this->input->post('title');
            $version = $this->input->post('version');
            $description = $this->input->post('description');
            $url = $this->input->post('url');
            $order = $this->input->post('order');
            $color = $this->input->post('color');
            $icon = $this->input->post('icon');

            $this->db->trans_start();


            $this->application->create([
                'title' => $title,
                'version' => $version,
                'description' => $description,
                'url' => $url,
                'order' => $order,
                'color' => $color,
                'icon' => $icon,
            ]);

            $reorderApps = $this->application->getBy(['order>=' => $order]);
            foreach ($reorderApps as $reorderStage) {
                $this->application->update(['order' => ++$order], $reorderStage['id']);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', __('entity_created', ['title' => $title]), 'manage/application');
            } else {
                flash('danger', __('entity_error'));
            }
        }
        $this->create();
    }

    /**
     * Show form edit application.
     *
     * @param $id
     */
    public function edit($id)
    {
        $applications = $this->application->getAll();
        $application = $this->application->getById($id);

        $this->render('application/edit', compact('application', 'applications'));
    }

    /**
     * Save updated application data.
     *
     * @param $id
     */
    public function update($id)
    {
        if ($this->validate()) {
            $title = $this->input->post('title');
            $version = $this->input->post('version');
            $description = $this->input->post('description');
            $url = $this->input->post('url');
            $order = $this->input->post('order');
            $color = $this->input->post('color');
            $icon = $this->input->post('icon');

            $application = $this->application->getById($id);

            $this->db->trans_start();

            $this->application->update([
                'title' => $title,
                'version' => $version,
                'description' => $description,
                'url' => $url,
                'order' => $order,
                'color' => $color,
                'icon' => $icon,
            ], $id);

            if ($application['order'] != $order) {
                $reorderApps = $this->application->getBy(['order>=' => $order, 'id!=' => $id]);
                foreach ($reorderApps as $reorderStage) {
                    $this->application->update(['order' => ++$order], $reorderStage['id']);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', __('entity_updated', ['title' => $title]), 'manage/application');
            } else {
                flash('danger', __('entity_error'));
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting application data.
     *
     * @param $id
     */
    public function delete($id)
    {
        $application = $this->application->getById($id);

        $this->db->trans_start();

        $this->application->delete($id);

        $applications = $this->application->getAll();

        $order = 1;
        foreach ($applications as $application) {
            $this->application->update(['order' => $order++], $application['id']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            flash('success', __('entity_deleted', ['title' => $application['title']]));
        } else {
            flash('danger', __('entity_error'));
        }

        redirect('manage/application');
    }

}