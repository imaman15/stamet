<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'email']);
        $this->load->model(['applicant_model', 'jobcategory_model', 'usertoken_model']);
    }

    public function index()
    {
        $data['jobcat'] = $this->jobcategory_model->getData();
        $data['title'] = 'Data Pengguna';
        $this->template->loadadmin('employee/applicant', $data);
    }

    // Add a new item
    public function add()
    {
        $this->_validate();
        $post = $this->input->post(NULL, TRUE);
        $pass = get_random_password(6, 8, true, true, false);
        //Create Token
        $email = $post["email"];
        $token = base64_encode(random_bytes(32));
        $user_token = [
            'email' => $email,
            'token' => $token,
            'user' => 'applicant',
            'action' => 'registration',
            'date_created' => time()
        ];
        //base64_encode untuk menterjemahkan random_bytes agar dikenali oleh MySQL
        $this->applicant_model->add($post, $pass);
        $this->usertoken_model->add($user_token);

        //=========== Send Email ===========
        $this->_sendEmail($token, $pass, 'verify');
        //=========== End Of Send Email ===========
        echo json_encode(array("status" => TRUE));

        // Koneksi ke Pusher.com agar menjadi relatime
        // require_once(APPPATH . 'views/vendor/autoload.php');
        // $options = array(
        //     'cluster' => 'ap1',
        //     'useTLS' => true
        // );
        // $pusher = new Pusher\Pusher(
        //     'a96aa6ae29173426fb71',
        //     'a711eb79b8901c8563cf',
        //     '928472',
        //     $options
        // );

        // $data['message'] = 'success';
        // $pusher->trigger('my-channel', 'my-event', $data);
        // ===============================================
    }

    public function view($id = NULL)
    {
        $data = $this->applicant_model->getDataBy($id, 'applicant_id')->row();
        $data->is_active = ($data->is_active == 1) ? "Aktif" : "Tidak Aktif";
        $data->date_created = timeIDN(date('Y-m-d', $data->date_created));
        $data->date_update = date('d-m-Y H:i:s', strtotime($data->date_update));
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate('edit');
        $data = $this->input->post(null, TRUE);
        $this->applicant_model->update($data);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));

        // Koneksi ke Pusher.com agar menjadi relatime
        // require_once(APPPATH . 'views/vendor/autoload.php');
        // $options = array(
        //     'cluster' => 'ap1',
        //     'useTLS' => true
        // );
        // $pusher = new Pusher\Pusher(
        //     'a96aa6ae29173426fb71',
        //     'a711eb79b8901c8563cf',
        //     '928472',
        //     $options
        // );

        // $data['message'] = 'success';
        // $pusher->trigger('my-channel', 'my-event', $data);
        // ===============================================
    }

    public function resetpassword($id = NULL)
    {
        $check = $this->applicant_model->getDataBy($id, 'applicant_id')->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));

        $cekdata = $this->usertoken_model->readToken($check->email, 'applicant', 'resetpassword')->num_rows();

        if ($cekdata > 0) {
            $this->usertoken_model->delByEmail($check->email, "applicant", "resetpassword");
        }
        //Create Token
        $token = base64_encode(random_bytes(32));
        $user_token = [
            'email' => $check->email,
            'token' => $token,
            'user' => 'applicant',
            'action' => 'resetpassword',
            'date_created' => time()
        ];
        $this->usertoken_model->add($user_token);

        $this->applicant_model->resetpassword($check->email);
        //=========== Send Email ===========
        $this->_sendEmail($token, $check->email, 'forgot');
        //=========== End Of Send Email ===========
        echo json_encode(array("status" => TRUE));
    }

    private function _validate($method = NULL)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('first_name') == '') {
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'Nama Depan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        $nin = $this->input->post('nin');
        $email = $this->input->post('email');
        if ($email == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($method !== 'edit') {

            $cekemail = $this->applicant_model->getDataBy($email, 'email')->num_rows();
            if ($cekemail > 0) {
                $data['inputerror'][] = 'email';
                $data['error_string'][] = 'Email sudah terdaftar.';
                $data['status'] = FALSE;
            }
            $ceknin = $this->applicant_model->getDataBy($nin, 'nin')->num_rows();
            if ($ceknin > 0) {
                $data['inputerror'][] = 'nin';
                $data['error_string'][] = 'Nomor Identitas (KTP) sudah terdaftar.';
                $data['status'] = FALSE;
            }

            if ($nin == '') {
                $data['inputerror'][] = 'nin';
                $data['error_string'][] = 'Nomor Identitas (KTP)) tidak boleh kosong.';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('job_category') == '') {
            $data['inputerror'][] = 'job_category';
            $data['error_string'][] = 'Silakan pilih Kategori Pekerjaan';
            $data['status'] = FALSE;
        }

        if ($this->input->post('address') == '') {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Alamat tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('institute') == '') {
            $data['inputerror'][] = 'institute';
            $data['error_string'][] = 'Nama Instansi tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('phone') == '') {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Nomor Handphone tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $check = $this->applicant_model->getDataBy($id, 'applicant_id')->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $applicant = $this->applicant_model->getDataBy($id, 'applicant_id')->row();

        if ($applicant->photo != 'default.jpg')
            unlink(FCPATH . 'assets/img/profil/' . $applicant->photo);

        $this->applicant_model->delete($id, 'applicant_id');
        echo json_encode(array("status" => TRUE));

        // Koneksi ke Pusher.com agar menjadi relatime
        // require_once(APPPATH . 'views/vendor/autoload.php');
        // $options = array(
        //     'cluster' => 'ap1',
        //     'useTLS' => true
        // );
        // $pusher = new Pusher\Pusher(
        //     'a96aa6ae29173426fb71',
        //     'a711eb79b8901c8563cf',
        //     '928472',
        //     $options
        // );

        // $data['message'] = 'success';
        // $pusher->trigger('my-channel', 'my-event', $data);
        // ===============================================
    }

    public function list()
    {
        $list = $this->applicant_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $applicant) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $applicant->nin;
            $row[] = htmlentities($applicant->fullname, ENT_QUOTES, 'UTF-8');
            $row[] = $applicant->email;
            $row[] = date('d-m-Y H:i:s', strtotime($applicant->date_update));

            $row[] = '
            <a title="Lihat Data" class="btn btn-info btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="view_applicant(' . "'" . $applicant->applicant_id . "'" . ')"><i class="fas fa-search-plus"></i></a>

            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_applicant(' . "'" . $applicant->applicant_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_applicant(' . "'" . $applicant->applicant_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->applicant_model->count_all(),
            "recordsFiltered" => $this->applicant_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function _sendEmail($token = NULL, $pass = NULL, $type)
    {
        $email = $this->input->post('email', true);
        if ($type == 'verify') {
            $subject = 'SIPJAMET - Verifikasi Akun ';
            $message = '
            <h3 align="center" style="font-family: arial, sans-serif;">Akun Sipjamet</h3>
            <table border="1" width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">
            <tr>
                <th width="20%" style="padding: 8px;">Email</th>
                <td width="80%" style="padding: 8px;">' . $email . '</td>
            </tr>
            <tr>
                <th width="20%" style="padding: 8px;">Password</th>
                <td width="80%" style="padding: 8px;">' . $pass . '</td>
            </tr>
            </table>
            <p>
            Klik tautan ini untuk memverifikasi akun Anda : <a href="' . site_url() . '' . UA_VERIFY . '?email=' . $email . '&token=' . urlencode($token) . '">Aktifkan Akun</a>
            </p>';
            sendMail($email, $subject, $message);
            //base64_encode karakter tidak ramah url ada karakter tambah dan sama dengan nah ketika di urlnya ada karakter itu nanti akan di terjemahkan spasi jadi kosong. untuk menghindari hal sprti itu maka kita bungkus urlencode jadi jika ada karakter tadi maka akan di rubah jadi %20 dan strusnya. 
        } elseif ($type == 'forgot') {
            $subject = 'SIPJAMET - Atur Ulang Kata Sandi';
            $message = 'klik tautan ini untuk mengatur ulang kata sandi Anda : <a href="' . site_url() . '' . UA_RESETPASSWORD . '?email=' . $pass . '&token=' . urlencode($token) . '">Atur Ulang Kata Sandi</a>';
            sendMail($pass, $subject, $message);
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

        $user = $this->applicant_model->checkData(['email' => $email])->row_array();
        $user_token = $this->usertoken_model->getToken($token);

        if ($user) {
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->applicant_model->updateActivation($email);
                    $this->usertoken_model->delByEmail($email, "employee", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Selamat! </strong>' . $email . ' telah diaktifkan. Silahkan login.</div>');
                    redirect(UE_LOGIN);
                } else {
                    $this->applicant_model->delete($email, "email");
                    $this->usertoken_model->delByEmail($email, "employee", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda kedaluwarsa. Silahkan hubungi Admin.</div>');
                    redirect(UE_LOGIN);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong>Maaf!</strong> Aktivasi akun gagal. Token Anda tidak valid.</div>');
                redirect(UE_LOGIN);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            <strong>Maaf!</strong> Aktivasi akun gagal. Email Anda salah.</div>');
            redirect(UE_LOGIN);
        }
    }
}

/* End of file Applicant.php */
