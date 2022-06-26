<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User
 * @property ApplicationModel $application
 * @property UserApplicationModel $userApplication
 * @property UserModel $user
 * @property RoleModel $role
 * @property UserRoleModel $userRole
 * @property Uploader $uploader
 * @property Exporter $exporter
 * @property Mailer $mailer
 */
class User extends App_Controller
{
	/**
	 * User constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('ApplicationModel', 'application');
		$this->load->model('UserApplicationModel', 'userApplication');
		$this->load->model('UserModel', 'user');
		$this->load->model('RoleModel', 'role');
		$this->load->model('UserRoleModel', 'userRole');
		$this->load->model('modules/Uploader', 'uploader');
		$this->load->model('modules/Exporter', 'exporter');
		$this->load->model('modules/Mailer', 'mailer');
	}

	/**
	 * Set validation rules.
	 *
	 * @param int $userId
	 * @return array
	 */
	protected function _validation_rules($userId = 0)
	{
		return [
			'name' => 'trim|required|max_length[50]',
			'username' => [
				'trim', 'required', 'max_length[25]', 'regex_match[/^[a-zA-Z0-9.\-_]+$/]', ['username_exists', function ($username) use ($userId) {
					$this->form_validation->set_message('username_exists', 'The %s has been registered before, try another');
					return $this->user->isUniqueUsername($username, $userId);
				}]
			],
			'email' => [
				'trim', 'required', 'valid_email', 'max_length[50]', ['email_exists', function ($username) use ($userId) {
					$this->form_validation->set_message('email_exists', 'The %s has been registered before, try another');
					return $this->user->isUniqueEmail($username, $userId);
				}]
			],
			'status' => 'trim|required|in_list[' . UserModel::STATUS_ACTIVATED . ',' . UserModel::STATUS_PENDING . ',' . UserModel::STATUS_SUSPENDED . ']',
			'password' => 'min_length[6]' . ($userId > 0 ? '' : '|required'),
			'confirm_password' => 'matches[password]',
		];
	}

	/**
	 * Show user data.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$users = $this->user->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Users', $users);
		}

		$this->render('user/index', compact('users'));
	}

	/**
	 * Show data user.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_VIEW);

		$user = $this->user->getById($id);
		$userSubordinates = $this->user->getBy(['prv_users.id_user' => $id]);
		$userApplications = $this->application->getByUser($id);
		$roles = $this->userRole->getBy(['prv_user_roles.id_user' => $id]);

		$this->render('user/view', compact('user', 'userSubordinates', 'userApplications', 'roles'));
	}

	/**
	 * Show form create user.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_CREATE);

		$applications = $this->application->getAll();
		$roles = $this->role->getAll();

		$this->render('user/create', compact('applications', 'roles'));
	}

	/**
	 * Save user data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_CREATE);

		if ($this->validate()) {
			$name = $this->input->post('name');
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$userType = $this->input->post('user_type');
			$status = $this->input->post('status');
			$password = $this->input->post('password');
			$passwordNeverExpired = $this->input->post('password_never_expired');
			$applications = $this->input->post('applications');
			$defaultApplication = $this->input->post('default_application');
			$roles = $this->input->post('roles');

			$this->db->trans_start();

			$avatar = null;
			if (!empty($_FILES['avatar']['name'])) {
				if ($this->uploader->uploadTo('avatar', ['destination' => 'avatars/' . date('Y/m')])) {
					$uploadedData = $this->uploader->getUploadedData();
					$avatar = $uploadedData['uploaded_path'];
				} else {
					flash('danger', $this->uploader->getDisplayErrors(), '_back');
				}
			}

			// check password expiration
			$passwordExpiredDays = get_setting('password_expiration_days');
			$passwordExpiredAt = null;
			if ($passwordExpiredDays > 0) {
				$passwordExpiredAt = date('Y-m-d H:i:s', strtotime('+' . $passwordExpiredDays . ' day'));
			}

			$this->user->create([
				'name' => $name,
				'username' => $username,
				'email' => $email,
				'status' => $status,
				'user_type' => $userType,
				'avatar' => $avatar,
				'password' => password_hash($password, CRYPT_BLOWFISH),
				'password_expired_at' => $passwordExpiredAt,
				'password_never_expired' => !empty($passwordNeverExpired)
			]);
			$userId = $this->db->insert_id();

			foreach ($applications as $application) {
				if (!empty($application)) {
					$this->userApplication->create([
						'id_user' => $userId,
						'id_application' => $application,
						'is_default' => ($defaultApplication == $application)
					]);
				}
			}

			foreach ($roles as $roleId) {
				$this->userRole->create([
					'id_user' => $userId,
					'id_role' => $roleId,
				]);
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', __('entity_created', ['title' => $name]), 'manage/user');
			} else {
				flash('danger', __('entity_error'));
			}
		}
		$this->create();
	}

	/**
	 * Show form edit user.
	 *
	 * @param $id
	 */
	public function edit($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_EDIT);

