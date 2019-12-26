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
