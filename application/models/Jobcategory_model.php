<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jobcategory_model extends CI_Model
{
    private $_table = "job_category";
    public $jobcat;
    public $jobcat_information;

    public function getData($id = NULL)
    {
        $this->db->from($this->_table);
        if ($id != NULL) {
            $this->db->where('jobcat_id', $id);
        }
        return $this->db->get();
    }
}

/* End of file Jobcategory_model.php */
