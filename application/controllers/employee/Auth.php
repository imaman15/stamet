<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'recaptcha', 'email'));
        $this->load->model(array('employee_model', 'usertoken_model'));
    }

    public function login()
    {
        app_already_login("admin");
        if ($this->form_validation->run('signin_applicant') == FALSE) {
            $data['title'] = 'Administrator';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_loginadmin', UE_FOLDER . '/auth/login', $data, FALSE);
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $user = $this->employee_model->checkData(["email" => $email])->row();
            //jika usernya ada
            if ($user) {
                //jika usernya aktif
                if ($user->is_active == 1) {
                    //cek password
                    // password_verify() untuk menyamakan antara password yang di ketikan di login dengan password yg sudah di hash
                    if (password_verify($password, $user->password)) {
                        // password benar
                        $data = [
                            'emp_id' => $user->emp_id,
                            'logged_in' => "admin"
                        ];

                        $this->session->set_userdata($data);

                        redirect(site_url(UE_ADMIN));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    <strong>Password</strong> salah!
                    </div>');
                        redirect(site_url(UE_LOGIN));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Email</strong> ini belum diaktifkan!
                </div>');
                    redirect(site_url(UE_LOGIN));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Email</strong> tidak terdaftar! </div>');
                redirect(site_url(UE_LOGIN));
            }
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->employee_model->checkData(['email' => $email])->row_array();
        $user_token = $this->usertoken_model->getToken($token);

        if ($user) {
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->employee_model->updateActivation($email);
                    $this->usertoken_model->delByEmail($email, "employee", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Selamat! </strong>' . $email . ' telah diaktifkan. Silahkan login.</div>');
                    redirect(UE_LOGIN);
                } else {
                    $this->employee_model->delete($email, "email");
                    $this->usertoken_model->delByEmail($email, "employee", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda kedaluwarsa. Silahkan hubungi Admin.</div>');
                    redirect(UE_LOGIN);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda tidak valid.</div>');
                redirect(UE_LOGIN);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            <strong>Maaf!</strong> Aktivasi akun gagal. Email Anda salah.</div>');
            redirect(UE_LOGIN);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('emp_id');
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Anda telah keluar! </div>');
        redirect(site_url(UE_LOGIN));
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
}

/* End of file Auth.php */
