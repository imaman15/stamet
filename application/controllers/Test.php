<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Test extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'recaptcha'));
    }
    public function index()
    {
        $data = array(
            'action' => site_url('test/login'),
            'username' => set_value('username'),
            'password' => set_value('password'),
            'captcha' => $this->recaptcha->getWidget(), // menampilkan recaptcha
            'script_captcha' => $this->recaptcha->getScriptTag(), // javascript recaptcha ditaruh di head
        );
        $this->load->view('test', $data);
    }
    public function login()
    {

        // validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('g-recaptcha-response', '<strong>Captcha</strong>', 'callback_getResponseCaptcha');

        if ($this->form_validation->run() == TRUE) {

            // lakukan proses validasi login disini
            // pada contoh ini saya anggap login berhasil dan saya hanya menampilkan pesan berhasil
            // tapi ini jangan di contoh ya menulis echo di controller hahahaha
            echo 'Berhasil';
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong> Login Gagal! </strong>
            </div>');
            $this->index();
        }
    }

    public function getResponseCaptcha($str)
    {
        // $recaptcha = $this->input->post('g-recaptcha-response');
        // $response = $this->recaptcha->verifyResponse($recaptcha);

        $response = $this->recaptcha->verifyResponse($str);
        if ($response['success']) {
            return true;
        } else {
            $this->form_validation->set_message('getResponseCaptcha', '%s Harus di isi.');
            return false;
        }
    }
}
