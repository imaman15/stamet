<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        app_not_login();
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->users->applicant();
        $this->template->load('dashboard', $data);
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

/* End of file Dashboard.php */
