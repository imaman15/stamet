<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usertoken_model extends CI_Model
{

    private $_table = "user_token";

    public function add($user_token)
    {
        $this->db->insert('user_token', $user_token);
    }

    public function getToken($token)
    {
        $query = $this->db->get_where($this->_table, ['token' => $token])->row_array();
        return $query;
    }
    public function delByEmail($email)
    {
        return $this->db->delete($this->_table, ["email" => $email]);
    }
}

/* End of file Usertoken.php */
