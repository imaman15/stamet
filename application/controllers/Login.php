<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Halaman Login';
        $data['content'] = 'login';

        $this->load->view('layout/layanan/wrapper', $data, FALSE);
    }
}

/* End of file Login.php */
