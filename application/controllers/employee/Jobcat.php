<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Jobcat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->library(['form_validation', 'email']);
        $this->load->model(['jobcategory_model']);
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Kategori Pekerjaan';
        $this->template->loadadmin('employee/jobcat', $data);
    }

    // Add a new item
    public function add()
    {
        $this->_validate();
        $this->jobcategory_model->add();
        echo json_encode(["status" => TRUE]);
    }

    //Update one item
    public function update($id = NULL)
    {
        $this->_validate();
        $this->jobcategory_model->update();
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $check = $this->jobcategory_model->getData($id)->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->jobcategory_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function view($id = NULL)
    {
        $data = $this->jobcategory_model->getData($id)->row();
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    public function list()
    {
        $list = $this->jobcategory_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $job_category) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $job_category->jobcat;
            $row[] = $job_category->jobcat_information;
            $row[] = $job_category->date_update;

            $row[] = '
            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_jobcat(' . "'" . $job_category->jobcat_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_jobcat(' . "'" . $job_category->jobcat_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jobcategory_model->count_all(),
            "recordsFiltered" => $this->jobcategory_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('jobcat') == '') {
            $data['inputerror'][] = 'jobcat';
            $data['error_string'][] = 'Nama kategori pekerjaan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Jobcat.php */
