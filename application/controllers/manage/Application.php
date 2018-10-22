<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Application
 * @property ApplicationModel $application
 * @property ApplicationReleaseModel $applicationRelease
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

        if(AuthModel::loginData('username') != 'admin')
            flash('danger', 'You unauthorized to access the page', '_back', 'app');

        $this->load->model('ApplicationModel', 'application');
        $this->load->model('ApplicationReleaseModel', 'applicationRelease');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Set validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'title' => 'trim|required|max_length[50]',
            'color' => 'trim|required|max_length[50]',
            'icon' => 'trim|required|max_length[50]',
            'url' => 'trim|required|valid_url|max_length[50]',
            'order' => 'trim|required|is_natural_no_zero',
            'version' => 'trim|required|max_length[20]|regex_match[/^[vV]\d+\.\d+(\.\d+)?/]',
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
            $applicationId = $this->db->insert_id();

            $reorderApps = $this->application->getBy(['order>=' => $order]);
            foreach ($reorderApps as $reorderStage) {
                $this->application->update(['order' => ++$order], $reorderStage['id']);
            }

            $versions = preg_replace('/[vV]/', '', $version);
            $versions = explode('.', $versions);

            $this->applicationRelease->create([
                'id_application' => $applicationId,
                'major' => if_empty($versions[0], 0),
                'minor' => if_empty($versions[1], 0),
                'patch' => if_empty($versions[2], 0),
                'description' => 'Initial release',
                'label' => ApplicationReleaseModel::LABEL_RELEASE,
                'release_date' => format_date('now')
            ]);

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