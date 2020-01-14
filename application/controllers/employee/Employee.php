<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'recaptcha', 'email']);
        $this->load->model(['employee_model', 'position_model', 'usertoken_model']);
    }

    public function index()
    {
        $data['pos_name'] = $this->position_model->getData();
        $data['title'] = 'Data Pegawai';
        $this->template->loadadmin('employee/employee', $data);
    }

    // Add a new item
    public function add()
    {
        $this->_validate();
        $pass = get_random_password(6, 8, true, true, false);
        //Create Token
        $email = $this->input->post('email', true);
        $token = base64_encode(random_bytes(32));
        $user_token = [
            'email' => $email,
            'token' => $token,
            'user' => 'employee',
            'action' => 'registration',
            'date_created' => time()
        ];
        //base64_encode untuk menterjemahkan random_bytes agar dikenali oleh MySQL
        $this->employee_model->add($pass);
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
        $data = $this->employee_model->getDataBy($id, 'emp_id')->row();
        $data->level_name = level($data->level);
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
        $this->employee_model->update($data);
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
        $check = $this->employee_model->getDataBy($id, 'emp_id')->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        $data['pass'] = get_random_password(6, 8, true, true, false);
        $data['email'] = $check->email;
        //Create Token
        $this->employee_model->changepass($data);
        //=========== Send Email ===========
        $this->_sendEmail($data['email'], $data['pass'], 'forgot');
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

        $csidn = $this->input->post('csidn');
        $email = $this->input->post('email');
        if ($email == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($method !== 'edit') {

            $cekemail = $this->employee_model->getDataBy($email, 'email')->num_rows();
            if ($cekemail > 0) {
                $data['inputerror'][] = 'email';
                $data['error_string'][] = 'Email sudah terdaftar.';
                $data['status'] = FALSE;
            }
            $cekcsidn = $this->employee_model->getDataBy($csidn, 'csidn')->num_rows();
            if ($cekcsidn > 0) {
                $data['inputerror'][] = 'csidn';
                $data['error_string'][] = 'No. Identitas Pegawai (NIP) sudah terdaftar.';
                $data['status'] = FALSE;
            }

            if ($csidn == '') {
                $data['inputerror'][] = 'csidn';
                $data['error_string'][] = 'No. Identitas Pegawai (NIP) tidak boleh kosong.';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('position_name') == '') {
            $data['inputerror'][] = 'position_name';
            $data['error_string'][] = 'Silakan pilih Jabatan';
            $data['status'] = FALSE;
        }

        if ($this->input->post('address') == '') {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Alamat tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Silakan pilih Level';
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
        $check = $this->employee_model->getDataBy($id, 'emp_id')->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $emp = $this->employee_model->getDataBy($id, 'emp_id')->row();

        if ($emp->photo != 'default.jpg')
            unlink(FCPATH . 'assets/img/profil/' . $emp->photo);

        $this->employee_model->delete($id, 'emp_id');
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
        $list = $this->employee_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $emp) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $emp->csidn;
            $row[] = $emp->fullname;
            $row[] = $emp->pos_name;
            $row[] = level($emp->level);
            $row[] = date('d-m-Y H:i:s', strtotime($emp->date_update));

            $row[] = '
            <a title="Lihat Data" class="btn btn-info btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="view_emp(' . "'" . $emp->emp_id . "'" . ')"><i class="fas fa-search-plus"></i></a>

            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_emp(' . "'" . $emp->emp_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_emp(' . "'" . $emp->emp_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee_model->count_all(),
            "recordsFiltered" => $this->employee_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function _sendEmail($token = NULL, $pass, $type)
    {
        $email = $this->input->post('email', true);
        if ($type == 'verify') {
            $subject = 'SIPJAMET - Verifikasi Akun ';
            $message = '
            <h3 align="center" style="font-family: arial, sans-serif;">Akun Pegawai Sipjamet</h3>
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
            Klik tautan ini untuk memverifikasi akun Anda : <a href="' . site_url() . '' . UE_VERIFY . '?email=' . $email . '&token=' . urlencode($token) . '">Aktifkan Akun</a>
            </p>';
            sendMail($email, $subject, $message);
            //base64_encode karakter tidak ramah url ada karakter tambah dan sama dengan nah ketika di urlnya ada karakter itu nanti akan di terjemahkan spasi jadi kosong. untuk menghindari hal sprti itu maka kita bungkus urlencode jadi jika ada karakter tadi maka akan di rubah jadi %20 dan strusnya. 
        } elseif ($type == 'forgot') {
            $subject = 'SIPJAMET - Atur Ulang Kata Sandi';
            $message = '
            <h3 align="center" style="font-family: arial, sans-serif;">Akun Pegawai Sipjamet</h3>
            <table border="1" width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">
            <tr>
                <th width="20%" style="padding: 8px;">Email</th>
                <td width="80%" style="padding: 8px;">' . $token . '</td>
            </tr>
            <tr>
                <th width="20%" style="padding: 8px;">Password</th>
                <td width="80%" style="padding: 8px;">' . $pass . '</td>
            </tr>
            </table>
            <p>
            Klik tautan ini untuk masuk akun Anda : <a href="' . site_url(UE_LOGIN) . '">Login Akun</a>
            </p>';
            sendMail($token, $subject, $message);
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

        $user = $this->employee_model->checkData(['email' => $email])->row_array();
        $user_token = $this->usertoken_model->getToken($token);

        if ($user) {
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->employee_model->updateActivation($email);
                    $this->usertoken_model->delByEmail($email, "employee", "registration");
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Selamat! </strong>' . $email . ' telah diaktifkan. Silahkan login.</div>');
                    redirect(UE_LOGIN);
                } else {
                    $this->employee_model->delete($email, "email");
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

/* End of file Employee.php */
