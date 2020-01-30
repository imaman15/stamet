<?php

defined('BASEPATH') or exit('No direct script access allowed');


$required = '%s tidak boleh kosong.';
$nin_unique = '%s sudah terdaftar. jika anda merasa belum pernah mendaftarkan Nomor Identitas (KTP) di aplikasi ini silahkan <a href="' . site_url(FAQ) . '">hubungi kami!</a>';
$valid_email = '%s harus berupa alamat surel yang valid.';

//Set Rules User Applicant
$first_name = array(
    'field' => 'first_name',
    'label' => '<strong>Nama Depan</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required
    ]
);
$last_name = array(
    'field' => 'last_name',
    'label' => '<strong>Nama Belakang</strong>',
    'rules' => 'trim'
);
$nin = array(
    'field' => 'nin',
    'label' => '<strong>Nomor Identitas (KTP)</strong>',
    'rules' => 'trim|required|exact_length[16]|numeric|is_unique[applicant.nin]',
    'errors' => [
        'required' => $required,
        'exact_length' => '%s harus 16 digit',
        'numeric' => '%s harus berupa angka',
        'is_unique' => $nin_unique
    ]
);
$address = array(
    'field' => 'address',
    'label' => '<strong>Alamat</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required
    ]
);
$phone = array(
    'field' => 'phone',
    'label' => '<strong>Nomor Handphone</strong>',
    'rules' => 'trim|required|max_length[15]|numeric',
    'errors' => [
        'required' => $required,
        'max_length' => '%s maksimal 15 digit',
        'numeric' => '%s harus berupa angka',
    ]
);
$job_category = array(
    'field' => 'job_category',
    'label' => '<strong>Kategori Pekerjaan</strong>',
    'rules' => 'required',
    'errors' => [
        'required' => $required
    ]
);
$institute = array(
    'field' => 'institute',
    'label' => '<strong>Nama Instansi</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required
    ]
);
$email = array(
    'field' => 'email',
    'label' => '<strong>Email</strong>',
    'rules' => 'trim|required|valid_email|is_unique[applicant.email]',
    'errors' => [
        'required' => $required,
        'valid_email' => $valid_email,
        'is_unique' => '%s sudah terdaftar.'
    ]
);
$email2 = array(
    'field' => 'email',
    'label' => '<strong>Email</strong>',
    'rules' => 'trim|required|valid_email',
    'errors' => [
        'required' => $required,
        'valid_email' => $valid_email
    ]
);
$password = array(
    'field' => 'password',
    'label' => '<strong>Kata Sandi</strong>',
    'rules' => 'callback_vallid_passworrd'
);
$confirmPassword = array(
    'field' => 'confirmPassword',
    'label' => '<strong>Konfirmasi Kata Sandi</strong>',
    'rules' => 'trim|required|matches[password]',
    'errors' => [
        'required' => $required,
        'matches' => '%s tidak cocok.'
    ]
);
$checkme = array(
    'field' => 'checkme',
    'label' => '<strong>Ketentuan Pendaftaran</strong>',
    'rules' => 'required',
    'errors' => [
        'required' => '%s harus di centang'
    ]
);

// $gRecaptchaResponse = array(
//     'field' => 'g-recaptcha-response',
//     'label' => '<strong>Captcha</strong>',
//     'rules' => 'callback_getRresponseCcaptcha'
// );

// Set Rules Change Password Applicant
$currentPassword = array(
    'field' => 'currentPassword',
    'label' => '<strong>Kata Sandi</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required,
    ]
);
// Set Rule Employee
$emailEmp = array(
    'field' => 'email',
    'label' => '<strong>Email</strong>',
    'rules' => 'trim|required|valid_email|is_unique[employee.email]',
    'errors' => [
        'required' => $required,
        'valid_email' => $valid_email,
        'is_unique' => '%s sudah terdaftar.'
    ]
);
$csidn =  array(
    'field' => 'csidn',
    'label' => '<strong>No. Identitas Pegawai (NIP)</strong>',
    'rules' => 'trim|required|exact_length[18]|numeric',
    'errors' => [
        'required' => $required,
        'exact_length' => '%s harus 18 digit',
        'numeric' => '%s harus berupa angka'
    ]
);
$position_name = array(
    'field' => 'position_name',
    'label' => '<strong>Jabatan</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required
    ]
);
$level = array(
    'field' => 'level',
    'label' => '<strong>Level</strong>',
    'rules' => 'trim|required',
    'errors' => [
        'required' => $required
    ]
);

