<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User
 * @property UserModel $user
 * @property Uploader $uploader
 * @property Exporter $exporter
 */
class User extends App_Controller
{
    /**
     * Account constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserModel', 'user');
        $this->load->model('modules/Uploader', 'uploader');
        $this->load->model('modules/Exporter', 'exporter');
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
                'trim', 'required', 'max_length[50]', ['username_exists', function ($username) use ($userId) {
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
        $user = $this->user->getById($id);

        $this->render('user/view', compact('user'));
    }

    /**
     * Show form create user.
     */
    public function create()
    {
        $this->render('user/create');
    }

    /**
     * Save user data.
     */
    public function save()
    {
        if ($this->validate()) {
            $name = $this->input->post('name');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $status = $this->input->post('status');
            $password = $this->input->post('password');

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

            $this->user->create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'status' => $status,
                'avatar' => $avatar,
                'password' => password_hash($password, CRYPT_BLOWFISH),
            ]);

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
        $user = $this->user->getById($id);

        $this->render('user/edit', compact('user'));
    }

    /**
     * Save updated user data.
     *
     * @param $id
     */
    public function update($id)
    {
        if ($this->validate($this->_validation_rules($id))) {
            $name = $this->input->post('name');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $status = $this->input->post('status');
            $password = $this->input->post('password');

            $user = $this->user->getById($id);

            $this->db->trans_start();

            $avatar = if_empty($user['avatar'], null);
            if (!empty($_FILES['avatar']['name'])) {
                if ($this->uploader->uploadTo('avatar', ['destination' => 'avatars/' . date('Y/m')])) {
                    $uploadedData = $this->uploader->getUploadedData();
                    $avatar = $uploadedData['uploaded_path'];
                    if(!empty($user['avatar'])) {
                        $this->uploader->delete($user['avatar']);
                    }
                } else {
                    flash('danger', $this->uploader->getDisplayErrors(), '_back');
                }
            }

            $this->user->update([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'status' => $status,
                'avatar' => $avatar,
                'password' => password_hash($password, CRYPT_BLOWFISH),
            ], $id);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
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