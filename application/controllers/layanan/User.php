<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function index()
    {
        $data['user'] = $this->db->get_where('pengguna', ['email' => 
        $this->session->userdata('email')
        ])->row_array();
        echo 'Selamat Datang '.$data['user']['name'];
        
    }

}

/* End of file User.php */
