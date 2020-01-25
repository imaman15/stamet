<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Document_model extends CI_Model
{

    private $_table = "document";

    private function _get_datatables_query($id)
    {

        $this->db->select('*');
        $this->db->where(['trans_id' => $id]);
        $this->db->from($this->_table);

        // start datatables
        $column_order = array(null, 'doc_name', 'user_upload', 'date_update', 'doc_information', null); //set column field database for datatable orderable
        $column_search = array('doc_name', 'user_upload', 'date_update', 'doc_information'); //set column field database for datatable searchable
        $order = array('doc_id' => 'desc', 'date_update' => 'desc'); // default order

        $i = 0;

        foreach ($column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id)
    {
        $this->db->from($this->_table);
        $this->db->where(['trans_id' => $id]);
        return $this->db->count_all_results();
    }
    //=======================================================

    public function docTrans($id)
    {
        $this->db->from($this->_table);
        $this->db->where('trans_id', $id);
        $this->db->order_by(['doc_id' => 'desc', 'date_update' => 'desc']);
        $query = $this->db->get();
        return $query->result();
    }

    public function apply($id)
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

    public function doc($id)
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
