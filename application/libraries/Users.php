<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Users
{
    protected $ci;


    public function __construct()
    {
        $this->ci = &get_instance();
    }

    function applicant()
    {
        $this->ci->load->model('applicant_model');
        $user = $this->ci->session->userdata('applicant_id');
        $user_data = $this->ci->applicant_model->getData($user)->row();
        return $user_data;
    }
}


/* End of file Users.php */
