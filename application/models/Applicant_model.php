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
    public $nin;
    public $address;
    public $education;
    public $job_category;
    public $institute;
    public $phone;
    public $is_active = 1;
    public $date_created;

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

    public function add($post)
    {
        $this->email = $post["email"];
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->photo;
        $this->first_name = ucwords($post["first_name"]);
        $this->last_name = ucwords($post["last_name"]);
        $this->nin = $post["nin"];
        $this->address = $post["address"] != "" ? $post["address"] : null;
        $this->education = $post["education"];
        $this->job_category = $post["job_category"];
        $this->institute = $post['institute'] != "" ? ucwords($post["institute"]) : null;
        $this->phone = phoneNumber($post["phone"]);
        $this->is_active;
        $this->date_created = time();
        $this->db->insert($this->_table, $this);
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
