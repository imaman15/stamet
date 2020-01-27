<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    private $_table = "transaction";


    private function _get_datatables_query($where = NULL, $for = NULL, $list = NULL)
    {

        $user = $this->session->userdata('applicant_id');

        if ($for == "emp") {
            if ($list == 'all') {
                $this->db->select('trans_code,transcode_storage,' . $this->_table . '.date_created, payment_status, trans_status, trans_sum,CONCAT(applicant.first_name, " ", applicant.last_name) as fullname,institute,phone,email');
            } else {
                $this->db->select('trans_code,transcode_storage, apply_id, apply_name, apply_institute, apply_email, apply_phone,date_created, payment_status, trans_status, trans_sum');
            }
        } else {
            //=====================================================================================
            $this->db->select('trans_code, date_created, payment_status, trans_status, trans_sum');
        }
        //=====================================================================================
        if ($user) {
            $this->db->where(['apply_id' => $user]);
        }
        //=====================================================================================
        if ($where != NULL) {
            $this->db->where($where);
        }


        // start datatables

        if ($for == "emp") {

            if ($list == 'all') {
                $this->db->join('applicant', 'applicant.applicant_id = ' . $this->_table . '.apply_id');
                $this->db->from($this->_table);
                //==============================================
                $column_order = array(null, 'trans_code', 'fullname', 'transcode_storage', $this->_table . '.date_created', null, null, null);
                $column_search = array('trans_code', 'CONCAT(applicant.first_name, " ", applicant.last_name)', 'transcode_storage', $this->_table . '.date_created', 'institute', 'phone', 'email');
                $order = array($this->_table . '.date_update' => 'desc');
            } else {
                $this->db->join('applicant', 'applicant.applicant_id = ' . $this->_table . '.apply_id');
                $this->db->from($this->_table);
                //==============================================
                $column_order = array(null, 'trans_code', 'transcode_storage', 'apply_name', $this->_table . '.date_created', null, null, null);
                $column_search = array('trans_code', 'transcode_storage', 'apply_name', 'apply_institute', 'apply_email', 'apply_phone', $this->_table . '.date_created');
                $order = array($this->_table . '.date_update' => 'desc');
            }
        } else {
            $this->db->from($this->_table);
            $column_order = array(null, 'trans_code', 'date_created', null, null, null); //set column field database for datatable orderable
            $column_search = array('trans_code', 'date_created'); //set column field database for datatable searchable
            $order = array('date_update' => 'desc'); // default order
        }

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

    function get_datatables($where = NULL, $for = NULL, $list = NULL)
    {
        $this->_get_datatables_query($where, $for, $list);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($where = NULL, $for = NULL, $list = NULL)
    {
        $this->_get_datatables_query($where, $for, $list);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($where = NULL)
    {
        $user = $this->session->userdata('applicant_id');

        $this->db->select('*');
        if ($user) {
            $this->db->where(['apply_id' => $user]);
        }
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    //=======================================================

    function apply()
    {
        $data['apply_id'] = $this->session->userdata('applicant_id');
        $data['trans_code'] = $this->input->post("trans_code", TRUE);
        $data['trans_message'] = $this->input->post("trans_message", FALSE);
        $data['date_created'] = date("Y-m-d H:i:s");
        $data['trans_status'] = 0;
        $this->db->insert($this->_table, $data);
        $id = $this->db->insert_id();
        $upload_file = $_FILES['doc_storage']['name'];
        if ($upload_file) {
            $this->document_model->apply($id);
        }
    }

    public function getField($select = NULL, $where = NULL)
    {
        if ($select != NULL) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }

        if ($where != NULL) {
            $this->db->where($where);
        }

        $this->db->from($this->_table);
        return $this->db->get();
    }

    public function updatePayment()
    {
        $post = $this->input->post(NULL, TRUE);
        $user = $this->session->userdata('applicant_id');
        $id = $post["trans_code"];
        $params['payment_to'] = $post["payment_to"];
        $params['payment_date'] = $post["payment_date"];
        $params['payment_bank'] = $post["payment_bank"];
        $params['payment_number'] = $post["payment_number"];
        $params['payment_from'] = $post["payment_from"];
        $params['payment_amount'] = $post["payment_amount"];
        $params['payment_status'] = 2;
        // $params['institute'] = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;

        // Cek Jika ada gambar yang akan diupload
        $upload_image = $_FILES['photo']['name'];
        if ($upload_image) {
            $config['upload_path']          = './assets/img/img-bukti/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['file_name']            = round(microtime(true) * 1000);
            $config['max_size']             = 8048; // 2MB

            $this->upload->initialize($config);

            if ($this->upload->do_upload('photo')) {
                $old_image = $this->transaction_model->getField('payment_img', ['trans_code' => $id, 'apply_id' => $user])->row()->payment_img;

                if (file_exists('assets/img/img-bukti/' . $old_image) && $old_image)
                    unlink('assets/img/img-bukti/' . $old_image);

                $params['payment_img'] = $this->upload->data('file_name');
            } else {
                $data['inputerror'][] = 'photo';
                $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }
        }

        $this->db->where(['trans_code' => $id, 'apply_id' => $user]);
        $this->db->update($this->_table, $params);
    }

    public function cancelTransaction($id)
    {
        $user = $this->session->userdata('applicant_id');
        $params['payment_status'] = 5;
        $params['trans_status'] = 5;
        if ($user) {
            $this->db->where(['trans_code' => $id, 'apply_id' => $user]);
        }
        $this->db->where(['trans_code' => $id]);
        $this->db->update($this->_table, $params);
    }

    public function beranda()
    {
        $id = $this->session->userdata('applicant_id');
        $this->db->where('apply_id', $id);
        $this->db->order_by('date_update', 'desc');
        return $this->db->get($this->_table, 5)->result();
    }
}

/* End of file Transaction_model.php */
