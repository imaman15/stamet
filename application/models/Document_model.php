<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Document_model extends CI_Model
{

    private $_table = "document";

    function apply($id)
    {
        if (!empty($_FILES['doc_storage']['name'])) {
            $upload = $this->_do_uploads();
            $params["doc_storage"] = $upload;
        }

        $params['doc_name'] = "Surat Pengantar";
        $params['doc_information'] = "-";
        $params['user_type'] = "applicant";
        $params['user_id'] = $this->session->userdata('applicant_id');
        $params['user_upload'] = dUser()->first_name . " " . dUser()->last_name . " - Pemohon";
        $params['trans_id'] = $id;
        $this->db->insert($this->_table, $params);
    }

    private function _do_uploads()
    {
        $config['upload_path']          = './assets/transfile/';
        $config['allowed_types']        = 'docx|pdf|doc';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $config['max_size']             = 10048; // 10MB

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('doc_storage')) //upload and validate
        {
            $eror = $this->upload->display_errors();
            $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">' . $eror . '</div>');
            redirect(site_url(UA_TRANSACTION));
        }
        return $this->upload->data('file_name');
    }
}

/* End of file Document_model.php */
