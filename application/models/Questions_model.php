<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Questions_model extends CI_Model
{
    private $_table = 'rate_questions';

    // start datatables
    var $column_order = array(null, 'description', 'date_created', 'date_update', null); //set column field database for datatable orderable
    var $column_search = array('description', 'date_created', 'date_update'); //set column field database for datatable searchable
    var $order = array('ratque_id' => 'asc'); // default order

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
        $post = $this->input->post(NULL, TRUE);
        $params['description'] = $post['description'];
        $params['information'] = $post['information'];
        $params['date_created'] = date("Y-m-d H:i:s");
        $this->db->insert($this->_table, $params);
    }

    public function update()
    {
        $post = $this->input->post(NULL, TRUE);
        $params['description'] = $post['description'];
        $params['information'] = $post['information'];
        $this->db->where('ratque_id', $post['ratque_id']);
        $this->db->update($this->_table, $params);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["ratque_id" => $id]);
    }

    public function getData($where = NULL)
    {
        $this->db->from($this->_table);
        if ($where != NULL) {
            $this->db->where($where);
        }
        return $this->db->get();
    }
}

/* End of file Questions.php */
