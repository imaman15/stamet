<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cands_model extends CI_Model
{
    private $_table = 'cands';

    // start datatables
    var $column_order = array(null, 'applicant_name', 'cands_message', 'date_created', 'status', null); //set column field database for datatable orderable
    var $column_search = array('applicant_name', 'applicant_email', 'applicant_phone', 'cands_message', 'date_created', 'status'); //set column field database for datatable searchable
    var $order = array('status' => 'asc'); // default order

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

    public function status($id)
    {
        $data['status'] = 'dilihat';
        $this->db->where(['cands_id' => $id]);
        $this->db->update($this->_table, $data);
    }

    public function add()
    {
        $user = dUser();
        $post = $this->input->post(NULL, TRUE);
        $data['applicant_id'] = $user->applicant_id;
        $data['applicant_name'] = $user->first_name . " " . $user->last_name;
        $data['applicant_email'] = $user->email;
        $data['applicant_phone'] = $user->phone;
        $data['cands_message'] = $post['cands_message'];
        $data['status'] = 'belum';
        $this->db->insert($this->_table, $data);
    }

    public function lastAnswer()
    {
        $this->db->select('date_created');
        $this->db->where('applicant_id', dUser()->applicant_id);
        $this->db->order_by('cands_id', 'desc');
        $this->db->order_by('cands_id', 'desc');
        return $this->db->get($this->_table, 1)->row();
    }
}

/* End of file Cands_model.php */
