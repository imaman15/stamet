<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'recaptcha'));
        $this->load->model("applicant_model");
    }


    public function login()
    {
        $data['title'] = '';
        $this->template->auth('template_login', 'auth/login', $data, FALSE);
    }

    public function registration()
    {
        if ($this->form_validation->run('signup_applicant') == false) {
            $data['title'] = 'Daftar';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/registration', $data, FALSE);
        } else {
            echo "data berhasil di tambahkan";
        }
    }

    public function getResponseCaptcha($str)
    {
        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if ($response['success']) {
            return true;
        } else {
            $this->form_validation->set_message('getResponseCaptcha', '%s Harus di isi.');
            return false;
        }
    }

    public function valid_password($password = '')
    {
        //Regex merupakan singkatan dari Regular Expression, yaitu sebuah metode untuk mencari suatu pola dalam sebuah string.
        //Fungsi yang digunakan untuk Regex dalam php adalah preg_match($regex, $string), di mana $regex adalah pola yang akan dicari dan $string adalah variabel yang akan dicari apakah ada pola $regex di dalamnya.

        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $lower = 1;
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1) {
            $upper = 1;
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1) {
            $number = 1;
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1) {
            $symbol = 1;
            return FALSE;
        }



        $this->form_validation->set_message('valid_password', '{field} harus memiliki minimal satu ' . $valid);
        return TRUE;
    }
}

/* End of file Auth.php */
