<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Notification
 * @property NotificationModel $notification
 */
class Notification extends App_Controller
{
    /**
     * Account constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('NotificationModel', 'notification');

		$this->setFilterMethods([
			'read' => 'GET|POST|PUT|PATCH'
		]);
    }

    /**
     * Show account preferences.
     */
    public function index()
    {
		$userId = AuthModel::loginData('id');

		$notifications = $this->notification->getByUser($userId);

		$this->render('notification/index', compact('notifications'));
    }

	/**
	 * Redirect after read notification.
	 *
	 * @param $id
	 */
	public function read($id)
	{
		if (empty($this->agent->referrer())) {
			show_error('Direct request not allowed');
		}

		$this->notification->read($id, $this->input->get('source'));

		$redirect = $this->input->get('redirect');

		if (empty($redirect)) {
			$redirect = 'notification';
		}

		redirect($redirect);
	}
}
