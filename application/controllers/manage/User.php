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
     * @return array
     */
    protected function _validation_rules()
    {
        $userId = AuthModel::loginData('id');
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
            'password' => [
                'trim', 'required', ['match_password', function ($password) use ($userId) {
                    $user = $this->user->getById($userId);
                    if (password_verify($password, $user['password'])) {
                        return true;
                    }
                    $this->form_validation->set_message('match_password', 'The %s mismatch with your password');
                    return false;
                }]
            ],
            'new_password' => 'min_length[6]|max_length[50]',
            'confirm_password' => 'matches[new_password]'
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