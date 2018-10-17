<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = getenv('MAIL_DRIVER');
$config['useragent'] = 'Mail Agent';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['smtp_host'] = getenv('MAIL_HOST');
$config['smtp_port'] = getenv('MAIL_PORT');
$config['smtp_timeout'] = '7';
$config['smtp_user'] = getenv('MAIL_USERNAME');
$config['smtp_pass'] = getenv('MAIL_PASSWORD');
$config['mailtype'] = 'html';
$config['validation'] = TRUE;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";