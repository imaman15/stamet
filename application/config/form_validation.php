<?php

defined('BASEPATH') or exit('No direct script access allowed');


$required = '%s tidak boleh kosong.';
$nin_unique = '%s sudah terdaftar. jika anda merasa belum pernah mendaftarkan Nomor Identitas (KTP) di aplikasi ini silahkan <a href="' . site_url(UA_FAQ) . '">hubungi kami!</a>';

$config = array(
    'signup_applicant' => array(
        array(
            'field' => 'first_name',
            'label' => '<strong>Nama Depan</strong>',
            'rules' => 'trim|required',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'last_name',
            'label' => '<strong>Nama Belakang</strong>',
            'rules' => 'trim'
        ),
        array(
            'field' => 'nin',
            'label' => '<strong>Nomor Identitas (KTP)</strong>',
            'rules' => 'trim|required|exact_length[16]|numeric|is_unique[applicant.nin]',
            'errors' => [
                'required' => $required,
                'exact_length' => '%s harus 16 digit',
                'numeric' => '%s harus berupa angka',
                'is_unique' => $nin_unique
            ]
        ),
        array(
            'field' => 'address',
            'label' => '<strong>Alamat</strong>',
            'rules' => 'trim|required',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'phone',
            'label' => '<strong>Nomor Handphone</strong>',
            'rules' => 'trim|required|max_length[15]|numeric',
            'errors' => [
                'required' => $required,
                'max_length' => '%s maksimal 15 digit',
                'numeric' => '%s harus berupa angka',
            ]
        ),
        array(
            'field' => 'education',
            'label' => '<strong>Pendidikan</strong>',
            'rules' => 'required',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'job_category',
            'label' => '<strong>Kategori Pekerjaan</strong>',
            'rules' => 'required',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'institute',
            'label' => '<strong>Nama Instansi</strong>',
            'rules' => 'trim|required',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'email',
            'label' => '<strong>Email</strong>',
            'rules' => 'trim|required|valid_email|is_unique[applicant.email]',
            'errors' => [
                'required' => $required,
                'valid_email' => '%s harus berupa alamat surel yang valid.',
                'is_unique' => '%s sudah terdaftar.'
            ]
        ),
        array(
            'field' => 'password',
            'label' => '<strong>Kata Sandi</strong>',
            'rules' => 'callback_vallid_passworrd',
            'errors' => [
                'required' => $required
            ]
        ),
        array(
            'field' => 'confirmPassword',
            'label' => '<strong>Konfirmasi Kata Sandi</strong>',
            'rules' => 'trim|required|matches[password]',
            'errors' => [
                'required' => $required,
                'matches' => '%s tidak cocok.'
            ]
        ),
        array(
            'field' => 'checkme',
            'label' => '<strong>Ketentuan Pendaftaran</strong>',
            'rules' => 'required',
            'errors' => [
                'required' => '%s harus di centang'
            ]
        ),
        array(
            'field' => 'g-recaptcha-response',
            'label' => '<strong>Captcha</strong>',
            'rules' => 'callback_getRresponseCcaptcha'
        )
    ),
    'signin_applicant' => array(
        array(
            'field' => 'emailaddress',
            'label' => '<strong>EmailAddress</strong>',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => '<strong>Name</strong>',
            'rules' => 'required|alpha'
        )
    )
);


$config['error_prefix'] = '<small class="text-danger pl-3 d-block">';
$config['error_suffix'] = '</small>';
/* End of file form_validation.php */
