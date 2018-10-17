<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property AuthModel $auth
 * @property UserModel $user
 */
class Login extends App_Controller
{
    protected $layout = 'layouts/auth';

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel', 'auth');
        $this->load->model('UserModel', 'user');
    }

    /**
     * Show default login page.
     */
    public function index()
    {
        if (_is_method('post')) {
            if($this->validate()) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember');

                $authenticated = $this->auth->authenticate($username, $password, $remember);

                if ($authenticated === UserModel::STATUS_PENDING || $authenticated === UserModel::STATUS_SUSPENDED) {
                    flash('danger', 'Your account has status <strong>' . $authenticated . '</strong>, please contact our administrator');
                } else {
                    if ($authenticated) {
                        $intended = $this->input->get('redirect');
                        if(empty($intended)) {
                            redirect("app");
                        }
                        redirect(urldecode($intended));
                    } else {
                        flash('danger', 'Username and password mismatch.');
                    }
                }
            }
        }

        $this->render('auth/login');
    }

    /**
     * Return validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'username' => 'trim|required',
            'password' => 'trim|required'
        ];
    }

}