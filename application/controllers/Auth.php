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
        $data['title'] = 'Login';
        $this->template->auth('template_login', 'auth/login', $data, FALSE);
    }

    public function registration()
    {
        if ($this->form_validation->run('signup_applicant') == false) {
            $data['title'] = 'Daftar';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/registration', $data, FALSE);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->applicant_model->add($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                <strong>Selamat!</strong> Akun anda berhasil dibuat. Silahkan login.</div>');
                redirect(UA_LOGIN);
            }
            $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Akun anda gagal dibuat. Silahkan daftar kembali.</div>');
            redirect(UA_REGISTRATION);
        }
    }

    public function getRresponseCcaptcha($str)
    {
        // $recaptcha = $this->input->post('g-recaptcha-response');
        // $response = $this->recaptcha->verifyResponse($recaptcha);

        $response = $this->recaptcha->verifyResponse($str);
        if ($response['success']) {
            return true;
        } else {
            $this->form_validation->set_message('getRresponseCcaptcha', '%s Harus di isi.');
            return false;
        }
    }

    public function vallid_passworrd($password = '')
    {
        //Regex merupakan singkatan dari Regular Expression, yaitu sebuah metode untuk mencari suatu pola dalam sebuah string.
        //Fungsi yang digunakan untuk Regex dalam php adalah preg_match($regex, $string), di mana $regex adalah pola yang akan dicari dan $string adalah variabel yang akan dicari apakah ada pola $regex di dalamnya.

        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->form_validation->set_message('vallid_passworrd', '{field} tidak boleh kosong.');
            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('vallid_passworrd', '{field} harus memiliki minimal satu huruf kecil');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('vallid_passworrd', '{field} harus memiliki minimal satu huruf besar');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('vallid_passworrd', '{field} harus memiliki minimal satu angka');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('vallid_passworrd', '{field} harus memiliki minimal satu simbol');
            return FALSE;
        }
        if (strlen($password) < 6) {
            $this->form_validation->set_message('vallid_passworrd', '{field} minimal 6 karakter.');
            return FALSE;
        }
        if (strlen($password) > 32) {
            $this->form_validation->set_message('vallid_passworrd', '{field} maksimal 32 karakter');
            return FALSE;
        }

        return TRUE;
    }
}

/* End of file Auth.php */
