<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Register
 * @property UserModel $user
 * @property Mailer $mailer
 */
class Register extends App_Controller
{
    protected $layout = 'layouts/auth';
    private $logger;

    /**
     * Register constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserModel', 'user');
        $this->load->model('modules/Mailer', 'mailer');

		$this->logger = AppLogger::auth(Register::class);
    }

    /**
     * Show default register page.
     */
    public function index()
    {
        if (_is_method('post')) {
            if ($this->validate()) {
                $name = $this->input->post('name');
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $this->db->trans_start();

                $this->user->create([
                    'name' => $name,
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, CRYPT_BLOWFISH),
                ]);

                $this->db->trans_complete();

                if ($this->db->trans_status()) {
					// log user register success
					$this->logger->info("User is successfully registered", [
						'name' => $name,
						'username' => $username,
						'email' => $email,
					]);

                    flash('success', 'You are successfully registered, please wait for activation or contact our administrator', 'auth/login');
                } else {
					// log user register failed
					$this->logger->info("Register user failed", [
						'name' => $name,
						'username' => $username,
						'email' => $email,
					]);

                    flash('danger', 'Register user failed, try again or contact administrator.');
                }
            }
        }

        $this->render('auth/register');
    }

    /**
     * Return validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'name' => 'trim|required|max_length[50]',
            'username' => 'trim|required|max_length[50]|is_unique[prv_users.username]',
            'email' => 'trim|required|max_length[50]|is_unique[prv_users.email]',
            'password' => 'trim|required|min_length[6]',
            'confirm_password' => 'matches[password]',
            'terms' => 'trim|required'
        ];
    }
}