if (isset(dAdmin()->level) && dAdmin()->level == 1) {
    $field = array(
        $first_name, $last_name, $email2, $csidn, $address, $phone, $position_name, $level
    );
} else {
    $field = array(
        $first_name, $last_name, $email2, $csidn, $address, $phone
    );
}

//=======================================================
// SET RULE TRANSAKSI
$transadd = [
    array(
        'field' => 'trans_message',
        'label' => '<strong>Pesan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE SCHEDULE
$schadd = [
    array(
        'field' => 'sch_title',
        'label' => '<strong>Judul</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'sch_type',
        'label' => '<strong>Jenis Permintaan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'sch_date',
        'label' => '<strong>Tanggal Pertemuan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'sch_message',
        'label' => '<strong>Pesan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE COMPLAINT
$compadd = [
    array(
        'field' => 'comp_title',
        'label' => '<strong>Judul</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'comp_message',
        'label' => '<strong>Pesan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE COMPLAINT
$compemp = [
    array(
        'field' => 'reply_message',
        'label' => '<strong>Pesan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE SCHEDULE
$schemp = [
    array(
        'field' => 'sch_reply',
        'label' => '<strong>Pesan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE FAQS
$faqadd = [
    array(
        'field' => 'faqs_questions',
        'label' => '<strong>Judul Pertanyaan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'faqs_answers',
        'label' => '<strong>Jawaban Pertanyaan</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    )
];

//=======================================================
// SET RULE CONFIGURATION
$confadd = [
    array(
        'field' => 'bank_name',
        'label' => '<strong>Bank</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'account_number',
        'label' => '<strong>No. Rekening</strong>',
        'rules' => 'trim|required|numeric',
        'errors' => [
            'required' => $required,
            'numeric' => '%s harus berupa angka'
        ]
    ),
    array(
        'field' => 'account_name',
        'label' => '<strong>Atas nama</strong>',
        'rules' => 'trim|required',
        'errors' => [
            'required' => $required
        ]
    ),
    array(
        'field' => 'email_reply',
        'label' => '<strong>Email</strong>',
        'rules' => 'trim|required|valid_email',
        'errors' => [
            'required' => $required,
            'valid_email' => $valid_email
        ]
    )
];

//=======================================================
// Set Rules
$config = array(
    'schemp' => $schemp,
    'compemp' => $compemp,
    'confadd' => $confadd,
    'faqadd' => $faqadd,
    'compadd' => $compadd,
    'schadd' => $schadd,
    'transadd' => $transadd,
    'employee' => $field,
    'resetpassword_applicant' => array(
        $email2,
    ),
    'changepass_applicant' => array(
        $currentPassword, $password, $confirmPassword
    ),
    'changepass2_applicant' => array(
        $password, $confirmPassword,
    ),
    'update_applicant' => array(
        $first_name, $last_name, $address, $phone, $job_category, $institute
    ),
    'signup_applicant' => array(
        $first_name, $last_name, $nin, $address, $phone, $job_category, $institute, $email, $password, $confirmPassword, $checkme,
    ),
    'signin_applicant' => array(
        $email2,
        array(
            'field' => 'password',
            'label' => '<strong>Password</strong>',
            'rules' => 'required|trim',
            'errors' => [
                'required' => $required,
            ]
        ),

    )
);


$config['error_prefix'] = '<small class="text-danger pl-3 d-block">';
$config['error_suffix'] = '</small>';
/* End of file form_validation.php */
