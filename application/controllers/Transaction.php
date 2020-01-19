<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['transaction_model', 'type_model', 'subtype_model']);
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
        $data['user'] = dUser();
        $data['type'] = $this->type_model->getData()->result_array();
        $data['title'] = 'Form Permintaan Data';
        $this->template->load('transaction/add', $data);
    }

    public function detail($id = NULL)
    {
        if ($id != NULL) {
            if ($id == '20012020XYZADWL') {
                $data['user'] = dUser();
                $data['title'] = 'Detail Transaksi';
                $this->template->load('transaction/detail', $data);
            } else {
                echo "kode tidak ada";
            }
        } else {
            show_404();
        }
    }

    //Update one item
    public function update($id = NULL)
    {
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }

    // summernote ==============================
    public function save()
    {
        $title = $this->input->post('title', FALSE);
        $contents = $this->input->post('contents', FALSE);
        $this->transaction_model->insert_post($title, $contents);
        $id = $this->db->insert_id();
        $result = $this->transaction_model->get_article_by_id($id)->row_array();
        $data['title'] = $result['title'];
        $data['contents'] = $result['contents'];
        $this->template->load('transaction/list', $data);
    }

    public function upload_image()
    {
        upload_image();
    }

    public function delete_image()
    {
        delete_image();
    }
}

/* End of file Transaction.php */
