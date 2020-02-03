<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    private $_table = 'transaction';

    private function _get_datatables_query($for = NULL, $start = NULL, $end = NULL)
    {
        $order = array('trans_id' => 'asc');

        if ($for == "rates") {
            $column_order = array(null, 'date_created', 'apply_name', 'trans_request', 'trans_sum');
            $column_search = array('date_created', 'apply_name', 'apply_institute', 'trans_request', 'trans_code', 'trans_sum');
            $wh = ["trans_status" => 4, "payment_status !=" => 0];
        } else {
            $column_order = array(null, 'date_created', 'apply_name', 'trans_request');
            $column_search = array('date_created', 'apply_name', 'apply_institute', 'trans_request', 'trans_code');
            $wh = ["trans_status" => 4, "payment_status" => 0];
        }

        if ($start && $end) {
            $this->db->where($wh);
            $this->db->where("date_created BETWEEN '$start' AND '$end'");
        } else {
            $this->db->where($wh);
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

    function get_datatables($for = NULL, $start = NULL, $end = NULL)
    {
        $this->_get_datatables_query($for, $start, $end);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($for = NULL, $start = NULL, $end = NULL)
    {
        $this->_get_datatables_query($for, $start, $end);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($for = NULL, $start = NULL, $end = NULL)
    {

        if ($for == "rates") {
            $wh = ["trans_status" => 4, "payment_status !=" => 0];
        } else {
            $wh = ["trans_status" => 4, "payment_status" => 0];
        }

        if ($start && $end) {
            $this->db->where($wh);
            $this->db->where("date_created BETWEEN '$start' AND '$end'");
        } else {
            $this->db->where($wh);
        }

        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    //=======================================================

    public function print($for = NULL, $start = NULL, $end = NULL)
    {
        $this->db->from($this->_table);

        if ($for == "rates") {
            $wh = ["trans_status" => 4, "payment_status !=" => 0];
        } else {
            $wh = ["trans_status" => 4, "payment_status" => 0];
        }

        if ($start != NULL && $end != NULL) {
            $this->db->where($wh);
            $this->db->where("date_created BETWEEN '$start' AND '$end'");
        } else {
            $this->db->where($wh);
        }
        $this->db->order_by('trans_id', 'asc');
        return $this->db->get();
    }
}

/* End of file Report_model.php */
