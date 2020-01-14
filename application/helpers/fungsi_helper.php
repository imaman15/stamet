<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function secho($str)
{
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function app_already_login()
{
    $CI = &get_instance();
    $user_session = $CI->session->userdata('applicant_id');
    $logged_in = $CI->session->userdata('logged_in');

    if ($user_session && $logged_in == TRUE) {
        redirect(site_url());
    }
}

function app_not_login()
{
    $CI = &get_instance();
    $user_session = $CI->session->userdata('applicant_id');
    $logged_in = $CI->session->userdata('logged_in');
    if (!$user_session && $logged_in !== TRUE) {
        redirect(UA_LOGIN);
    }
}

function app_del_login()
{
    $CI = &get_instance();
    $CI->load->model('applicant_model');
    $user = $CI->applicant_model->getData()->row();
    if (!$user) {
        $CI->session->unset_userdata('applicant_id');
        $CI->session->unset_userdata('logged_in');
        $CI->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Anda telah keluar! </div>');
        redirect(UA_LOGIN);
    }
}

function cr()
{
    $year = 2019;
    $yearnow = date('Y');
    if ($yearnow == $year) {
        echo $yearnow;
    } else {
        echo $year . ' - ' . $yearnow;
    }
}

function phoneNumber($number)
{
    // situs http://agussaputra.com/read-article-40-mengubah+62+menjadi+0+dan+0+menjadi+62++sms.html

    $hp = "";
    // kadang ada penulisan no hp 0811 239 345
    $number = str_replace(" ", "", $number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace("(", "", $number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace(")", "", $number);
    // kadang ada penulisan no hp 0811.239.345
    $number = str_replace(".", "", $number);
    // kadang ada penulisan no hp 0811-239-345
    $number = str_replace("-", "", $number);

    // cek apakah no hp mengandung karakter + dan 0-9
    if (!preg_match('/[^+0-9]/', trim($number))) {
        // cek apakah no hp karakter 1-3 adalah +62
        if (substr(trim($number), 0, 3) == '+62') {
            $hp = trim($number);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif (substr(trim($number), 0, 1) == '0') {
            $hp = '+62' . substr(trim($number), 1);
        }
        // cek apakah no hp karakter 1 adalah 62
        elseif (substr(trim($number), 0, 2) == '62') {
            $hp = '+' . trim($number);
        }
    }
    return $hp;
    // Dan berikut untuk menampilkan kembali "+62" menjadi "0":
    // $hp0 = substr_replace($hp,'0',0,3);

}

function get_random_password($chars_min, $chars_max, $use_upper_case, $include_numbers, $include_special_chars)
{
    $length = rand($chars_min, $chars_max);
    $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
    if ($include_numbers) {
        $selection .= "1234567890";
    }
    if ($include_special_chars) {
        $selection .= '/[!@#$%^&*()\-_=+{};:,<.>~]/';
    }

    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
        $password .=  $current_letter;
    }

    return $password;
}

function level($data)
{
    if ($data == 1) {
        return "Administrator";
    } elseif ($data == 2) {
        return "Kasi Datin";
    } elseif ($data == 3) {
        return "Petugas Layanan";
    }
}

function dataLevel()
{
    $data = '<option value="1">Administrator</option>';
    $data .= '<option value="2">Kasi DATIN</option>';
    $data .= '<option value="3">Petugas Layanan</option>';
    return $data;
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}


function timeIDN($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}

function sendMail($email, $subject, $message)
{
    $CI = &get_instance();

    //smtp (simple mail transfer protocol )
    $config = [
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_user' => 'bfundangan@gmail.com',
        'smtp_pass' => 'BFU970817',
        'smtp_port' => 465,
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        // 'wordwrap' => TRUE
    ];
    // kirim email
    $CI->email->initialize($config);
    $CI->email->from('no-reply@sipjamet.com', 'Stasiun Meteorologi Kelas I Maritim Serang');
    $CI->email->to($email);
    $CI->email->subject($subject);
    $CI->email->message($message);
}
