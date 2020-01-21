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
}

/* End of file Configuration_model.php */
