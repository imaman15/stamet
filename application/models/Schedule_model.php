<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
    private $_table = "schedule";

    private function _get_datatables_query($for = NULL)
    {

        if ($for == "employ") {
            $this->db->select($this->_table . '.*, CONCAT(applicant.first_name, " ", applicant.last_name) as name_apply,applicant.phone as phone_apply,applicant.email as email_apply,CONCAT(employee.first_name, " ", employee.last_name) as name_emp,employee.phone as phone_emp,employee.email as email_emp,employee.csidn');
            $this->db->join('applicant', 'applicant.applicant_id = ' . $this->_table . '.applicant_id', 'left');
            $this->db->join('employee', 'employee.emp_id = ' . $this->_table . '.emp_id', 'left');

            $column_order = array(null,  $this->_table . '.date_created', 'sch_date', 'name_apply', 'responsible_person', 'sch_status'); //set column field database for datatable orderable
            $column_search = array('sch_code', 'sch_title', 'sch_type', 'responsible_person', 'sch_date', 'CONCAT(applicant.first_name, " ", applicant.last_name)', 'applicant.phone', 'applicant.email', 'CONCAT(employee.first_name, " ", employee.last_name)', 'employee.phone', 'employee.email', 'employee.csidn', 'sch_status',  $this->_table . '.date_created'); //set column field database for datatable searchable
            $order = array('date_update' => 'desc'); // default order
        } else {
            $user = $this->session->userdata('applicant_id');
            $this->db->select('*');
            if ($user) {
                $this->db->where(['applicant_id' => $user]);
            }
            // start datatables
            $column_order = array(null, 'sch_code', 'sch_type', 'sch_date', 'responsible_person', null, null); //set column field database for datatable orderable
            $column_search = array('sch_code', 'sch_type', 'sch_date', 'responsible_person'); //set column field database for datatable searchable
            $order = array('date_update' => 'desc'); // default order
        }
        $this->db->from($this->_table);
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

    function get_datatables($for = Null)
    {
        $this->_get_datatables_query($for);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($for = Null)
    {
        $this->_get_datatables_query($for);
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
        $data['applicant_id'] = $this->session->userdata('applicant_id');
        $data['sch_code'] = $this->input->post('sch_code', TRUE);
        $data['sch_title'] = $this->input->post('sch_title', TRUE);
        $data['sch_type'] = $this->input->post('sch_type', TRUE);
        $data['sch_date'] = $this->input->post('sch_date', TRUE);
        $data['sch_message'] = $this->input->post('sch_message', FALSE);
        $data['date_created'] = date("Y-m-d H:i:s");
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
        $this->db->from($this->_table);

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

    function confirm($id)
    {
        $user = dAdmin();
        $params['sch_status'] = 1;
        $params['responsible_person'] = $user->first_name . ' ' . $user->last_name . '<hr class="my-0">' . $user->pos_name . '<hr class="my-0">' . $user->email . '<hr class="my-0">' . $user->phone;
        $params['emp_id'] = $user->emp_id;

        $this->db->where(['sch_code' => $id]);
        $this->db->update($this->_table, $params);
    }

    public function status($id)
    {
        $user = dAdmin();
        $data['sch_status'] = $this->input->post('status', TRUE);
        $this->db->where(['sch_code' => $id, 'emp_id' => $user->emp_id]);
        $this->db->update($this->_table, $data);
    }

    public function beranda()
    {
        $id = $this->session->userdata('applicant_id');
        $this->db->where('applicant_id', $id);
        $this->db->order_by('date_update', 'desc');
        return $this->db->get($this->_table, 5)->result();
    }

    public function update($id)
    {
        $where = ['sch_code' => $id];
        $sch = $this->schedule_model->getField('sch_code,sch_reply,emp_id', $where)->row();
        $user = $this->session->userdata('emp_id');

        if ($sch->sch_reply && $sch->emp_id && $user == $sch->emp_id) {
            $data['sch_reply'] = $this->input->post('sch_reply', FALSE);
            $this->db->where(['sch_code' => $id, 'emp_id' => $user]);
        } else {
            $data['sch_reply'] = $this->input->post('sch_reply', FALSE);
            $data['emp_id'] = $user;

            $emp = $this->employee_model->getDataBy($sch->emp_id, 'emp_id')->row();
            $data['responsible_person'] = $emp->first_name . ' ' . $emp->last_name . '<hr class="my-0">' . $emp->pos_name . '<hr class="my-0">' . $emp->email . '<hr class="my-0">' . $emp->phone;
            $this->db->where('sch_code', $id);
        }

        $this->db->update($this->_table, $data);
    }
}

/* End of file Schedule_model.php */
