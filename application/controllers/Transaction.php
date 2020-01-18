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

    //Update one item
    public function update($id = NULL)
    {
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }

    // summernote ==============================
    function save()
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

    //Upload image summernote
    function upload_image()
    {
        if (isset($_FILES["image"]["name"])) {
            $config['upload_path'] = './assets/img-sn/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->upload->display_errors();
                return FALSE;
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/img-sn/' . $data['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 800;
                $config['height'] = 800;
                $config['new_image'] = './assets/img-sn/' . $data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url() . 'assets/img-sn/' . $data['file_name'];
            }
        }
    }

    //Delete image summernote
    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
}

/* End of file Transaction.php */
