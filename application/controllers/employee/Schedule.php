<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Jadwal Pertemuan';
        $this->template->loadadmin(UE_FOLDER . '/schedule', $data);
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

/* End of file Schedule.php */
