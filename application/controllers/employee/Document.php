<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Document extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['document_model']);
    }

    // Add a new item
    public function docApply()
    {
        app_not_login();
        $this->_validPayment();
        $this->document_model->docApply();
        echo json_encode(array("status" => TRUE));
    }

    public function deleteDocApply($id)
    {
        app_not_login();
        $this->document_model->deleteDocApply($id);
        echo json_encode(array("status" => TRUE));
    }

    // Add a new item
    public function docEmploy()
    {
        admin_not_login([2]);
        $this->_validPayment();
        $this->document_model->docEmploy();
        echo json_encode(array("status" => TRUE));
    }

    public function deleteDocEmploy($id)
    {
        admin_not_login([2]);
        $this->document_model->deleteDocEmploy($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validPayment($method = NULL)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('doc_name') == '') {
            $data['inputerror'][] = 'doc_name';
            $data['error_string'][] = 'Nama berkas tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($_FILES['doc_storage']['name'] == '') {
            $data['inputerror'][] = 'doc_storage';
            $data['error_string'][] = 'Upload berkas tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Doucment.php */
