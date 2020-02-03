<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Questions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([3]);
        $this->load->library(['form_validation']);
        $this->load->model(['questions_model', 'answer_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Pertanyaan Survey';
        $this->template->loadadmin(UE_FOLDER . '/questions', $data);
    }

    public function list()
    {
        $list = $this->questions_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ratque) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $ratque->description;
            $row[] = $ratque->information;
            $row[] = timeIDN(date('Y-m-d'), strtotime($ratque->date_created));
            $row[] = date('d-m-Y H:i:s', strtotime($ratque->date_update));

            $row[] = '
            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_ratque(' . "'" . $ratque->ratque_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_ratque(' . "'" . $ratque->ratque_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->questions_model->count_all(),
            "recordsFiltered" => $this->questions_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        $this->_validatereq();
        $this->questions_model->add();
        echo json_encode(["status" => TRUE]);
    }

    //Update one item
    public function update()
    {
        $this->_validatereq();
        $this->questions_model->update();
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $check = $this->questions_model->getData(["ratque_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->questions_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function viewdelete($id = NULL)
    {
        $check = $this->questions_model->getData(["ratque_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));

        $answer = $this->answer_model->getData(["ratque_id" => $id])->num_rows();

        if ($answer > 0) {
            $message = "Mohon maaf data ini sudah di gunakan.";
            echo json_encode(array("status" => FALSE, "message" => $message));
        } else {
            $message = "Data yang dihapus tidak akan bisa dikembalikan.";
            //delete file
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function view($id = NULL)
    {
        $data = $this->questions_model->getData(["ratque_id" => $id])->row();
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    private function _validatereq()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('description') == '') {
            $data['inputerror'][] = 'description';
            $data['error_string'][] = 'Pertanyaan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Qusetions.php */
