<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplicationModel extends App_Model
{
    protected $table = 'prv_applications';

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->order_by('order', 'asc');
    }
}
