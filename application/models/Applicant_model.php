<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

    private $_table = "applicant";

    public $email;
    public $password;
    public $photo = "default.jpg";
    public $first_name;
    public $last_name;
    public $nik;
    public $address;
    public $education;
    public $job_category;
    public $institute;
    public $phone;
    public $is_active;
    public $date_created;
    public $date_update;

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
        // result() fungsi untuk mengambil semua data hasil query
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["applicant_id" => $id])->row();
        // row() fungsi untuk mengambil satu data dari hasil query
    }

    public function save()
    {
        $post = $this->input->post();
    }

    public function update()
    {
        $post = $this->input->post();
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["applicant_id" => $id]);
    }
}

/* End of file Applicant_model.php */
