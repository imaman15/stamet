<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Configuration_model extends CI_Model
{

    private $_table = "configuration";

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

    public function update()
    {
        $post = $this->input->post(NULL, TRUE);
        $data['bank_name'] = $post['bank_name'];
        $data['account_number'] = $post['account_number'];
        $data['account_name'] = $post['account_name'];
        $data['email_reply'] = $post['email_reply'];
        $this->db->where('id', 1);
        $this->db->update($this->_table, $data);
    }
}

/* End of file Configuration_model.php */
