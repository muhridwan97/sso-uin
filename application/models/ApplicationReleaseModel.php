<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplicationReleaseModel extends App_Model
{
    protected $table = 'application_releases';

    const LABEL_DRAFT = 'DRAFT';
    const LABEL_ALPHA = 'ALPHA';
    const LABEL_BETA = 'BETA';
    const LABEL_RC = 'RC';
    const LABEL_RELEASE = 'RELEASE';

    const LABELS = [self::LABEL_DRAFT, self::LABEL_ALPHA, self::LABEL_BETA, self::LABEL_RC, self::LABEL_RELEASE];

    /**
     * Get base query of application release.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'prv_applications.title AS application_title',
                'CONCAT("v", major, ".", minor, ".", patch) AS version'
            ])
            ->join('prv_applications', 'prv_applications.id = application_releases.id_application');
    }
}
