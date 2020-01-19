<?php


defined('BASEPATH') or exit('No direct script access allowed');

class FAQ extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies

    }

    // List all your items
    public function index($offset = 0)
    {
        admin_not_login([2, 3]);
        $data['title'] = 'Frequently Asked Questions';
        $this->template->loadadmin(UE_FOLDER . '/faq', $data);
    }

    // Add a new item
    public function add()
    {
        admin_not_login([2, 3]);
    }

    //Update one item
    public function update($id = NULL)
    {
        admin_not_login([2, 3]);
    }

    //Delete one item
    public function delete($id = NULL)
    {
        admin_not_login([2, 3]);
    }

    //=============Front End ==========
    // List all your items
    public function frontend()
    {
        $user = $this->session->userdata('emp_id');
        if ($user) {
            $data['url'] = site_url(UE_MANAGEFAQ);
        } else {
            $data['url'] = site_url();
        }

        $data['title'] = 'Frequently Asked Questions';
        $this->load->view('faq', $data, FALSE);
    }
}

/* End of file Faq.php */
