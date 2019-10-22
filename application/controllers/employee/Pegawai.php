<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Data Pegawai';
        $data['tes'] = 'coy';
        $this->template->loadadmin(UE_FOLDER . '/pegawai', $data);
    }
}

/* End of file Pegawai.php */
