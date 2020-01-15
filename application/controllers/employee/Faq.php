<?php


defined('BASEPATH') or exit('No direct script access allowed');

class FAQ extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2,3]);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Frequently Asked Questions';
        $this->template->loadadmin(UE_FOLDER . '/faq', $data);
    }

    // Add a new item
    public function add()
    {
    }

    //Update one item
    public function update($id = NULL)
    {
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }
}

/* End of file Faq.php */
