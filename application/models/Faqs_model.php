<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Faqs_model extends CI_Model
{

    private $_table = 'faqs';

    public function getData($where = NULL)
    {
        $this->db->from($this->_table);
        if ($where != NULL) {
            $this->db->where($where);
        }
        return $this->db->get();
    }

    // start datatables
    var $column_order = array(null, 'faqs_questions', 'faqs_answers', 'status', 'date_created', 'date_update', null); //set column field database for datatable orderable
    var $column_search = array('faqs_questions', 'faqs_answers', 'status', 'date_created', 'date_update'); //set column field database for datatable searchable
    var $order = array('date_update' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from($this->_table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
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
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    //=======================================================

    public function add()
    {
        $data['faqs_questions'] = $this->input->post('faqs_questions', TRUE);
        $data['faqs_answers'] = $this->input->post('faqs_answers', FALSE);
        $status = $this->input->post('status', TRUE);
        if ($status) {
            $data['status'] = $status;
        } else {
            $data['status'] = 0;
        }
        $data['date_created'] = date("Y-m-d H:i:s");

        $this->db->insert($this->_table, $data);
    }

    public function update($id)
    {
        $data['faqs_questions'] = $this->input->post('faqs_questions', TRUE);
        $data['faqs_answers'] = $this->input->post('faqs_answers', FALSE);
        $status = $this->input->post('status', TRUE);
        if ($status) {
            $data['status'] = $status;
        } else {
            $data['status'] = 0;
        }
        $data['date_created'] = date("Y-m-d H:i:s");
        $this->db->where('faqs_id', $id);
        $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["faqs_id" => $id]);
    }
}

/* End of file Faqs_model.php */
