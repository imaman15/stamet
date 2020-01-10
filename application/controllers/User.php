<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        app_not_login();
        $this->load->library(['form_validation']);
        $this->load->model(['applicant_model', 'jobcategory_model']);
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Beranda';
        $data['user'] = $this->applicant_model->getData()->row();
        $this->template->load('user/profil', $data);
    }

    // Add a new item
    public function add()
    {
    }

    public function update()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->applicant_model->getData()->row();
        $data['jobcategory'] = $this->jobcategory_model->getData();
        if ($this->form_validation->run('update_applicant') == FALSE) {
            $this->template->load('user/update', $data);
        } else {
            $emailnow = $data['user']->email;
            $emailform = $this->input->post('email');
            if ($emailnow !== $emailform) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Email tidak sesuai. Profil Anda gagal diperbarui.</div>');
                redirect(UA_EDITPROFILE);
            } else {
                $post = $this->input->post(null, TRUE);
                $this->applicant_model->update($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat!</strong> Profil Anda telah diperbarui.</div>');
                    redirect(UA_PROFILE);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Profil Anda gagal diperbarui.</div>');
                redirect(UA_EDITPROFILE);
            }
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Ganti Kata Sandi';
        $data['user'] = $this->applicant_model->getData()->row();

        if ($this->form_validation->run('changepass_applicant') == FALSE) {
            $this->template->load('user/changepassword', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->applicant_model->changepassword($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat!</strong> Kata sandi Anda berhasil diubah.</div>');
                redirect(UA_PROFILE);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
            <strong>Maaf!</strong> Kata sandi Anda gagal diubah.</div>');
            redirect(UA_CHANGEPASSWORD);
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
        // $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

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
        // if (preg_match_all($regex_special, $password) < 1) {
        //     $this->form_validation->set_message('vallid_passworrd', '{field} harus memiliki minimal satu simbol');
        //     return FALSE;
        // }
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

    //Delete one item
    public function delete($id = NULL)
    {
    }
}

/* End of file User.php */
