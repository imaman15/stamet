<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
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
        $data['title'] = 'Riwayat Transaksi';
        $this->template->load('transaction/list', $data);
    }

    // Add a new item
    public function add()
    {
        $data['title'] = 'Form Permintaan Data';
        $this->template->load('transaction/add', $data);
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

/* End of file Transaction.php */
