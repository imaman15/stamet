<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        app_not_login();
        $this->load->library(array('form_validation'));
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Beranda';
        $data['user'] = $this->users->applicant();
        $this->template->load('user/profil', $data);
    }

    // Add a new item
    public function add()
    {
    }

    public function update()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->users->applicant();

        if ($this->form_validation->run('update_applicant') == FALSE) {
            $this->template->load('user/update', $data);
        } else {
            $emailnow = $this->users->applicant()->email;
            $emailform = $this->input->post('email');
            if ($emailnow !== $emailform) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Email tidak sesuai. Profil anda gagal diedit.</div>');
                redirect(UA_EDITPROFILE);
            } else {
                $post = $this->input->post(null, TRUE);
                $this->applicant_model->update($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Selamat!</strong> Profil anda berhasil diedit.</div>');
                    redirect(UA_EDITPROFILE);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Profil anda gagal diedit.</div>');
                redirect(UA_EDITPROFILE);
            }
        }
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }
}

/* End of file User.php */
