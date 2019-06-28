<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Logout
 * @property AuthModel $auth
 * @property UserModel $user
 * @property UserTokenModel $userToken
 */
class Logout extends App_Controller
{
    /**
     * Logout constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel', 'auth');
        $this->load->model('UserModel', 'user');
        $this->load->model('UserTokenModel', 'userToken');
    }

    /**
     * Signing out logged user.
     */
    public function index()
    {
        if ($this->auth->logout()) {
            $rememberToken = get_cookie('remember_token');
            if (!empty($rememberToken)) {
                delete_cookie('remember_token');
                $this->userToken->delete($rememberToken);
            }
            if(get_url_param('force_logout', false)) {
                flash('danger', 'You are kicked out because you are currently active in another device');
            } else {
                flash('warning', 'You are logged out');
            }
            redirect('auth/login');
        }
        redirect('app');
    }

}