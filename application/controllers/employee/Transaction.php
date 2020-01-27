<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation']);
        $this->load->model(['transaction_model', 'applicant_model', 'employee_model', 'subtype_model', 'type_model', 'document_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Transaksi Data Layanan';
        $this->template->loadadmin(UE_FOLDER . '/Transaction', $data);
    }

    //List All
    public function listAll()
    {
        $where = [];
        $for = 'emp';
        $all = 'all';
        $list = $this->transaction_model->get_datatables($where, $for, $all);
        $user = $this->session->userdata('emp_id');

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $d->trans_code;

            $group = $d->fullname . '<hr class="my-2">';
            $group .= $d->institute . '<hr class="my-2">';
            $group .= $d->email . '<hr class="my-2">';
            $group .= $d->phone;
            $row[] = $group;

            $row[] = ($d->transcode_storage) ? $d->transcode_storage : "-";
            $row[] = timeIDN(date('Y-m-d', strtotime($d->date_created)), true);

            // $row[] = statusTrans($d->trans_status, 'transaction');

            if (in_array($d->trans_status, [0])) {
                // redirect('/404_override');
                $btn = '<a title="Batalkan Transaksi" class="btn btn-danger btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="cancel(' . "'" . $d->trans_code . "'" . ')"><i class="fas fa-times"></i></a>';
            } else {
                $btn = '';
            }

            $row[] = '
            <a title="Detail Transaksi" class="btn btn-info btn-circle btn-sm mb-2" href="javascript:void(0)" onclick="view(' . "'" . $d->trans_code . "'" . ')"><i class="fas fa-search-plus"></i></a>' . $btn;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transaction_model->count_all($where),
            "recordsFiltered" => $this->transaction_model->count_filtered($where, $for, $all),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detail($id = NULL)
    {
        $trans = $this->transaction_model->getField('*', ['trans_code' => $id])->row();
        $req = $this->subtype_model->groupTrans($trans->subtype_id)->row();
        if ($req && $trans->subtype_id) {
            $request = $req->sub_description . " - " . $req->description;
            $rates = rupiah($req->rates) . " - " . $req->unit;
        } else {
            $request = "Jenis permintaan tidak ditemukan";
            $rates = "-";
        }

        $emp = $this->employee_model->getDataBy($trans->emp_id, 'emp_id')->row();
        if ($emp && $trans->emp_id) {
            $emp_name = $emp->first_name . " " . $emp->last_name;
            $emp_posname =  $emp->pos_name;
        } else {
            $emp_name = "";
            $emp_posname = "";
        }

        if ((!isset($id)) || (!$trans)) redirect(show_404());

        $data['user'] = dUser();
        $data['trans'] = $trans;
        $data['request'] =  $request;
        $data['rates'] =  $rates;
        $data['emp_name'] =  $emp_name;
        $data['emp_posname'] =  $emp_posname;
        $data['title'] = 'Detail Transaksi';
        $this->template->loadadmin(UE_FOLDER . '/detail', $data);
    }

    public function docList($id)
    {
        $list = $this->document_model->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $d->doc_name;
            $row[] = $d->user_upload;
            $row[] = DateTime($d->date_update);
            $row[] = $d->doc_information;

            $url = base_url("assets/transfile/") . $d->doc_storage;

            if ($_SERVER['HTTP_HOST'] !== "localhost") {
                $btn = '<a title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" href="https://docs.google.com/viewerng/viewer?url=' . $url . '" target="_blank"><i class="fas fa-download"></i></a>';
            } else {
                $btn = '<a title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" href="' . $url . '" target="_blank"><i class="fas fa-download"></i></a>';
            }
            $row[] = $btn;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->document_model->count_all($id),
            "recordsFiltered" => $this->document_model->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
    }

    //Update one item
    public function update($id = NULL)
    {
    }

    public function canceltransaction($id)
    {
        $this->transaction_model->cancelTransaction($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }

    //Upload image summernote
    function upload_image()
    {
        if (isset($_FILES["image"]["name"])) {
            $config['upload_path'] = './assets/img-sn/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->upload->display_errors();
                return FALSE;
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/img-sn/' . $data['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 800;
                $config['height'] = 800;
                $config['new_image'] = './assets/img-sn/' . $data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url() . 'assets/img-sn/' . $data['file_name'];
            }
        }
    }

    //Delete image summernote
    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
}

/* End of file Transaction.php */
