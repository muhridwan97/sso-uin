<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Release
 * @property ApplicationModel $application
 * @property ApplicationReleaseModel $applicationRelease
 * @property Uploader $uploader
 * @property Exporter $exporter
 */
class Release extends App_Controller
{
    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('ApplicationModel', 'application');
        $this->load->model('ApplicationReleaseModel', 'applicationRelease');
        $this->load->model('modules/Uploader', 'uploader');
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
            'application' => 'trim|required',
            'major' => 'trim|required|is_natural',
            'minor' => 'trim|required|is_natural',
            'patch' => 'trim|required|is_natural',
            'label' => 'trim|required|max_length[50]',
            'description' => 'trim|required|min_length[20]',
            'release_date' => 'trim|required',
        ];
    }

    /**
     * Show application data.
     */
    public function index()
    {
        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($this->input->get('export')) unset($filters['page']);

        $applicationReleases = $this->applicationRelease->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Release', $applicationReleases);
        }

        $this->render('release/index', compact('applicationReleases'));
    }

    /**
     * Show data application release.
     *
     * @param $id
     */
    public function view($id)
    {
        $applicationRelease = $this->applicationRelease->getById($id);

        $this->render('release/view', compact('applicationRelease'));
    }

    /**
     * Show form create application release.
     */
    public function create()
    {
        $applications = $this->application->getAll();

        $this->render('release/create', compact('applications'));
    }

    /**
     * Save application release data.
     */
    public function save()
    {
        if ($this->validate()) {
            $applicationId = $this->input->post('application');
            $major = $this->input->post('major');
            $minor = $this->input->post('minor');
            $patch = $this->input->post('patch');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $releaseDate = $this->input->post('release_date');
            $version = 'v' . $major . '.' . $minor . '.' . $patch;

            $this->db->trans_start();

            $attachment = null;
            if (!empty($_FILES['attachment']['name'])) {
                if ($this->uploader->uploadTo('attachment', ['destination' => 'releases/' . date('Y/m')])) {
                    $uploadedData = $this->uploader->getUploadedData();
                    $attachment = $uploadedData['uploaded_path'];
                } else {
                    flash('danger', $this->uploader->getDisplayErrors(), '_back');
                }
            }

            $this->applicationRelease->create([
                'id_application' => $applicationId,
                'major' => $major,
                'minor' => $minor,
                'patch' => $patch,
                'label' => $label,
                'attachment' => $attachment,
                'description' => $description,
                'release_date' => format_date($releaseDate),
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', __('entity_created', ['title' => $version]), 'manage/release');
            } else {
                flash('danger', __('entity_error'));
            }
        }
        $this->create();
    }

    /**
     * Show form edit application release.
     *
     * @param $id
     */
    public function edit($id)
    {
        $applications = $this->application->getAll();
        $applicationRelease = $this->applicationRelease->getById($id);

        $this->render('release/edit', compact('applications', 'applicationRelease'));
    }

    /**
     * Save updated application release data.
     *
     * @param $id
     */
    public function update($id)
    {
        if ($this->validate()) {
            $applicationId = $this->input->post('application');
            $major = $this->input->post('major');
            $minor = $this->input->post('minor');
            $patch = $this->input->post('patch');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $releaseDate = $this->input->post('release_date');

            $release = $this->applicationRelease->getById($id);

            $this->db->trans_start();

            $attachment = if_empty($release['attachment'], null);
            if (!empty($_FILES['attachment']['name'])) {
                if ($this->uploader->uploadTo('attachment', ['destination' => 'releases/' . date('Y/m')])) {
                    $uploadedData = $this->uploader->getUploadedData();
                    $attachment = $uploadedData['uploaded_path'];
                    if (!empty($release['attachment'])) {
                        $this->uploader->delete($release['attachment']);
                    }
                } else {
                    flash('danger', $this->uploader->getDisplayErrors(), '_back');
                }
            }

            $this->applicationRelease->update([
                'id_application' => $applicationId,
                'major' => $major,
                'minor' => $minor,
                'patch' => $patch,
                'label' => $label,
                'attachment' => $attachment,
                'description' => $description,
                'release_date' => format_date($releaseDate),
            ], $id);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $release = $this->applicationRelease->getById($id);
                flash('success', __('entity_updated', ['title' => $release['version']]), 'manage/release');
            } else {
                flash('danger', __('entity_error'));
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting application release data.
     *
     * @param $id
     */
    public function delete($id)
    {
        $release = $this->applicationRelease->getById($id);

        if ($this->applicationRelease->delete($id)) {
            flash('success', __('entity_deleted', ['title' => $release['version']]));
        } else {
            flash('danger', __('entity_error'));
        }

        redirect('manage/release');
    }

}