<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer extends CI_Model
{
    public function __construct()
    {
        $this->load->library('email');
    }

    /**
     * Simple send template email.
     *
     * @param $to
     * @param $title
     * @param $template
     * @param $data
     * @param null $options
     * @return bool
     */
    public function send($to, $title, $template, $data, $options = null)
    {
        $this->email->from($this->config->item('from_address'), $this->config->item('from_name'));
        $this->email->to($to);
        $this->email->reply_to($this->config->item('admin_email'));
        $this->email->subject($this->config->item('app_name') . ' - ' . $title);
        $this->email->message($this->load->view($template, $data, true));

        if (!empty($options)) {
            if (key_exists('cc', $options) && !empty($options['cc'])) {
                $this->email->cc($options['cc']);
            }

            if (key_exists('bcc', $options) && !empty($options['bcc'])) {
                $this->email->bcc($options['bcc']);
            }

            if (key_exists('attachment', $options) && !empty($options['attachment'])) {
                $this->email->attach($options['attachment']);
            }

            if (key_exists('reply_to', $options) && !empty($options['reply_to'])) {
                $this->email->reply_to($options['reply_to']);
            }
        }

        return $this->email->send();
    }
}