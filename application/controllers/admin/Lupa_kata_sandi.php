<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lupa_kata_sandi extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Lupa Kata Sandi';
        $data['content'] = 'admin/lupa_kata_sandi';

        $this->load->view('layout/admin/wrapper', $data, FALSE);
    }
}

/* End of file Lupa_kata_sandi.php */
