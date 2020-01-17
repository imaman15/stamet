<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation']);
        $this->load->model(['type_model', 'subtype_model']);
    }

    // List all your items
    public function request()
    {
        $data['title'] = 'Kategori Permintaan';
        $this->template->loadadmin(UE_FOLDER . '/request', $data);
    }

    public function listrequest()
    {
        $list = $this->type_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $type) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $type->description;
            $row[] = $type->information;
            $row[] = date('d-m-Y H:i:s', strtotime($type->date_update));

            $row[] = '
            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_type(' . "'" . $type->type_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_type(' . "'" . $type->type_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->type_model->count_all(),
            "recordsFiltered" => $this->type_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    // Add a new item
    public function addRequest()
    {
        $this->_validatereq();
        $this->type_model->add();
        echo json_encode(["status" => TRUE]);
    }

    //Update one item
    public function updateRequest($id = NULL)
    {
        $this->_validatereq();
        $this->type_model->update();
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function deleteRequest($id = NULL)
    {
        $check = $this->type_model->getData(["type_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->type_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function viewdeleteRequest($id = NULL)
    {
        $check = $this->type_model->getData(["type_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));

        $subtype = $this->subtype_model->getData(["type_id" => $id])->num_rows();

        if ($subtype > 0) {
            $message = "Mohon maaf data ini sudah di gunakan tabel Jenis Permintaan berjumlah " . $subtype . " data. Silahkan ganti terlebih dahulu untuk menghapus data ini.";
            echo json_encode(array("status" => FALSE, "message" => $message));
        } else {
            $message = "Data yang dihapus tidak akan bisa dikembalikan.";
            //delete file
            echo json_encode(array("status" => TRUE, "message" => $message));
        }
    }

    public function viewRequest($id = NULL)
    {
        $data = $this->type_model->getData(["type_id" => $id])->row();
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
            $data['error_string'][] = 'Kategori Permintaan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    // ====================================================
    public function subrequest($offset = 0)
    {
        $data['title'] = 'Jenis Informasi dan Tarif';
        $data['type_id'] = $this->type_model->getData();
        $this->template->loadadmin(UE_FOLDER . '/subrequest', $data);
    }

    public function listsubrequest()
    {
        $list = $this->subtype_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $subtype) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $subtype->sub_description;
            $row[] = $subtype->unit;
            $row[] = rupiah($subtype->rates);
            $row[] = $subtype->description;
            $row[] = date('d-m-Y H:i:s', strtotime($subtype->date_update));

            $row[] = '
            <a title="Edit Data" class="btn btn-warning btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="edit_subtype(' . "'" . $subtype->subtype_id . "'" . ')"><i class="fas fa-edit"></i></a>

            <a title="Hapus Data" class="btn btn-danger btn-circle btn-sm mb-lg-0 mb-1" href="javascript:void(0)" onclick="delete_subtype(' . "'" . $subtype->subtype_id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subtype_model->count_all(),
            "recordsFiltered" => $this->subtype_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function addSubRequest()
    {
        $this->_validatesubreq();
        $this->subtype_model->add();
        echo json_encode(["status" => TRUE]);
    }

    //Update one item
    public function updateSubRequest($id = NULL)
    {
        $this->_validatesubreq();
        $this->subtype_model->update();
        echo json_encode(array("status" => TRUE));
    }

    //Delete one item
    public function deleteSubRequest($id = NULL)
    {
        $check = $this->subtype_model->getData(["subtype_id" => $id])->row();
        if ((!isset($id)) or (!$check)) redirect(site_url(UE_ADMIN));
        //delete file
        $this->subtype_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function viewSubRequest($id = NULL)
    {
        $data = $this->subtype_model->getData(["subtype_id" => $id])->row();
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
    }

    private function _validatesubreq()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('sub_description') == '') {
            $data['inputerror'][] = 'sub_description';
            $data['error_string'][] = 'Nama Kategori tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('unit') == '') {
            $data['inputerror'][] = 'unit';
            $data['error_string'][] = 'Satuan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('rates') == '') {
            $data['inputerror'][] = 'rates';
            $data['error_string'][] = 'Tarif tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('type_id') == '') {
            $data['inputerror'][] = 'type_id';
            $data['error_string'][] = 'Kategori Permintaan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Request.php */
