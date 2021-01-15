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

        $this->setFilterMethods([
            'change_logs' => 'GET',
            'ajax_get_last_version' => 'GET'
        ]);
    }

    /**
     * Set validation rules.
     *
     * @param int $applicationReleaseId
     * @return array
     */
    protected function _validation_rules($applicationReleaseId = 0)
    {
        $major = $this->input->post('major');
        $minor = $this->input->post('minor');
        $patch = $this->input->post('patch');
        $label = $this->input->post('label');
        $applicationId = [
            'id_application' => $this->input->post('application'),
            'application_releases.id!=' => $applicationReleaseId
        ];
        $lastReleased = $this->applicationRelease->getBy($applicationId, true);

        return [
            'application' => [
                'trim', 'required', ['version_behind', function ($field) use ($lastReleased, $major, $minor, $patch, $label, $applicationReleaseId) {
                    if($applicationReleaseId == 0) {
                        $this->form_validation->set_message('version_behind', 'Version before latest version is not allowed, set new version number or version label.');
                        $currentVersion = intval($major . $minor . $patch);
                        $latestVersion = intval($lastReleased['major'] . $lastReleased['minor'] . $lastReleased['patch']);
                        return ($currentVersion > $latestVersion) || ($currentVersion == $latestVersion && $label != $lastReleased['label']);
                    }
                    return true;
                }]
            ],
            'major' => 'trim|required|is_natural',
            'minor' => 'trim|required|is_natural',
            'patch' => 'trim|required|is_natural',
            'label' => 'trim|required|max_length[50]',
            'description' => 'trim|required|min_length[20]',
            'release_date' => 'trim|required',
        ];
    }

    /**
     * Get latest version of application.
     *
     * @param $applicationId
     */
    public function ajax_get_last_version($applicationId)
    {
        $lastReleased = $this->applicationRelease->getAll([
        	'application' => $applicationId,
			'sort_by' => 'version',
			'order_method' => 'desc',
		], true);
		if (!empty($lastReleased)) {
			$lastReleased = $lastReleased[0];
		}

        $this->render_json($lastReleased);
    }

    /**
     * Show application data.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($this->input->get('export')) unset($filters['page']);

        $applicationReleases = $this->applicationRelease->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Release', $applicationReleases);
        }

        $applications = $this->application->getAll();

        $this->render('release/index', compact('applications', 'applicationReleases'));
    }

    /**
     * Show data application release.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_VIEW);

        $applicationRelease = $this->applicationRelease->getById($id);

        $this->render('release/view', compact('applicationRelease'));
    }

    /**
     * Show application logs release.
     *
     * @param $applicationId
     */
    public function change_logs($applicationId)
    {
        $application = $this->application->getById($applicationId);
        $applicationReleases = $this->applicationRelease->getAll([
        	'application' => $applicationId,
        	'sort_by' => 'version',
        	'order_method' => 'desc',
		]);

        $this->render('release/logs', compact('application', 'applicationReleases'));
    }

    /**
     * Show form create application release.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_CREATE);

        $applications = $this->application->getAll();

        $lastReleased = $this->applicationRelease->getAll([
			'application' => get_url_param('application_id'),
			'sort_by' => 'version',
			'order_method' => 'desc',
		], true);
		if (!empty($lastReleased)) {
			$lastReleased = $lastReleased[0];
		}

        $this->render('release/create', compact('applications', 'lastReleased'));
    }

    /**
     * Save application release data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_CREATE);

        if ($this->validate()) {
            $applicationId = $this->input->post('application');
            $major = $this->input->post('major');
            $minor = $this->input->post('minor');
            $patch = $this->input->post('patch');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $releaseDate = $this->input->post('release_date');
            $version = 'v' . $major . '.' . $minor . '.' . $patch;

            $application = $this->application->getById($applicationId);

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

            $this->application->update([
                'version' => $version
            ], $applicationId);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', __('entity_created', ['title' => $application['title'] . ' ' . $version]), 'manage/release');
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
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_EDIT);

        $applicationRelease = $this->applicationRelease->getById($id);
        $application = $this->application->getById($applicationRelease['id_application']);

        $this->render('release/edit', compact('application', 'applicationRelease'));
    }

    /**
     * Save updated application release data.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_EDIT);

        if ($this->validate($this->_validation_rules($id))) {
            $applicationId = $this->input->post('application');
            $major = $this->input->post('major');
            $minor = $this->input->post('minor');
            $patch = $this->input->post('patch');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $releaseDate = $this->input->post('release_date');
            $version = 'v' . $major . '.' . $minor . '.' . $patch;

            $application = $this->application->getById($applicationId);
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

            // update only if the last release version is updated
            if($application['version'] == $release['version']) {
                $this->application->update([
                    'version' => $version
                ], $applicationId);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', __('entity_updated', ['title' => $application['title'] . ' ' . $version]), 'manage/release');
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
        AuthorizationModel::mustAuthorized(PERMISSION_RELEASE_DELETE);

        $release = $this->applicationRelease->getById($id);

        if ($this->applicationRelease->delete($id)) {
            flash('success', __('entity_deleted', ['title' => $release['version']]));
        } else {
            flash('danger', __('entity_error'));
        }

        redirect('manage/release');
    }

}
