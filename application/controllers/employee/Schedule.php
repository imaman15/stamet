<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['schedule_model', 'employee_model', 'applicant_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Jadwal Pertemuan';
        $this->template->loadadmin(UE_FOLDER . '/schedule', $data);
    }

    //List
    public function list()
    {
        $list = $this->schedule_model->get_datatables("employ");
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $schedule = '<b>' . $d->sch_code . '</b><hr class="my-0">' . timeIDN(date('Y-m-d'), strtotime($d->date_created)) . '<hr class="my-0"> Terakhir diperbarui : <br>' . timeInfo($d->date_update);
            $row[] = $schedule;
            $row[] = $d->sch_type . '<hr class="my-0"> <b>Perihal</b> : <br>' . $d->sch_title . '<hr class="my-0"> <b>Waktu Pertemuan</b> : <br>' . DateTime($d->sch_date);

            $apply = $d->name_apply . '<hr class="my-0">' . $d->email_apply . '<hr class="my-0">' . $d->phone_apply . '<hr class="my-0"><a class="btn btn-dark btn-icon-split btn-sm mt-1" href="javascript:void(0)" onclick="message(' . "'" . $d->sch_code . "'" . ')"><span class="icon text-white-50"><i class="fas fa-envelope"></i></span><span class="text">Lihat Pesan</span></a>';
            $row[] = $apply;

            $user = $this->session->userdata('emp_id');

            if ($d->sch_status == 0) {
                $sentmes = '-';
            } else {
                $sentmes = '<a class="btn btn-primary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="update(' . "'" . $d->sch_code . "'" . ')"><span class="text">Kirim Pesan</span></a>';
            }
            if ($d->emp_id) {
                if ($d->sch_reply) {
                    if ($d->emp_id == $user) {
                        $changemes = '<a class="btn btn-primary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="update(' . "'" . $d->sch_code . "'" . ')"><span class="text">Ganti Pesan</span></a>';
                    } else {
                        $changemes = '';
                    }

                    $emp = $d->responsible_person . '<hr class="my-0">' . $changemes . ' <a class="btn btn-secondary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="reply(' . "'" . $d->sch_code . "'" . ')"><span class="icon text-white-50"><i class="fas fa-reply"></i></span><span class="text">Lihat Pesan</span></a>';
                } else {
                    $emp = $d->responsible_person . '<hr class="my-0">' . $sentmes;
                }
            } else {
                $emp = $sentmes;
            }

            $row[] = $emp;

            if ($d->sch_status == 4) {
                $changeStat = '';
            } else if ($d->sch_status == 0) {
                $changeStat = '<hr class="my-0"><a href="javascript:void(0)" onclick="confirm(' . "'" . $d->sch_code . "'" . ')" class="badge badge-info p-1 m-1">Konfirmasi</a>';
            } else {
                if ($d->emp_id == $user && in_array($d->sch_status, [1, 2])) {
                    $changeStat = '<hr class="my-0"><a href="javascript:void(0)" onclick="status(' . "'" . $d->sch_code . "'" . ')" class="badge badge-info p-1 m-1">Ganti Status</a>';
                } else {
                    $changeStat = '';
                }
            }

            $row[] = statusSch($d->sch_status, NULL, ["sch_code" => $d->sch_code]) . $changeStat;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->schedule_model->count_all(),
            "recordsFiltered" => $this->schedule_model->count_filtered("employ"),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function message($id = NULL)
    {
        $where = ['sch_code' => $id];
        $data = $this->schedule_model->getField(NULL, $where)->row();

        $employee = $this->employee_model->getDataBy($data->emp_id, 'emp_id')->row();

        if ((!isset($id)) || (!$data)) {
            redirect(show_404());
        };

        if ($data) {
            $sch = new stdClass();
            $sch->sch_message = $data->sch_message;
            $sch->sch_reply = $data->sch_reply;
            if ($data->emp_id) {
                $sch->employee = $employee->first_name . ' ' . $employee->last_name . ' - ' . $employee->pos_name;
            }

            $sch->status = true;
            echo json_encode($sch);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    // Add a new item
    public function add()
    {
    }

    //Update one item
    public function update($id = NULL)
    {
        $where = ['sch_code' => $id];
        $sch = $this->schedule_model->getField('sch_code,sch_reply,emp_id', $where)->row();
        $user = $this->session->userdata('emp_id');

        if ($this->form_validation->run('schemp') == FALSE) {
            if ($sch->sch_reply && $user == $sch->emp_id) {
                $data['sch'] = $sch->sch_reply;
                $data['title'] = 'Edit Pesan';
                $mess = 'diedit';
            } else {
                $data['title'] = 'Tambah Pesan';
                $mess = 'ditambahkan';
            }
            $data['id'] = $id;

            $this->template->loadadmin(UE_FOLDER . '/messchedule', $data);
        } else {
            $this->schedule_model->update($id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert">Pesan berhasil ' . $mess . '.</div>');
                redirect(UE_SCHEDULE);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Pesan gagal ' . $mess . '</div>');
                redirect(UE_SCHEDULE . '/'  . 'pesan/' . $id);
            }
        }
    }

    public function confirm($id)
    {
        $this->schedule_model->confirm($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }
    public function status($id)
    {
        $this->schedule_model->status($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Schedule.php */
