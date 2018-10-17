<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['app_name'] 	        = getenv('APP_NAME');
$config['app_author'] 	        = getenv('APP_AUTHOR');

$config['from_name']            = getenv('MAIL_FROM_NAME');
$config['from_address']         = getenv('MAIL_FROM_ADDRESS');
$config['admin_email']          = getenv('MAIL_ADMIN');