<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->helper('fungsi');
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['tes'] = 'ada saja';
        admintemplate('Beranda', 'admin/beranda', $data);
    }

    // Add a new item
    public function add()
    { }

    //Update one item
    public function update($id = NULL)
    { }

    //Delete one item
    public function delete($id = NULL)
    { }
}

/* End of file Beranda.php */
