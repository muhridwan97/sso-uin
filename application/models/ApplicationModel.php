<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplicationModel extends App_Model
{
    protected $table = 'prv_applications';

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'releases.total_release'
            ])
            ->join('(
                SELECT id_application, COUNT(id) AS total_release 
                FROM application_releases GROUP BY id_application
                ) AS releases', 'releases.id_application = prv_applications.id', 'left')
            ->order_by('order', 'asc');
    }

    /**
     * Get applications access by specific user.
     *
     * @param $id
     * @return array
     */
    public function getByUser($id)
    {
        $applications = $this->getBaseQuery()
            ->join('prv_user_applications', 'prv_user_applications.id_application = prv_applications.id')
            ->where('prv_user_applications.id_user', $id);

        return $applications->get()->result_array();
    }
}
