<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function login()
    {
        $this->load->library('form_validation');
        $data['title'] = 'Administrator';
        $this->template->auth('template_loginadmin', UE_FOLDER . '/auth/lupa_kata_sandi', $data, FALSE);
    }
}

/* End of file Auth.php */
