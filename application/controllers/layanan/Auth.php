<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('form_validation');
        
    }

    public function index()
    {   
        $valid = $this->form_validation;
        $valid->set_rules('email', 'Email', 'trim|required|valid_email',[
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format Email tidak benar.'
        ]);
        $valid->set_rules('password', 'Kata Sandi', 'trim|required',[
            'required' => 'Kata Sandi harus diisi.'
        ]);
        
        if ($this->form_validation->run() == FALSE) {
            $data = array( 
                'title' => 'Login Page',
                'content' => 'layanan/auth/login'
            );
            $this->load->view('layout/layanan/auth/wrapper', $data, FALSE);
        } else {
            // ketika Validasi Sukses
            $this->_login();
            // _login() method ini adalah method private yang hanya bisa di akses oleh class ini saja yang nanti tidak bisa di akses lewat URL dengan ditandai "_"
        }
    }

    private function _login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $user = $this->db->get_where('pengguna', ['email' => $email])->row_array();
        // row_array() itu untuk mendapatkan satu baris saja.
        
        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                //cek password
                // password_verify() untuk menyamakan antara password yang di ketikan di login dengan password yg sudah di hash
                if (password_verify($password, $user['password'])) {
                    // password benar
                    $data = [
                        'email' => $user['email']
                    ];
                    
                    $this->session->set_userdata( $data );
                    redirect('layanan/beranda');
                    
                    
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password salah!
                    </div>');
                    redirect('layanan/auth');
                }
            }else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email ini belum diaktifkan!
                </div>');
                redirect('layanan/auth');
            }

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email tidak terdaftar!
            </div>');
            redirect('layanan/auth');
        }
        
    }
    
    public function registration()
    {
        $valid = $this->form_validation;
        $valid -> set_rules('name', 'Nama Lengkap', 'required|trim',
        [
            'required' => 'Nama Lengkap harus diisi.'
        ]);
        $valid -> set_rules('email', 'Email', 'required|trim|valid_email|is_unique[pengguna.email]',
        [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format Email tidak benar.',
            'is_unique'=> 'Email ini sudah terdaftar.'
        ]);
        $valid -> set_rules('password', 'Kata Sandi', 'trim|required|min_length[6]|matches[confirmPassword]',
        [
            'required' => 'Kata Sandi harus diisi.',
            'min_length'=> 'Kata Sandi minimal 6 karakter',
            'matches' => 'Kata Sandi Tidak Cocok.'
        ]);
        $valid -> set_rules('confirmPassword', 'Kata Sandi', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data = [ 
                'title' => 'User Registration Page',
                'content' => 'layanan/auth/registration'
            ];
            $this->load->view('layout/layanan/auth/wrapper', $data, FALSE);
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
                'is_active' => 1,
                'date_created' => time()
            ];
            // "true" pada input post adalah untuk menghindari XSS atau Cross-site Scripting, XSS adalah jenis serangan ke sebuah situs dengan cara ’menyisipkan’ kode script (biasanya JavaScript) ke dalam sebuah situs
            // "htmlspecialchars" adalah  sebuah fungsi atau sebuah perintah atau sintax yang di miliki oleh PHP yang berguna untuk menontaktifkan seluruh perintah – perintah html
            // info lebih lengkap = https://www.duniailkom.com/tutorial-form-php-validasi-form-untuk-mencegah-cross-site-scripting-dan-html-injection/

            $this->db->insert('pengguna', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Selamat! Akun anda telah dibuat. Silahkan masuk!
            </div>');
            
            redirect('layanan/auth');
            
        }
    }

    public function logout(){
        
        $this->session->unset_userdata('email');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Anda telah keluar.
        </div>');
        
        redirect('layanan/auth');
    }

}

/* End of file Auth.php */
