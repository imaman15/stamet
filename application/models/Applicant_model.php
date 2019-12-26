<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

    private $_table = "applicant";

    public $applicant_id;
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
        $this->applicant_id = $user;
        $this->db->from($this->_table);
        if ($this->applicant_id != NULL) {
            $this->db->where('applicant_id', $this->applicant_id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $this->email = htmlspecialchars($post["email"], true);
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->photo;
        $this->first_name = htmlspecialchars(ucwords($post["first_name"]), true);
        $this->last_name = htmlspecialchars(ucwords($post["last_name"]), true);
        $this->nin = $post["nin"];
        $this->address = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $this->education = $post["education"];
        $this->job_category = $post["job_category"];
        $this->institute = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $this->phone = phoneNumber($post["phone"]);
        $this->is_active;
        $this->date_created = time();
        $this->db->insert($this->_table, $this);
    }

    public function update($post)
    {
        $this->applicant_id = $this->session->userdata('applicant_id');
        $this->email = $post["email"];
        $this->photo;
        $params['first_name'] = htmlspecialchars(ucwords($post["first_name"]), true);
        $params['last_name'] = htmlspecialchars(ucwords($post["last_name"]), true);
        $params['nin'] = $post["nin"];
        $params['address'] = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $params['education'] = $post["education"];
        $params['job_category'] = $post["job_category"];
        $params['institute'] = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $params['phone'] = phoneNumber($post["phone"]);
        $this->db->where(array('applicant_id' => $this->applicant_id, 'email' => $this->email));
        $this->db->update($this->_table, $params);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["applicant_id" => $id]);
    }
}

/* End of file Applicant_model.php */
