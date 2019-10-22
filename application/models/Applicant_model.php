<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

    private $_table = "applicant";

    public $app_id;
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

    public function login($post)
    {
        $this->email = $post["email"];
        return $this->db->get_where($this->_table, ["email" => $this->email])->row();
        // row() fungsi untuk mengambil satu data dari hasil query
    }

    public function getData($user = NULL)
    {
        $this->app_id = $user;
        $this->db->from($this->_table);
        if ($this->app_id != NULL) {
            $this->db->where('applicant_id', $this->app_id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $this->email = htmlspecialchars($post["email"]);
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->photo;
        $this->first_name = htmlspecialchars(ucwords($post["first_name"]));
        $this->last_name = htmlspecialchars(ucwords($post["last_name"]));
        $this->nin = $post["nin"];
        $this->address = $post["address"] != "" ? htmlspecialchars($post["address"]) : null;
        $this->education = $post["education"];
        $this->job_category = $post["job_category"];
        $this->institute = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"])) : null;
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
