<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Administrator';
        $data['content'] = 'admin/masuk';

        $this->load->view('layout/admin/wrapper', $data, FALSE);
    }
}

/* End of file Login.php */
