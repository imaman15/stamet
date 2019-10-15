<?php

defined('BASEPATH') or exit('No direct script access allowed');


class User
{
    protected $ci;


    public function __construct()
    {
        $this->ci = &get_instance();
    }

    function applicant()
    {
        $this->ci->load->model('applicant_model');
        $user = $this->ci->session->userdata('user');
        $user_data = $this->ci->applicant_model->get($user)->row();
        return $user_data;
    }
}


/* End of file User.php */
