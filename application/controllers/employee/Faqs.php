<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Faqs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->library(['form_validation', 'upload']);
        $this->load->model(['faqs_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        admin_not_login([2, 3]);
        $data['title'] = 'Frequently Asked Questions';
        $this->template->loadadmin(UE_FOLDER . '/faq', $data);
    }

    public function list()
    {
        admin_not_login([2, 3]);
        $list = $this->faqs_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $faqs) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $faqs->faqs_questions;
            $row[] = '
            <a class="btn btn-info btn-icon-split btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="view_faqs(' . "'" . $faqs->faqs_id . "'" . ')"><span class="icon text-white-50"><i class="fas fa-question"></i></span><span class="text">Lihat</span></a>';
            $row[] = timeIDN(date('Y-m-d', strtotime($faqs->date_created)));
            $row[] = ($faqs->status == 1) ? "Publish" : "Draft";
            $row[] = timeInfo($faqs->date_update);

            $row[] = '
            <a title="Edit FAQS" class="btn btn-warning btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="edit_faqs(' . "'" . $faqs->faqs_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus FAQS" class="btn btn-danger btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="delete_faqs(' . "'" . $faqs->faqs_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->faqs_model->count_all(),
            "recordsFiltered" => $this->faqs_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        admin_not_login([2, 3]);
        if ($this->form_validation->run('faqadd') == FALSE) {
            $data['title'] = 'Tambah FAQS';
            $this->template->loadadmin(UE_FOLDER . '/addfaq', $data);
        } else {
            $this->faqs_model->add();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert">FAQS berhasil ditambahkan.</div>');
                redirect(UE_MANAGEFAQ);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> FAQS gagal ditambahkan</div>');
                redirect(UE_MANAGEFAQ . UE_ADD);
            }
        }
    }

    public function view($id = NULL)
    {
        admin_not_login([2, 3]);
        $data = $this->faqs_model->getData(['faqs_id' => $id])->row();
        echo json_encode($data);
    }

    //Update one item
    public function update($id = NULL)
    {
        admin_not_login([2, 3]);
        if ($this->form_validation->run('faqadd') == FALSE) {
            $data['faqs'] = $this->faqs_model->getData(['faqs_id' => $id])->row();
            $data['title'] = 'Edit FAQS';
            $this->template->loadadmin(UE_FOLDER . '/editfaq', $data);
        } else {
            $this->faqs_model->update($id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert">FAQS berhasil diedit.</div>');
                redirect(UE_MANAGEFAQ);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> FAQS gagal diedit</div>');
                redirect(UE_MANAGEFAQ . UE_UPDATE . '/' . $id);
            }
        }
    }

    //Delete one item
    public function delete($id = NULL)
    {
        admin_not_login([2, 3]);
        $check = $this->faqs_model->getData(["faqs_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->faqs_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    //=============Front End ==========
    // List all your items
    public function frontend()
    {
        $user = $this->session->userdata('emp_id');
        if ($user) {
            $data['url'] = site_url(UE_MANAGEFAQ);
        } else {
            $data['url'] = site_url();
        }

        $data['faqs'] = $this->faqs_model->getData(["status" => 1])->result_array();
        $data['title'] = 'Frequently Asked Questions';
        $this->load->view('faq', $data, FALSE);
    }

    // summernote ==============================
    public function upload_image()
    {
        admin_not_login([2, 3]);
        upload_image();
    }

    public function delete_image()
    {
        admin_not_login([2, 3]);
        delete_image();
    }
}

/* End of file Faqs.php */
