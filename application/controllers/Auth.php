<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'recaptcha', 'email'));
        $this->load->model(array('applicant_model', 'usertoken_model', 'jobcategory_model'));
    }

    public function login()
    {
        app_already_login();
        if ($this->form_validation->run('signin_applicant') == FALSE) {
            $data['title'] = 'Login';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/login', $data, FALSE);
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $user = $this->applicant_model->getDataBy($email, "email")->row();
            //jika usernya ada
            if ($user) {
                //jika usernya aktif
                if ($user->is_active == 1) {
                    //cek password
                    // password_verify() untuk menyamakan antara password yang di ketikan di login dengan password yg sudah di hash
                    if (password_verify($password, $user->password)) {
                        // password benar
                        $data = [
                            'applicant_id' => $user->applicant_id,
                            'logged_in' => "user"
                        ];

                        $this->session->set_userdata($data);

                        redirect(site_url());
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    <strong>Password</strong> salah!
                    </div>');
                        redirect(site_url(UA_LOGIN));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Email</strong> ini belum diaktifkan!
                </div>');
                    redirect(site_url(UA_LOGIN));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Email</strong> tidak terdaftar! </div>');
                redirect(site_url(UA_LOGIN));
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('applicant_id');
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Anda telah keluar! </div>');
        redirect(site_url(UA_LOGIN));
    }

    public function registration()
    {
        app_already_login();
        if ($this->form_validation->run('signup_applicant') == FALSE) {
            $data['title'] = 'Daftar';
            $data['user'] = $this->jobcategory_model->getData();
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/registration', $data, FALSE);
        } else {
            $post = $this->input->post(null, TRUE);
            //Create Token
            $email = $this->input->post('email', true);
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'user' => 'applicant',
                'action' => 'registration',
                'date_created' => time()
            ];
            //base64_encode untuk menterjemahkan random_bytes agar dikenali oleh MySQL
            $this->applicant_model->add($post);
            $this->usertoken_model->add($user_token);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                <strong>Selamat!</strong> Registrasi berhasil dilakukan, silahkan cek email anda untuk melakukan aktifasi akun <small class="pl-3 font-weight-light d-block text-muted">(Cek Folder <b>Spam</b> jika tidak ada email masuk)</small></div>');
                //=========== Send Email ===========
                $this->_sendEmail($token, 'verify');
                //=========== End Of Send Email ===========
                redirect(UA_LOGIN);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Registrasi gagal. Silahkan daftar kembali.</div>');
            redirect(UA_REGISTRATION);
        }
    }

    public function forgotpassword()
    {
        $email = $this->input->post('email', TRUE);
        if ($this->form_validation->run('resetpassword_applicant') == FALSE) {
            $data['title'] = 'Lupa Kata Sandi';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/forgotpassword', $data, FALSE);
        } else {
            $user = $this->applicant_model->resetpassword($email);

            if ($user) {
                $cekdata = $this->usertoken_model->readToken($email, 'applicant', 'resetpassword')->num_rows();
                if ($cekdata > 0) {
                    $this->usertoken_model->delByEmail($email, "applicant", "resetpassword");
                }
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'user' => 'applicant',
                    'action' => 'resetpassword',
                    'date_created' => time()
                ];
                $this->usertoken_model->add($user_token);
                //=========== Send Email ===========
                $this->_sendEmail($token, 'forgot');
                //=========== End Of Send Email ===========

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Silahkan cek email Anda untuk mengatur ulang kata sandi Anda <small class=" font-weight-light d-block text-muted">(Cek Folder <b>Spam</b> jika tidak ada email masuk)</small></div>');
                redirect(UA_FORGOTPASSWORD);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Email tidak terdaftar atau belum diaktifasi.</div>');
                redirect(UA_FORGOTPASSWORD);
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->applicant_model->getDataBy($email, "email")->row_array();
        $user_token = $this->usertoken_model->getToken($token);

        if ($user) {
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->changepassword();
                } else {
                    $this->usertoken_model->delByEmail($email, "applicant", "resetpassword");
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Kata sandi gagal diatur ulang. Token Anda kedaluwarsa.</div>');
                    redirect(UA_LOGIN);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Kata sandi gagal diatur ulang. Token Anda tidak valid.</div>');
                redirect(UA_LOGIN);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            <strong>Maaf!</strong> Kata sandi gagal diatur ulang. Email Anda salah.</div>');
            redirect(UA_LOGIN);
        }
    }

    public function changepassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect(UA_LOGIN);
        }

        if ($this->form_validation->run('changepass2_applicant') == FALSE) {
            $data['title'] = 'Atur Ulang Kata Sandi';
            $data['captcha'] = $this->recaptcha->getWidget(); // menampilkan recaptcha
            $this->template->auth('template_login', 'auth/changepassword', $data, FALSE);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->applicant_model->changepass($post);
            if ($this->db->affected_rows() > 0) {
                $email = $this->session->userdata('reset_email');
                $this->usertoken_model->delByEmail($email, "applicant", "resetpassword");
                $this->session->unset_userdata('reset_email');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                <strong>Selamat!</strong> Kata Sandi Anda berhasil diubah. Silahkan login</div>');
                redirect(UA_LOGIN);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Kata Sandi Anda gagal diubah.</div>');
            redirect(site_url('auth/changepassword'));
        }
    }

    public function _sendEmail($token, $type)
    {
        $email = $this->input->post('email');
        if ($type == 'verify') {
            $subject = 'SIPJAMET - Verifikasi Akun ';
            $message = '
            <p> Terimakasih telah melakukan registrasi. </p>
            <p>Silahkan Klik link berikut untuk melakukan Verifikasi :</p>
            <a href="' . site_url() . '' . UA_VERIFY . '?email=' . $email . '&token=' . urlencode($token) . '">Aktifkan Akun</a>';
            sendMail($email, $subject, $message);
            //base64_encode karakter tidak ramah url ada karakter tambah dan sama dengan nah ketika di urlnya ada karakter itu nanti akan di terjemahkan spasi jadi kosong. untuk menghindari hal sprti itu maka kita bungkus urlencode jadi jika ada karakter tadi maka akan di rubah jadi %20 dan strusnya. 
        } elseif ($type == 'forgot') {
            $subject = 'SIPJAMET - Atur Ulang Kata Sandi';
            $message = 'klik tautan ini untuk mengatur ulang kata sandi Anda : <a href="' . site_url() . '' . UA_RESETPASSWORD . '?email=' . $email . '&token=' . urlencode($token) . '">Atur Ulang Kata Sandi</a>';
            sendMail($email, $subject, $message);
        }

        if ($this->email->send()) {
            return TRUE;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->applicant_model->getDataBy($email, "email")->row_array();
        $user_token = $this->usertoken_model->getToken($token);

        if ($user) {
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->applicant_model->updateActivation($email);
                    $this->usertoken_model->delByEmail($email, "applicant", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Selamat! </strong>' . $email . ' telah diaktifkan. Silahkan login.</div>');
                    redirect(UA_LOGIN);
                } else {
                    $this->applicant_model->delByEmail($email);
                    $this->usertoken_model->delByEmail($email, "applicant", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda kedaluwarsa. Silahkan Daftar Kembali.</div>');
                    redirect(UA_LOGIN);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda tidak valid.</div>');
                redirect(UA_LOGIN);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            <strong>Maaf!</strong> Aktivasi akun gagal. Email Anda salah.</div>');
            redirect(UA_LOGIN);
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
        // $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>~]/';

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
}

/* End of file Auth.php */
