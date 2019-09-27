<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'recaptcha'));
    }


    public function login()
    {
        $data['title'] = '';
        $this->template->auth('template_login', 'auth/login', $data, FALSE);
    }

    public function registration()
    {
        $data['title'] = 'Daftar';
        $this->template->auth('template_login', 'auth/registration', $data, FALSE);
    }
}

/* End of file Auth.php */
