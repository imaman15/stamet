<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Error_page extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('fungsi');
    }

    public function index()
    {
        $uri = $this->uri->segment(1);
        $cek = $this->session->userdata('logged_in');

        if ($uri == UE_ADMIN || $uri == UE_FOLDER || $cek == "admin") {
            $uri = UE_ADMIN;
            $this->_page($uri);
        } else {
            $uri = "";
            $this->_page($uri);
        }
    }

    private function _page($uri)
    {
        $data['title'] = '404 Halaman tidak ada';
        $data['url'] = $uri;
        $this->load->view('404', $data, FALSE);
    }
}

/* End of file Error_page.php */