		$user = $this->user->getById($id);

		$applications = $this->application->getAll();
		$defaultApp = '';

		$userApplications = $this->userApplication->getBy(['id_user' => $id]);
		foreach ($userApplications as $userApplication) {
			if ($userApplication['is_default']) {
				$defaultApp = $userApplication['id_application'];
				break;
			}
		}
		$selectedApps = array_column($userApplications, 'id_application');

		foreach ($applications as &$application) {
			if (in_array($application['id'], $selectedApps)) {
				$application['_selected'] = true;
			} else {
				$application['_selected'] = false;
			}
		}
		$roles = $this->role->getAll();
		$userRoles = $this->userRole->getBy(['id_user' => $id]);

		$this->render('user/edit', compact('user', 'applications', 'defaultApp', 'roles', 'userRoles'));
	}

	/**
	 * Save updated user data.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
			$name = $this->input->post('name');
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$userType = $this->input->post('user_type');
			$status = $this->input->post('status');
			$password = $this->input->post('password');
			$passwordNeverExpired = $this->input->post('password_never_expired');
			$applications = $this->input->post('applications');
			$defaultApplication = $this->input->post('default_application');
			$roles = $this->input->post('roles');

			$user = $this->user->getById($id);

			$this->db->trans_start();

			$avatar = if_empty($user['avatar'], null);
			if (!empty($_FILES['avatar']['name'])) {
				if ($this->uploader->uploadTo('avatar', ['destination' => 'avatars/' . date('Y/m')])) {
					$uploadedData = $this->uploader->getUploadedData();
					$avatar = $uploadedData['uploaded_path'];
					if (!empty($user['avatar'])) {
						$this->uploader->delete($user['avatar']);
					}
				} else {
					flash('danger', $this->uploader->getDisplayErrors(), '_back');
				}
			}

			// check password expiration
			$passwordExpiredDays = get_setting('password_expiration_days');
			$passwordExpiredAt = null;
			if ($passwordExpiredDays > 0) {
				$passwordExpiredAt = date('Y-m-d H:i:s', strtotime('+' . $passwordExpiredDays . ' day'));
			}

			$this->user->update([
				'name' => $name,
				'username' => $username,
				'email' => $email,
				'status' => $status,
				'user_type' => $userType,
				'avatar' => $avatar,
				'password' => empty($password) ? $user['password'] : password_hash($password, CRYPT_BLOWFISH),
				'password_expired_at' => empty($password) ? $user['password_expired_at'] : $passwordExpiredAt,
				'password_never_expired' => !empty($passwordNeverExpired)
			], $id);

			$this->userApplication->delete(['id_user' => $id]);
			foreach ($applications as $applicationId) {
				if (!empty($applicationId)) {
					$this->userApplication->create([
						'id_user' => $id,
						'id_application' => $applicationId,
						'is_default' => ($defaultApplication == $applicationId)
					]);
				}
			}

			$this->userRole->delete(['id_user' => $id]);
			foreach ($roles as $roleId) {
				$this->userRole->create([
					'id_user' => $id,
					'id_role' => $roleId,
				]);
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				if($user['status'] != $status){
					$emailTo = $email;
					$emailCC = [];
					$emailData = [
						'title' => 'Your Account '.$status,
						'name' => $name,
						'email' => $email,
						'content' => "Recently we review your account that was requested before and the result, it's {$status}.",
					];
					$emailTitle = 'Status account ' . $name . ' is ' . $status . ' at ' . date('d F Y H:i');
					$this->mailer->send($emailTo, $emailTitle, 'emails/basic', $emailData, ['cc' => $emailCC]);

				}
				flash('success', __('entity_updated', ['title' => $name]), 'manage/user');
			} else {
				flash('danger', __('entity_error'));
			}
		}
		$this->edit($id);
	}

	/**
	 * Perform deleting user data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_USER_DELETE);

		$user = $this->user->getById($id);

		if ($user['username'] == 'admin') {
			flash('danger', 'Administrator is reserved user.');
		} else {
			if ($this->user->delete($id)) {
				flash('success', __('entity_deleted', ['title' => $user['name']]));
			} else {
				flash('danger', __('entity_error'));
			}
		}

		redirect('manage/user');
	}

}
