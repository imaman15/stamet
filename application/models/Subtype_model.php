<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subtype_model extends CI_Model
{
    private $_table = "request_subtype";
    public $sub_description;
    public $unit;
    public $rates;
    public $type_id;

    public function getData($where = NULL)
    {
        $this->db->from($this->_table);
        if ($where != NULL) {
            $this->db->where($where);
        }
        return $this->db->get();
    }

    // start datatables
    var $column_order = array(null, 'sub_description', 'unit', 'rates', 'description', 'request_subtype.date_update', null); //set column field database for datatable orderable
    var $column_search = array('sub_description', 'unit', 'rates', 'description', 'request_subtype.date_update'); //set column field database for datatable searchable
    var $order = array('subtype_id' => 'desc'); // default order

    private function _get_datatables_query()
    {

        $this->db->select('request_subtype.*,request_type.description');
        $this->db->from('request_subtype');
        $this->db->join('request_type', 'request_type.type_id = request_subtype.type_id');

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
        $this->db->from('request_subtype');
        return $this->db->count_all_results();
    }
    //=======================================================

    public function add()
    {
        $post = $this->input->post(NULL, TRUE);
        $this->sub_description = $post['sub_description'];
        $this->unit = $post['unit'];
        $this->rates = $post['rates'];
        $this->type_id = $post['type_id'];
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post(NULL, TRUE);
        $this->sub_description = $post['sub_description'];
        $this->unit = $post['unit'];
        $this->rates = $post['rates'];
        $this->type_id = $post['type_id'];
        $this->db->where('subtype_id', $post["subtype_id"]);
        $this->db->update($this->_table, $this);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["subtype_id" => $id]);
    }

    public function groupData($type_id = NULL)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->join('request_type', $this->_table . '.type_id = request_type.type_id');
        if ($type_id != NULL) {
            $this->db->where($this->_table . '.type_id', $type_id);
        }
        return $this->db->get();
    }
}

/* End of file Subtype_model.php */
