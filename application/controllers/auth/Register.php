<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Register
 * @property UserModel $user
 * @property NotificationModel $notification
 * @property Mailer $mailer
 */
class Register extends App_Controller
{
    protected $layout = 'layouts/auth';

    /**
     * Register constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserModel', 'user');
        $this->load->model('NotificationModel', 'notification');
        $this->load->model('modules/Mailer', 'mailer');
    }

    /**
     * Show default register page.
     */
    public function index()
    {
        if (_is_method('post')) {
            if ($this->validate($this->_validation_rules())) {
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
                $userId = $this->db->insert_id();

                $payload = json_encode([
                    'message' => "Welcome aboard {$name} to " . $this->config->item('app_name'),
                    'time' => format_date('now', 'Y-m-d H:i:s')
                ]);

                $this->notification->create([
                    'id_user' => $userId,
                    'channel' => NotificationModel::SUBSCRIBE_WELCOME,
                    'url' => site_url('account'),
                    'data' => $payload
                ]);

                $notifiedUsers = $this->user->getByPermission([PERMISSION_USER_EDIT]);

                $message = $this->notification->getRandomGreeting() . "{$name} has joined us" . (rand(1, 10) < 5 ? ', check it out' : '');
                foreach ($notifiedUsers as $notifiedUser) {
                    $payload = json_encode([
                        'message' => $message,
                        'time' => format_date('now', 'Y-m-d H:i:s'),
                        'link_text' => [["text" => $name, "url" => site_url('master/user/view/' . $userId)]]
                    ]);

                    $this->notification->create([
                        'id_user' => $notifiedUser['id'],
                        'channel' => NotificationModel::SUBSCRIBE_REGISTER,
                        'url' => site_url('master/user/view/' . $userId),
                        'data' => $payload
                    ]);

                    // send push notification
                    $data = [
                        'id' => $this->db->insert_id(),
                        'url' => site_url('master/user/view/' . $userId),
                        'message' => $message,
                        'time' => format_date('now', 'Y-m-d H:i:s')
                    ];
                    $this->notification->notify(NotificationModel::SUBSCRIBE_REGISTER, ('register-' . $notifiedUser['id']), $data);

                    // send email notification
                    $emailTitle = "{$name} registered as new user at " . format_date('now', 'd F Y H:i');
                    $emailTemplate = 'emails/basic';
                    $emailData = [
                        'name' => $notifiedUser['name'],
                        'email' => $notifiedUser['email'],
                        'content' => "{$name} have been registered with email {$email}, please evaluate the privileges immediately"
                    ];
                    $this->mailer->send($notifiedUser['email'], $emailTitle, $emailTemplate, $emailData);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status()) {
                    flash('success', 'You are successfully registered, please wait for activation or contact our administrator', 'auth/login');
                } else {
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
            'confirm' => 'matches[password]',
            'terms' => 'trim|required'
        ];
    }

}