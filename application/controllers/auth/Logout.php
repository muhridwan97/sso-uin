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
	private $logger;

    /**
     * Logout constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel', 'auth');
        $this->load->model('UserModel', 'user');
        $this->load->model('UserTokenModel', 'userToken');

		$this->logger = AppLogger::auth(Logout::class);
    }

    /**
     * Signing out logged user.
     */
    public function index()
    {
    	$user = AuthModel::loginData();

		$this->load->driver('cache', ['adapter' => 'file']);
		$this->cache->delete('session-data-' . $user['id']);

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

			// log password link successfully sent
			$this->logger->info("User is logged out", [
				'user' => $user,
				'force_logout' => get_url_param('force_logout', false),
				'remember_token' => $rememberToken,
			]);

            redirect('auth/login');
        }
        redirect('app');
    }

}
