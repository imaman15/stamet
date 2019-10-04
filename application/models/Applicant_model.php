<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

    private $_table = "applicant";

    public $email;
    public $password;
    public $photo = "default.jpg";
    public $first_name;
    public $last_name;
    public $nik;
    public $address;
    public $education;
    public $job_category;
    public $institute;
    public $phone;
    public $is_active;
    public $date_created;
    public $date_update;

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
        // result() fungsi untuk mengambil semua data hasil query
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["applicant_id" => $id])->row();
        // row() fungsi untuk mengambil satu data dari hasil query
    }

    public function save()
    {
        $post = $this->input->post();
    }

    public function update()
    {
        $post = $this->input->post();
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["applicant_id" => $id]);
    }

    public function rules()
    {
        $required = '%s tidak boleh kosong.';
        return [
            'login' =>
            [
                [
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email',
                    'errors' => [
                        'required' => $required,
                        'valid_email' => 'Format %s tidak benar.'
                    ]
                ],

                [
                    'field' => 'password',
                    'label' => 'Kata Sandi',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required,
                        'min_length' => '%s minimal 6 karakter',
                        'matches' => '%s Tidak Cocok.'
                    ]
                ]
            ],
            'registration' =>
            [
                [
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email|is_unique[pengguna.email]',
                    'errors' => [
                        'required' => $required,
                        'valid_email' => 'Format %s tidak benar.',
                        'is_unique' => '%s ini sudah terdaftar.'
                    ]
                ],

                [
                    'field' => 'password',
                    'label' => 'Kata Sandi',
                    'rules' => 'trim|required|min_length[6]|matches[confirmPassword]',
                    'errors' => [
                        'required' => $required,
                        'min_length' => '%s minimal 6 karakter',
                        'matches' => '%s Tidak Cocok.'
                    ]
                ],

                [
                    'field' => 'confirmPassword',
                    'label' => 'Konfirmasi Kata Sandi',
                    'rules' => 'trim|required|matches[password]'
                ],

                [
                    'field' => 'firstName',
                    'label' => 'Nama Depan',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'lastName',
                    'label' => 'Nama Belakang',
                    'rules' => 'trim'
                ],

                [
                    'field' => 'address',
                    'label' => 'Alamat',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'education',
                    'label' => 'Pendidikan',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'job_category',
                    'label' => 'Kategori Pekerjaan',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'institute',
                    'label' => 'Instansi',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'phone',
                    'label' => 'Nomor Telepon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $required
                    ]
                ],

                [
                    'field' => 'g-recaptcha-response',
                    'label' => '<strong>Captcha</strong>',
                    'rules' => 'callback_getResponseCaptcha'
                ]
            ]
        ];
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

/* End of file Applicant_model.php */
