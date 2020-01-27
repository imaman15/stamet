<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['schedule_model', 'employee_model', 'applicant_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['user'] = dUser();
        $data['title'] = 'Riwayat Jadwal Pertemuan';
        $this->template->load('schedule/list', $data);
    }

    //List
    public function list()
    {
        $list = $this->schedule_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $d->sch_code;
            $row[] = $d->sch_type;
            $row[] = DateTime($d->sch_date);
            $row[] = ($d->responsible_person) ? $d->responsible_person : "-";
            $array = ['sch_code' => $d->sch_code];
            $row[] = statusSch($d->sch_status, 'applicant', $array);


            if ($d->sch_reply) {
                // redirect('/404_override');
                $btn = '<a title="Balasan Pesan Anda" class="btn btn-secondary btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="reply(' . "'" . $d->sch_code . "'" . ')"><i class="fas fa-reply"></i></a>';
            } else {
                $btn = '';
            }

            $row[] = '
             <a title="Pesan Anda" class="btn btn-dark btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="message(' . "'" . $d->sch_code . "'" . ')"><i class="fas fa-envelope"></i></a>' . $btn;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->schedule_model->count_all(),
            "recordsFiltered" => $this->schedule_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        if ($this->form_validation->run('schadd') == FALSE) {
            $data['user'] = dUser();
            $data['title'] = 'Form Jadwal Pertemuan';
            $this->template->load('schedule/add', $data);
        } else {
            $this->schedule_model->add();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat!</strong> Formulir permintaan data Anda berhasil di kirim. Cek Riwayat Jadwal Permintaan secara berkala.</div>');
                redirect(UA_SCHEHISTORY);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Formulir Jadwal Pertemuan Anda gagal di kirim. Silahkan coba kembali</div>');
                redirect(UA_SCHEDULE);
            }
        }
    }

    public function schMessage($id = NULL)
    {
        $user = $this->session->userdata('applicant_id');
        $where = ['sch_code' => $id, 'applicant_id' => $user];
        $data = $this->schedule_model->getField(NULL, $where)->row();

        $employee = $this->employee_model->getDataBy($data->emp_id, 'emp_id')->row();
        $applicant = $this->applicant_model->getDataBy($data->applicant_id, 'applicant_id')->row();

        if ((!isset($id)) || (!$data) || ($data->applicant_id !== $user)) {
            redirect(show_404());
        };

        if ($data && $data->applicant_id == $user) {
            $sch = new stdClass();
            $sch->sch_type = $data->sch_type;
            $sch->sch_title = $data->sch_title;
            $sch->date_update = timeInfo($data->date_update);
            $sch->date_created = timeIDN(date('Y-m-d', strtotime($data->date_created)), true);
            if ($data->emp_id) {
                $sch->employee = $employee->first_name . ' ' . $employee->last_name . ' - ' . $employee->pos_name;
                $sch->sch_reply = $data->sch_reply;
            }
            $sch->applicant = $applicant->first_name . ' ' . $applicant->last_name;
            $sch->sch_message = $data->sch_message;
            $sch->status = true;
            echo json_encode($sch);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function cancel($id)
    {
        $this->schedule_model->cancel($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }

    //Update one item
    public function update($id = NULL)
    {
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }



    //Upload image summernote
    public function upload_image()
    {
        upload_image();
    }

    public function delete_image()
    {
        delete_image();
    }
}

/* End of file Schedule.php */
