<?php

if (!function_exists('flash')) {

    /**
     * Translate and replace by placeholder value
     *
     * @param $status
     * @param $message
     * @param null $redirectTo
     * @param string $fallback
     */
    function flash($status, $message, $redirectTo = null, $fallback = 'dashboard')
    {
        get_instance()->session->set_flashdata([
            'status' => $status, 'message' => $message,
        ]);

        if (!empty($redirectTo)) {
            if($redirectTo == '_redirect') {
                $redirect = get_instance()->input->get('redirect');
                redirect(if_empty($redirect, site_url()));
            }
            elseif($redirectTo == '_back') {
                redirect(if_empty(get_instance()->agent->referrer(), $fallback));
            } else {
                redirect($redirectTo);
            }
        }
    }
}