<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Complaint extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();

        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['complaint_model', 'employee_model', 'applicant_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['user'] = dUser();
        $data['title'] = 'Komplain Pelanggan';
        $this->template->load('user/complaint', $data);
    }

    // Add a new item
    public function add()
    {
        if ($this->form_validation->run('compadd')) {
            $this->complaint_model->add();
            if ($this->db->affected_rows()) {
                $array = array(
                    'success' => '<div class="alert alert-success" role="alert"><strong>Selamat! </strong>pesan Anda sudah terkirim. Untuk melihat status/balasan komplain silahakn klik menu "Riwayat Komplain"</div>'
                );
            } else {
                $array = array(
                    'danger' => '<div class="alert alert-danger" role="alert"><strong>Maaf! </strong>pesan Anda gagal dikirim.</div>'
                );
            };
        } else {
            $array = array(
                'error'   => true,
                'title_error' => form_error('comp_title'),
                'message_error' => form_error('comp_message')
            );
        }

        echo json_encode($array);
    }

    //List
    public function list()
    {
        $list = $this->complaint_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $d->comp_code;
            $row[] = DateTime($d->date_created);
            $row[] = $d->comp_title;

            if ($d->reply_message) {
                // redirect('/404_override');
                $btn = '<a title="Balasan Pesan Anda" class="btn btn-secondary btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="reply(' . "'" . $d->comp_code . "'" . ')"><i class="fas fa-reply"></i></a>';
            } else {
                $btn = '';
            };

            $row[] = '
              <a title="Pesan Anda" class="btn btn-dark btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="message(' . "'" . $d->comp_code . "'" . ')"><i class="fas fa-envelope"></i></a>' . $btn;

            $row[] = ucfirst($d->status);
            $row[] = timeInfo($d->date_update);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->complaint_model->count_all(),
            "recordsFiltered" => $this->complaint_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function message($id = NULL)
    {
        $user = $this->session->userdata('applicant_id');
        $where = ['comp_code' => $id, 'applicant_id' => $user];
        $data = $this->complaint_model->getField(NULL, $where)->row();

        $employee = $this->employee_model->getDataBy($data->emp_id, 'emp_id')->row();
        // $applicant = $this->applicant_model->getDataBy($data->applicant_id, 'applicant_id')->row();

        if ((!isset($id)) || (!$data) || ($data->applicant_id !== $user)) {
            redirect(show_404());
        };

        if ($data && $data->applicant_id == $user) {
            $comp = new stdClass();
            $comp->comp_message = $data->comp_message;
            $comp->reply_message = $data->reply_message;
            if ($data->emp_id) {
                $comp->employee = $employee->first_name . ' ' . $employee->last_name . ' - ' . $employee->pos_name;
            }

            $comp->status = true;
            echo json_encode($comp);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    //Update one item
    public function update($id = NULL)
    {
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }

    public function upload_image()
    {
        upload_image();
    }

    public function delete_image()
    {
        delete_image();
    }
}

/* End of file Complaint.php */
