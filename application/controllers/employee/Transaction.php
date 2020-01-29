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
        $emp = $this->employee_model->getDataBy($trans->emp_id, 'emp_id')->row();
        $apply = $this->applicant_model->getDataBy($trans->apply_id, 'applicant_id')->row();

        if ((!isset($id)) || (!$trans)) redirect(show_404());


        $data['type'] = $this->type_model->getData()->result_array();
        $data['user'] = dAdmin();
        $data['trans'] = $trans;
        $data['req'] =  $req;
        $data['emp'] =  $emp;
        $data['apply'] =  $apply;
        $data['title'] = 'Detail Transaksi';
        $this->template->loadadmin(UE_FOLDER . '/detail', $data);
    }

    public function detailAjax($id = NULL)
    {
        $trans = $this->transaction_model->getField('*', ['trans_code' => $id])->row();
        if ((!isset($id)) || (!$trans)) redirect(show_404());

        $req = $this->subtype_model->groupTrans($trans->subtype_id)->row();
        $emp = $this->employee_model->getDataBy($trans->emp_id, 'emp_id')->row();
        $apply = $this->applicant_model->getDataBy($trans->apply_id, 'applicant_id')->row();

        if ($trans) {
            //Kode Transaksi
            $data['trans_code'] = $trans->trans_code;

            //Kode Penyimpanan File
            if ($trans->transcode_storage) {
                $data['transcode_storage'] = $trans->transcode_storage;
            } else {
                $data['transcode_storage'] = '-';
            }

            //Tanggal Transaksi
            if ($trans->date_created) {
                $data['date_created'] = DateTime($trans->date_created);
            }

            //Identitas Pengguna
            if ($trans->apply_id && $trans->apply_name && $trans->apply_institute && $trans->apply_email && $trans->apply_phone) {
                $data['apply'] = '<ul class="applicant"><li>Nama : ' . $trans->apply_name . '</li><li>Instansi : ' . $trans->apply_institute . '</li><li>Email : ' . $trans->apply_email . '</li><li>No. Hp : ' . $trans->apply_phone . '</li></ul>';
            } elseif ($apply) {
                $data['apply'] = '<ul class="applicant"><li>Nama : ' . $apply->first_name . ' ' . $apply->last_name . '</li><li>Instansi : ' . $apply->institute . '</li><li>Email : ' . $apply->email . '</li><li>No. Hp : ' . $apply->phone . '</li></ul>';
            } else {
                $data['apply'] = '-';
            }

            //Jenis Informasi
            if ((in_array($trans->trans_status, [2, 3, 4])) && (in_array($trans->payment_status, [3, 0])) && $trans->trans_request && $trans->trans_rates && $trans->trans_unit) {
                $data['trans_request'] = $trans->trans_request;
                $data['trans_rates'] =  rupiah($trans->trans_rates) . " - " .  $trans->trans_unit;
            } elseif ((in_array($trans->payment_status, [2, 1, 4, 5])) && (in_array($trans->trans_status, [1, 5])) && $trans->subtype_id) {
                if ($req) {
                    $datareq = $req->description . "<li>" . $req->sub_description . "</li>";
                    $datarates = rupiah($req->rates) . " - " . $req->unit;
                } else {
                    $datareq = 'Jenis permintaan tidak ada';
                    $datarates = "--";
                }
                $data['trans_request'] = $datareq;
                $data['trans_rates'] = $datarates;
            } else {
                $data['trans_request'] = '-';
                $data['trans_rates'] = '-';
            }

            //Jumlah
            if (isset($trans->trans_amount)) {
                $data['trans_amount'] = $trans->trans_amount;
            } else {
                $data['trans_amount'] = '-';
            }

            //Total
            if (isset($trans->trans_sum)) {
                $data['trans_sum'] = $trans->trans_sum;
            } else {
                $data['trans_sum'] = '-';
            }

            //Status Pembayaran
            if ($trans->payment_status) {
                $array = ['trans_sum' => $trans->trans_sum];
                $data['payment_status'] = payStatus($trans->payment_status, $array);
            } else {
                $data['payment_status'] = '-';
            }

            //Status Transaksi
            if (isset($trans->trans_status)) {
                $data['trans_status'] = statusTrans($trans->trans_status, 'transaction');
            } else {
                $data['trans_status'] = '-';
            }

            //Petugas Layanan
            if ($trans->emp_id && $trans->emp_name && $trans->emp_posname && $trans->emp_csidn) {
                $data['employ'] = '<ul class="applicant"><li>Nama : ' . $trans->emp_name . '</li><li>Jabatan : ' . $trans->emp_posname . '</li><li>NIP : ' . $trans->emp_csidn . '</li></ul>';
            } elseif ($emp) {
                $data['employ'] = '<ul class="applicant"><li>Nama : ' . $emp->first_name . ' ' . $emp->last_name . '</li><li>Jabatan : ' . $emp->pos_name . '</li><li>NIP : ' . $emp->csidn . '</li></ul>';
            } else {
                $data['employ'] = '-';
            }

            $data['status'] = TRUE;
            echo json_encode($data);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function addConfirmTrans()
    {
        $subtype_id = $this->input->post('trans_request');
        $req = $this->subtype_model->groupTrans($subtype_id)->row();

        //$this->_validPayment();
        $this->transaction_model->confirmTrans($req);
        echo json_encode(array("status" => TRUE));
    }

    private function _validPayment($method = NULL)
    {
        $data = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('trans_request') == '') {
            $data['inputerror'][] = 'trans_request';
            $data['error_string'][] = 'Jenis Permintaan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('trans_rates') == '') {
            $data['inputerror'][] = 'trans_rates';
            $data['error_string'][] = 'Tarif tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('trans_amount') == '') {
            $data['inputerror'][] = 'trans_amount';
            $data['error_string'][] = 'Jumlah tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('trans_sum') == '') {
            $data['inputerror'][] = 'trans_sum';
            $data['error_string'][] = 'Total tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
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

    public function canceltransaction($id)
    {
        $this->transaction_model->cancelTransaction($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }

    // summernote ==============================
    public function upload_image()
    {
        upload_image();
    }

    public function delete_image()
    {
        delete_image();
    }
}

/* End of file Transaction.php */
