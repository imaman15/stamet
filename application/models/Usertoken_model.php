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

    public function readToken($email, $user, $action)
    {
        $query = $this->db->get_where($this->_table, ["email" => $email, "user" => $user, "action" => $action]);
        return $query;
    }

    public function delByEmail($email, $user, $action)
    {
        return $this->db->delete($this->_table, ["email" => $email, "user" => $user, "action" => $action]);
    }
}

/* End of file Usertoken.php */
