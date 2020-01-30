<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Complaint extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([3]);
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['complaint_model', 'employee_model', 'applicant_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Komplain';
        $this->template->loadadmin(UE_FOLDER . '/complaint', $data);
    }

    //Update one item
    public function update($id = NULL)
    {
        $where = ['comp_code' => $id];
        $comp = $this->complaint_model->getField('comp_code,reply_message,emp_id', $where)->row();
        $user = $this->session->userdata('emp_id');

        if ($this->form_validation->run('compemp') == FALSE) {
            if ($comp->reply_message && $user == $comp->emp_id) {
                $data['complaint'] = $comp->reply_message;
                $data['title'] = 'Edit Pesan';
                $mess = 'diedit';
            } else {
                $data['title'] = 'Tambah Pesan';
                $mess = 'ditambahkan';
            }
            $data['id'] = $id;

            $this->template->loadadmin(UE_FOLDER . '/messcomplaint', $data);
        } else {
            $this->complaint_model->update($id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert">Pesan berhasil ' . $mess . '.</div>');
                redirect(UE_COMPLAINT);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Pesan gagal ' . $mess . '</div>');
                redirect(UE_COMPLAINT . '/'  . 'pesan/' . $id);
            }
        }
    }


    public function status($id = NULL)
    {
        $this->complaint_model->status($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function delete($id = NULL)
    {
    }

    //List
    public function list()
    {
        $list = $this->complaint_model->get_datatables("employ");
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $complaint = $d->comp_code . '<hr class="my-0">' . DateTime($d->date_created) . '<hr class="my-0"> Terakhir diperbarui : ' . timeInfo($d->date_update);
            $row[] = $complaint;
            $row[] = $d->comp_title;

            $user = $this->session->userdata('emp_id');
            if ($d->emp_id == $user) {
                $changebtn = '<a class="btn btn-primary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="update(' . "'" . $d->comp_code . "'" . ')"><span class="text">Ganti Pesan</span></a>';
            } else {
                $changebtn = '';
            }

            $apply = $d->name_apply . '<hr class="my-0">' . $d->email_apply . '<hr class="my-0">' . $d->phone_apply . '<hr class="my-0"><a class="btn btn-dark btn-icon-split btn-sm mt-1" href="javascript:void(0)" onclick="message(' . "'" . $d->comp_code . "'" . ')"><span class="icon text-white-50"><i class="fas fa-envelope"></i></span><span class="text">Lihat Pesan</span></a>';
            $row[] = $apply;

            if ($d->reply_message) {
                $emp = $d->name_emp . '<hr class="my-0"> Nip :' . $d->csidn . '<hr class="my-0">' . $d->email_emp . '<hr class="my-0">' . $d->phone_emp . '<hr class="my-0"><a class="btn btn-secondary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="reply(' . "'" . $d->comp_code . "'" . ')"><span class="icon text-white-50"><i class="fas fa-reply"></i></span><span class="text">Lihat Pesan</span></a> ' . $changebtn;
            } else {
                $emp = '<a class="btn btn-primary btn-icon-split btn-sm my-1" href="javascript:void(0)" onclick="update(' . "'" . $d->comp_code . "'" . ')"><span class="text">Kirim Pesan</span></a>';
            }

            $row[] = $emp;
            $row[] = ucfirst($d->status) . '<hr class="my-0"><a href="javascript:void(0)" onclick="status(' . "'" . $d->comp_code . "'" . ')" class="badge badge-info">Ganti Status</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->complaint_model->count_all(),
            "recordsFiltered" => $this->complaint_model->count_filtered("employ"),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function message($id = NULL)
    {
        $where = ['comp_code' => $id];
        $data = $this->complaint_model->getField(NULL, $where)->row();

        $employee = $this->employee_model->getDataBy($data->emp_id, 'emp_id')->row();
        // $applicant = $this->applicant_model->getDataBy($data->applicant_id, 'applicant_id')->row();

        if ((!isset($id)) || (!$data)) {
            redirect(show_404());
        };

        if ($data) {
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

    //summernote
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
