<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Complaint_model extends CI_Model
{
    private $_table = 'complaint';

    private function _get_datatables_query($where = NULL)
    {

        $user = $this->session->userdata('applicant_id');

        $this->db->select('*');
        if ($user) {
            $this->db->where(['applicant_id' => $user]);
        }

        $this->db->from($this->_table);
        // start datatables
        $column_order = array(null, 'comp_code', 'date_created', 'comp_title', null, 'status', 'date_update'); //set column field database for datatable orderable
        $column_search = array('comp_code', 'comp_title', 'status', 'date_created'); //set column field database for datatable searchable
        $order = array('date_update' => 'desc'); // default order

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $user = $this->session->userdata('applicant_id');

        $this->db->select('*');
        if ($user) {
            $this->db->where(['applicant_id' => $user]);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    //=======================================================

    function add()
    {
        $object['applicant_id'] = $this->session->userdata('applicant_id');
        $object['comp_title'] = $this->input->post('comp_title', TRUE);
        $object['comp_code'] = codeRandom('CO');
        $object['status'] = "diajukan";
        $object['date_created'] = date("Y-m-d H:i:s");
        $object['comp_message'] = $this->input->post('comp_message', FALSE);
        $this->db->insert($this->_table, $object);
    }

    public function getField($select = NULL, $where = NULL)
    {
        if ($select != NULL) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }
        $this->db->from($this->_table);

        if ($where != NULL) {
            $this->db->where($where);
        }

        return $this->db->get();
    }
}

/* End of file Complaint_model.php */
