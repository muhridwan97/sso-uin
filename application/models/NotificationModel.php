<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationModel extends App_Model
{
	protected $table = 'notifications';

	public static function baseQuery()
	{
		return get_instance()->db->from("
        	(
				SELECT * FROM (
				SELECT id, id_user, id_related, channel, '' AS url, data, is_read, created_at, 'purchasing' AS source FROM " . env('PCH_DATABASE') . ".notifications
				UNION ALL
				SELECT id, id_user, id_related, channel, '' AS url, data, is_read, created_at, 'finance' AS source FROM " . env('FIN_DATABASE') . ".notifications
				UNION ALL
				SELECT id, id_user, '' AS id_related, channel, url, `data`, is_read, created_at, 'hr' AS source FROM " . env('HR_DATABASE') . ".notifications
				UNION ALL
				SELECT id, id_user, '' AS id_related, channel, url, `data`, is_read, created_at, 'crm' AS source FROM " . env('CRM_DATABASE') . ".notifications
				) AS notifications
			) AS notifications
        ");
	}

	/**
	 * Get parsed data notifications by user.
	 *
	 * @param $userId
	 * @return array
	 */
	public function getByUser($userId)
	{
		$notifications = NotificationModel::baseQuery()
			->where([
				'id_user' => $userId,
				'created_at>=DATE(NOW()) - INTERVAL 30 DAY' => null
			])
			->order_by('created_at', 'desc')
			->get()
			->result_array();

		foreach ($notifications as &$notification) {
			$notification['data'] = json_decode($notification['data'], true);
		}

		return $notifications;
	}

	/**
	 * Get sticky navbar notification.
	 *
	 * @param null $userId
	 * @return int
	 */
	public static function getUnreadNotification($userId = null)
	{
		if ($userId == null) {
			$userId = AuthModel::loginData('id');
		}

		get_instance()->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cacheKey = 'unread-' . $userId;

		if (!$totalUnread = get_instance()->cache->get($cacheKey)) {
			$totalUnread = NotificationModel::baseQuery()
				->where([
					'id_user' => $userId,
					'is_read' => false,
					'created_at>=DATE(NOW()) - INTERVAL 30 DAY' => null
				])
				->count_all_results();

			get_instance()->cache->save($cacheKey, $totalUnread, 60);
		}

		return $totalUnread;
	}

	/**
	 * Read notification model.
	 *
	 * @param $id
	 * @param $source
	 * @return bool
	 */
	public function read($id, $source)
	{
		$database = $this->load->database($source, TRUE);

		return $database->update($this->table, ['is_read' => 1], ['id' => $id]);
	}
}
