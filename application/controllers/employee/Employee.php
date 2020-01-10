<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
        $this->load->model(['employee_model', 'position_model']);
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
        $data = $this->input->post(null, TRUE);
        $this->employee_model->add($data);
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
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    public function update($id = NULL)
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

    // get position
    function get_position()
    {
        $category_id = $this->input->post('id', TRUE);
        $data = $this->product_model->get_sub_category($category_id)->result();
        echo json_encode($data);
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
}

/* End of file Employee.php */
