<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Position_model extends CI_Model
{
    private $_table = "position";

    public function getData($where = NULL)
    {
        $this->db->from($this->_table);
        if ($where != NULL) {
            $this->db->where($where);
        }
        return $this->db->get();
    }
}

/* End of file Position_model.php */
