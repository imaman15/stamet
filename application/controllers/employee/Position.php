<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Position extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        admin_not_login([2, 3]);
        //Load Dependencies
        $this->load->library(['form_validation']);
        $this->load->model(['position_model']);
    }

    // List all your items
    public function index()
    {
        $data['title'] = 'Data Jabatan';
        $this->template->loadadmin('employee/position', $data);
    }

    // Add a new item
    public function add()
    {
        $this->_validate();
        $this->position_model->add();
        echo json_encode(["status" => TRUE]);
    }

    //Update one item
    public function update($id = NULL)
    {
        $this->_validate();
        $this->position_model->update();
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $check = $this->position_model->getData(["pos_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->position_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function view($id = NULL)
    {
        $data = $this->position_model->getData(["pos_id" => $id])->row();
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    public function list()
    {
        $list = $this->position_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $position) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $position->pos_name;
            $row[] = $position->pos_information;
            $row[] = date('d-m-Y H:i:s', strtotime($position->date_update));

            $row[] = '
            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_pos(' . "'" . $position->pos_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_pos(' . "'" . $position->pos_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->position_model->count_all(),
            "recordsFiltered" => $this->position_model->count_filtered(),
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

        if ($this->input->post('pos_name') == '') {
            $data['inputerror'][] = 'pos_name';
            $data['error_string'][] = 'Nama Jabatan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Position.php */
