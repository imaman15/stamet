<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
        $this->load->library(['form_validation']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Riwayat Jadwal Pertemuan';
        $this->template->load('schedule/list', $data);
    }

    // Add a new item
    public function add()
    {
        $data['title'] = 'Form Jadwal Pertemuan';
        $this->template->load('schedule/add', $data);
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
