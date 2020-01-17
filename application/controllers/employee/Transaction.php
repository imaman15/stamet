<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Transaksi Data Layanan';
        $this->template->loadadmin(UE_FOLDER . '/Transaction', $data);
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

/* End of file Transaction.php */
