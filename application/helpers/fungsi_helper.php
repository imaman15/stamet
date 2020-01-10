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
    } elseif ($data == 4) {
        return "Petugas TU";
    }
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

// function checkEmp()
// {
//     $CI = &get_instance();
//     $c1 = $CI->employee_model->checkData('position_name = 1')->num_rows();
//     $c2 = $CI->employee_model->checkData('position_name = 2')->num_rows();
//     $c3 = $CI->employee_model->checkData('position_name = 3')->num_rows();
//     $c4 = $CI->employee_model->checkData('position_name = 4')->num_rows();

//     // if ($c1 > 0 && $c2 > 0) {
//     //     $CI->db->from('position');
//     //     $CI->db->where_not_in('pos_id', [1, 2]);
//     //     $data['position_name'] = $CI->db->get();
//     // } 

//     $i = $CI->employee_model->checkData('position_name IN (1,2,3,4)')->result();
//     switch ($i) {
//         case $i['position_name'] = 1:
//             $data['position_name'] .= $CI->db->where_not_in('pos_id', 1);
//         case $i['position_name'] = 2:
//             $data['position_name'] .= $CI->db->where_not_in('pos_id', 2);
//         case $i['position_name'] = 3:
//             $data['position_name'] .= $CI->db->where_not_in('pos_id', 3);
//         case $i['position_name'] = 4:
//             $data['position_name'] .= $CI->db->where_not_in('pos_id', 4);

//         default:
//             $CI->db->select('*');
//             $CI->db->from('position');
//             $data['position_name'] = $CI->db->get();
//             return $data;
//     }
// }
