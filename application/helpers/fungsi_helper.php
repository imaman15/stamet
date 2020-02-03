<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function secho($str)
{
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function dAdmin()
{
    $CI = &get_instance();
    $CI->load->model('employee_model');
    $id = $CI->session->userdata('emp_id');
    return $CI->employee_model->getDataBy($id, 'emp_id')->row();
}

function dUser()
{
    $CI = &get_instance();
    $CI->load->model('applicant_model');
    $id = $CI->session->userdata('applicant_id');
    return $CI->applicant_model->getDataBy($id, 'applicant_id')->row();
}

function app_already_login($method = NULL)
{
    $CI = &get_instance();
    if ($method == "admin") {
        $user_session = $CI->session->userdata('emp_id');
        $logged_in = $CI->session->userdata('logged_in');

        if ($user_session && $logged_in == "admin") {
            redirect(site_url(UE_ADMIN));
        }
    } else {
        $user_session = $CI->session->userdata('applicant_id');
        $logged_in = $CI->session->userdata('logged_in');

        if ($user_session && $logged_in == "user") {
            redirect(site_url());
        }
    }
}

function app_not_login()
{
    $CI = &get_instance();
    $user_session = $CI->session->userdata('applicant_id');
    $user_session2 = $CI->session->userdata('emp_id');
    $logged_in = $CI->session->userdata('logged_in');
    $user_db = $CI->db->get_where('applicant', ['applicant_id' => $user_session])->row();
    if (!isset($user_session) || $logged_in !== "user") {
        redirect(UA_LOGIN);
    } elseif (isset($user_session2) && $logged_in == "user") {
        $CI->session->unset_userdata('emp_id');
        redirect(site_url());
    } elseif (isset($user_session2) && $logged_in == "admin") {
        $CI->session->unset_userdata('applicant_id');
        redirect(site_url(UE_ADMIN));
    } elseif (!$user_db) {
        $CI->session->unset_userdata('applicant_id');
        $CI->session->unset_userdata('logged_in');
        $CI->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Anda telah keluar! </div>');
        redirect(UA_LOGIN);
    }
}

function admin_not_login($level = array())
{
    $CI = &get_instance();
    $user_session = $CI->session->userdata('emp_id');
    $user_session2 = $CI->session->userdata('applicant_id');
    $logged_in = $CI->session->userdata('logged_in');
    $user_db = $CI->db->get_where('employee', ['emp_id' => $user_session])->row();
    if (!isset($user_session) || $logged_in !== "admin") {
        redirect(UE_LOGIN);
    } elseif (isset($user_session2) && $logged_in == "user") {
        $CI->session->unset_userdata('emp_id');
        redirect(site_url());
    } elseif (isset($user_session2) && $logged_in == "admin") {
        $CI->session->unset_userdata('applicant_id');
        redirect(site_url(UE_ADMIN));
    } elseif (!$user_db) {
        $CI->session->unset_userdata('emp_id');
        $CI->session->unset_userdata('logged_in');
        $CI->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Anda telah keluar! </div>');
        redirect(UE_LOGIN);
    } else {
        if (in_array($user_db->level, $level)) {
            // redirect('/404_override');
            show_404();
        }
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
        return "Petugas CS";
    } elseif ($data == 3) {
        return "Petugas Layanan";
    }
}

function dataLevel($level = NULL)
{
    $level1 = ($level == 1) ? "selected" : null;
    $level2 = ($level == 2) ? "selected" : null;
    $level3 = ($level == 3) ? "selected" : null;
    $data = '<option value="1" ' . $level1 . '>Administrator</option>';
    $data .= '<option value="2" ' . $level2 . '>Petugas CS</option>';
    $data .= '<option value="3" ' . $level3 . '>Petugas Layanan</option>';
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

function DateTime($string)
{
    // contoh : 2019-01-30 10:20:20

    $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $date = explode(" ", $string)[0];
    $time = explode(" ", $string)[1];

    $tanggal = explode("-", $date)[2];
    $bulan = explode("-", $date)[1];
    $tahun = explode("-", $date)[0];



    return $tanggal . " " . $bulanIndo[abs($bulan)] . " " . $tahun . " " . $time;
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

// Function Keterangan Waktu
function timeInfo($timestamp)
{
    $selisih = time() - strtotime($timestamp);
    $detik = $selisih;
    $menit = round($selisih / 60);
    $jam = round($selisih / 3600);
    $hari = round($selisih / 86400);
    $minggu = round($selisih / 604800);
    $bulan = round($selisih / 2419200);
    $tahun = round($selisih / 29030400);

    if ($detik <= 60) {
        $waktu = $detik . ' detik yang lalu';
    } else if ($menit <= 60) {
        $waktu = $menit . ' menit yang lalu';
    } else if ($jam <= 24) {
        $waktu = $jam . ' jam yang lalu';
    } else if ($hari <= 7) {
        $waktu = $hari . ' hari yang lalu';
    } else if ($minggu <= 4) {
        $waktu = $minggu . ' minggu yang lalu';
    } else if ($bulan <= 12) {
        $waktu = $bulan . ' bulan yang lalu';
    } else {
        $waktu = $tahun . ' tahun yang lalu';
    }

    return $waktu;
}


//Upload image summernote
function upload_image()
{

    $CI = &get_instance();
    if (isset($_FILES["image"]["name"])) {
        $config['upload_path'] = './assets/img-sn/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload('image')) {
            $CI->upload->display_errors();
            return FALSE;
        } else {
            $data = $CI->upload->data();
            //Compress Image
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/img-sn/' . $data['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '80%';
            $config['width'] = 2000;
            $config['height'] = 2000;
            $config['new_image'] = './assets/img-sn/' . $data['file_name'];
            $CI->load->library('image_lib', $config);
            $CI->image_lib->resize();
            echo base_url() . 'assets/img-sn/' . $data['file_name'];
        }
    }
}

//Delete image summernote
function delete_image()
{
    $CI = &get_instance();
    $src = $CI->input->post('src');
    $file_name = str_replace(base_url(), '', $src);
    if (unlink($file_name)) {
        echo 'File Delete Successfully';
    }
}

//Pembuatan Kode Transaksi/Jadwal/Komplain
function codeRandom($initial = NULL)
{
    $CI = &get_instance();
    $CI->load->helper('string');

    if ($initial == "TC") {
        $code = "TC";
    } else if ($initial == "SC") {
        $code = "SC";
    } else if ($initial == "CO") {
        $code = "CT";
    } else {
        $code = "SM";
    }
    return $code . date('dmy') . strtoupper(random_string('alnum', 8));
}


function statusTrans($data = NULL, $for = NULL, $array = NULL)
{
    if ($for == "transaction") {
        if ($data == 0) {
            return '<span class="badge badge-pill badge-light">Cek Ketersediaan Data</span>';
        } elseif ($data == 1) {
            return '<span class="badge badge-pill badge-info">Tersedia</span>';
        } elseif ($data == 2) {
            return '<span class="badge badge-pill badge-warning">Lengkapi Persyaratan</span>';
        } elseif ($data == 3) {
            return '<span class="badge badge-pill badge-primary">Proses</span>';
        } elseif ($data == 4) {
            return '<span class="badge badge-pill badge-success">Selesai</span>';
        } elseif ($data == 5) {
            return '<span class="badge badge-pill badge-danger">Dibatalkan</span>';
        } elseif ($data == 6) {
            return '<span class="badge badge-pill badge-danger">Data Tidak Tersedia</span>';
        } else {
            return "---";
        }
    } elseif ($for == "pay") {
        if ($data == NULL) {
            return '<span class="small">Belum Dikonfirmasi</span>';
        } elseif ($data == 0) {
            return 'Non Tarif';
        } elseif ($data == 1) {
            return '<span class="small">Tarif : ' . rupiah($array['trans_sum']) . '</span>
            <hr class="my-0">
            <a id="btn-payment" href="javascript:void(0)" onclick="confirm(' . "'" . $array['trans_code'] . "'" . ')" class="badge badge-secondary p-1 m-1">Konfirmasi Bayar</a>';
        } elseif ($data == 2) {
            return '<span class="small">Menunggu Konfirmasi Pembayaran</span>
            <hr class="my-0">
            <a id="btn-payment" href="javascript:void(0)" onclick="received(' . "'" . $array['trans_code'] . "'" . ')" class="badge badge-secondary p-1 m-1">Lihat Pembayaran</a>';
        } elseif ($data == 3) {
            return '<span class="small">Pembayaran Diterima</span>
            <hr class="my-0">
            <a id="btn-payment" href="javascript:void(0)" onclick="received(' . "'" . $array['trans_code'] . "'" . ')" class="badge badge-secondary p-1 m-1">Lihat Pembayaran</a>';
        } elseif ($data == 4) {
            return '<span class="small">Pembayaran Tidak Sesuai</span>
            <hr class="my-0">
            <a id="btn-payment" href="javascript:void(0)" onclick="confirm(' . "'" . $array['trans_code'] . "'" . ')" class="badge badge-secondary p-1 m-1">Ganti Pembayaran</a>';
        } elseif ($data == 5) {
            return '-';
        } else {
            return "---";
        }
    } else {
        return "---";
    }
}

function payStatus($data = NULL)
{
    if ($data == NULL) {
        return '<span class="small">Belum Dikonfirmasi</span>';
    } elseif ($data == 0) {
        return 'Non Tarif';
    } elseif ($data == 1) {
        return '<span class="small">Tarif - Menunggu Pembayaran</span>';
    } elseif ($data == 2) {
        return '<span class="small">Sudah Bayar</span>';
    } elseif ($data == 3) {
        return '<span class="small">Pembayaran Diterima</span>';
    } elseif ($data == 4) {
        return '<span class="small">Pembayaran Tidak Sesuai</span>';
    } elseif ($data == 5) {
        return '-';
    } else {
        return "---";
    }
}

function statusSch($data = NULL, $for = NULL, $array = NULL)
{
    if ($for == "applicant") {
        if ($data == 0) {
            if (isset($array['beranda'])) {
                return '<span class="small">Konfirmasi Jadwal</span>';
            } else {
                return '<span class="small">Konfirmasi Jadwal</span>
                <hr class="my-0">
                <a id="btn-payment" href="javascript:void(0)" onclick="cancel(' . "'" . $array['sch_code'] . "'" . ')" class="badge badge-danger p-1 m-1">Batalkan</a>';
            }
        } elseif ($data == 1) {
            if (isset($array['beranda'])) {
                return '<span class="small">Jadwal Disetujui</span>';
            } else {
                return '<span class="small">Jadwal Disetujui</span>
                <hr class="my-0">
                <a id="btn-payment" href="javascript:void(0)" onclick="cancel(' . "'" . $array['sch_code'] . "'" . ')" class="badge badge-danger p-1 m-1">Batalkan</a>';
            }
        } elseif ($data == 2) {
            return '<span class="small">Berlangsung</span>';
        } elseif ($data == 3) {
            return '<span class="small">Selesai</span>';
        } elseif ($data == 4) {
            return '<span class="small">Dibatalkan</span>';
        } else {
            return "---";
        }
    } else {
        if ($data == 0) {
            if (isset($array['beranda'])) {
                return '<span class="small">Konfirmasi Jadwal</span>';
            } else {
                return '<span class="small">Konfirmasi Jadwal</span>';
            }
        } elseif ($data == 1) {
            if (isset($array['beranda'])) {
                return '<span class="small">Jadwal Disetujui</span>';
            } else {
                return '<span class="small">Jadwal Disetujui</span>';
            }
        } elseif ($data == 2) {
            return '<span class="small">Berlangsung</span>';
        } elseif ($data == 3) {
            return '<span class="small">Selesai</span>';
        } elseif ($data == 4) {
            return '<span class="small">Dibatalkan</span>';
        } else {
            return "---";
        }
    }
}

function PdfGenerator($html, $filename, $paper, $orientation)
{
    // instantiate and use the dompdf class
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper($paper, $orientation);

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream($filename, array('Attachment' => 0));
}

function sResults()
{
    $CI = &get_instance();
    $data = $CI->answer_model->total()->row();
    $sum = $data->A + $data->B + $data->C + $data->D + $data->E;
    $pa = ROUND(($data->A / $sum) * 100);
    $pb = ROUND(($data->B / $sum) * 100);
    $pc = ROUND(($data->C / $sum) * 100);
    $pd = ROUND(($data->D / $sum) * 100);
    $pe = ROUND(($data->E / $sum) * 100);
    $result['alpha'] = [
        ['Sangat Baik', '(A)'],
        ['Baik', '(B)'],
        ['Cukup', '(C)'],
        ['Buruk', '(D)'],
        ['Sangat Buruk', '(E)']
    ];
    $result['number'] = [
        "A" => $data->A,
        "B" => $data->B,
        "C" => $data->C,
        "D" => $data->D,
        "E" => $data->E
    ];
    $result['persen'] = [
        "A" => $pa,
        "B" => $pb,
        "C" => $pc,
        "D" => $pd,
        "E" => $pe
    ];
    return $result;
}
