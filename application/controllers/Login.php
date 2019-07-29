<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Halaman Login';

        $this->template->auth('template_login', 'auth/login', $data, FALSE);
    }
}

/* End of file Login.php */
