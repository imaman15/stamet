<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
    private $_table = "schedule";

    private function _get_datatables_query($where = NULL)
    {

        $user = $this->session->userdata('applicant_id');

        $this->db->select('*');
        if ($user) {
            $this->db->where(['applicant_id' => $user]);
        }

        $this->db->from($this->_table);
        // start datatables
        $column_order = array(null, 'sch_code', 'sch_type', 'sch_date', 'responsible_person', null, null); //set column field database for datatable orderable
        $column_search = array('sch_code', 'sch_type', 'sch_date', 'responsible_person'); //set column field database for datatable searchable
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
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    //=======================================================

    function add()
    {
        $data['applicant_id'] = $this->session->userdata('applicant_id');
        $data['sch_code'] = $this->input->post('sch_code', TRUE);
        $data['sch_title'] = $this->input->post('sch_title', TRUE);
        $data['sch_type'] = $this->input->post('sch_type', TRUE);
        $data['sch_date'] = $this->input->post('sch_date', TRUE);
        $data['sch_message'] = $this->input->post('sch_message', FALSE);
        $data['date_created'] = $this->input->post('sch_date', TRUE);
        $data['sch_status'] = 0;

        $this->db->insert($this->_table, $data);
    }

    public function getField($select = NULL, $where = NULL)
    {
        if ($select != NULL) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }
        $this->db->from($this->_table . ' s');

        $this->db->join('applicant a', 'a.applicant_id = s.applicant_id');

        $this->db->join('employee e', 'e.emp_id = s.applicant_id');

        if ($where != NULL) {
            $this->db->where($where);
        }


        return $this->db->get();
    }

    function cancel($id)
    {
        $user = $this->session->userdata('applicant_id');
        $params['sch_status'] = 4;
        $this->db->where(['sch_code' => $id, 'applicant_id' => $user]);
        $this->db->update($this->_table, $params);
    }

    public function beranda()
    {
        $id = $this->session->userdata('applicant_id');
        $this->db->where('applicant_id', $id);
        $this->db->order_by('date_update', 'desc');
        return $this->db->get($this->_table, 5)->result();
    }
}

/* End of file Schedule_model.php */
