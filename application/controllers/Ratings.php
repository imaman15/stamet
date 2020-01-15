<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Ratings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Survei Pelanggan';
        $this->template->load('user/ratings', $data);
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

/* End of file Ratings.php */
