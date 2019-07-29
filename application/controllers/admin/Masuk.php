<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Administrator';
        $this->template->auth('template_loginadmin', 'admin/auth/masuk', $data, FALSE);
    }
}

/* End of file Login.php */
