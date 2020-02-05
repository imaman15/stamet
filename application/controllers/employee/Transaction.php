<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation', 'upload', 'encryption']);
        $this->load->helper('download');
        $this->load->model(['transaction_model', 'applicant_model', 'employee_model', 'subtype_model', 'type_model', 'document_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['new'] = $this->transaction_model->count_all('new');
        $data['pay'] = $this->transaction_model->count_all('pay');
        $data['process'] = $this->transaction_model->count_all('process');
        $data['title'] = 'Transaksi Data Layanan';
        $this->template->loadadmin(UE_FOLDER . '/Transaction', $data);
    }

    //List All
    public function listAll($list = NULL)
    {
        if ($list == 'new') {
            $all = 'new';
        } elseif ($list == 'pay') {
            $all = 'pay';
        } elseif ($list == 'process') {
            $all = 'process';
        } elseif ($list == 'done') {
            $all = 'done';
        } elseif ($list == 'cancel') {
            $all = 'cancel';
        } else {
            $all = '';
        }

        $list = $this->transaction_model->get_datatables('emp', $all);

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

            if ($d->transcode_storage) {
                $transcodeStor = '<span id="' . $d->trans_code . '">' . $d->transcode_storage . '</span><hr class="my-2"><button type="button" class="btn btn-primary btn-sm rounded py-1" onclick="addTransStor(' . "'" . $d->trans_code . "'" . ')">Edit Kode</button>';
            } else {
                $transcodeStor = '<button type="button" class="btn btn-primary btn-sm rounded py-1" onclick="addTransStor(' . "'" . $d->trans_code . "'" . ')">Tambah Kode</button>';
            }

            $row[] = $transcodeStor;
            $row[] = timeIDN(date('Y-m-d', strtotime($d->date_created)), true);

            // $row[] = statusTrans($d->trans_status, 'transaction');

            if (in_array($d->trans_status, [0])) {
                // redirect('/404_override');
                $btn = '<a title="Batalkan Transaksi" class="btn btn-danger btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="cancel(' . "'" . $d->trans_code . "'" . ')"><i class="fas fa-times"></i></a>';
            } else {
                $btn = '';
            }

            $row[] = '
            <a title="Detail Transaksi" class="btn btn-info btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="view(' . "'" . $d->trans_code . "'" . ')"><i class="fas fa-search-plus"></i></a><br>' . $btn;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transaction_model->count_all($all),
            "recordsFiltered" => $this->transaction_model->count_filtered('emp', $all),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detail($id = NULL)
    {
        $trans = $this->transaction_model->getField('*', ['trans_code' => $id])->row();

        if ((!isset($id)) || (!$trans)) redirect(show_404());

        $data['type'] = $this->type_model->getData()->result_array();
        $data['user'] = dAdmin();
        $data['trans'] = $trans;
        $data['title'] = 'Detail Transaksi';
        $this->template->loadadmin(UE_FOLDER . '/detail', $data);
    }

    public function viewSubRequest()
    {
        $id = $this->input->get('id');
        $data = $this->subtype_model->getData(["subtype_id" => $id])->row();
        if ((!isset($id)) or (!$data)) redirect(site_url(UE_ADMIN));
        echo json_encode($data);
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
                $data['trans_sum'] = rupiah($trans->trans_sum);
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


            $user = $this->session->userdata('emp_id');
            $data['userses'] = $user;
            $data['user'] = $trans->emp_id;

            $data['trastat'] = $trans->trans_status;
            $data['paystat'] = $trans->payment_status;
            $data['trans_information'] = $trans->trans_information;

            $data['status'] = TRUE;
            echo json_encode($data);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function addConfirmTrans()
    {
        //$this->_validConTrans();
        $this->transaction_model->confirmTrans();
        echo json_encode(array("status" => TRUE));
    }

    public function addConfirmPay()
    {
        $this->_validConPay();
        $this->transaction_model->confirmPay();
        echo json_encode(array("status" => TRUE));
    }

    public function changeStatusTrans()
    {
        $this->transaction_model->changeStatusTrans();
        echo json_encode(array("status" => TRUE));
    }

    public function addTransInformation()
    {
        $this->transaction_model->addTransInformation();
        echo json_encode(array("status" => TRUE));
    }

    public function saveTranStor()
    {
        $data = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('inputTranStor') == '') {
            $data['inputerror'][] = 'inputTranStor';
            $data['error_string'][] = 'Kode Penyimpanan harus di isi.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }

        $this->transaction_model->saveTranStor();
        echo json_encode(array("status" => TRUE));
    }

    private function _validConPay()
    {
        $data = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('forPay') == 'p') {
            $data['inputerror'][] = 'forPay';
            $data['error_string'][] = 'Status Pembayaran harus di isi.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function viewPay($id = NULL)
    {
        $select = 'apply_id,payment_to,payment_date,payment_bank,payment_number,payment_from,payment_amount,payment_img,payment_status';
        $where = ['trans_code' => $id];
        $data = $this->transaction_model->getField($select, $where)->row();

        if ((!isset($id)) || (!$data)) {
            redirect(show_404());
        };

        if ($data) {
            $data->payment_dateConvert = DateTime($data->payment_date);
            $data->payment_amountConvert = rupiah($data->payment_amount);
            $data->status = true;
            echo json_encode($data);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    private function _validConTrans($method = NULL)
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

        if ($this->input->post('trans_status')) {
            if ($this->input->post('trans_status') == '0') {
                $data['inputerror'][] = 'trans_status';
                $data['error_string'][] = 'Status Transaksi tidak boleh kosong.';
                $data['status'] = FALSE;
            }
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

            //$url = base_url("assets/transfile/") . $d->doc_storage;

            $url = site_url(UE_TRANSACTION . '/download' . '/' . $d->doc_storage);

            if ($_SERVER['HTTP_HOST'] !== "localhost") {
                $btn = '<a title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" href="https://docs.google.com/viewerng/viewer?url=' . $url . '" target="_blank"><i class="fas fa-download"></i></a>';
            } else {
                $btn = '<a title="Download Berkas" class="btn btn-success btn-circle btn-sm mb-1" href="' . $url . '" target="_blank"><i class="fas fa-download"></i></a>';
            }

            $trans = $this->transaction_model->getField('trans_status', ['trans_id' => $id])->row();

            $user = $this->session->userdata('emp_id');
            if (($user == $d->user_id) && ($d->user_type == 'employee') && ($trans->trans_status != 4)) {
                $btndel = '<a title="Download Berkas" class="btn btn-danger btn-circle btn-sm mb-1" href="javascript:void(0)" onclick="delete_doc(' . "'" . $d->doc_id . "'" . ')"><i class="fas fa-trash"></i></a>';
            } else {
                $btndel = '';
            }
            $row[] = $btn . '<br>' . $btndel;

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

    public function download($id)
    {
        $query = $this->document_model->checkDownload(['doc_storage' => $id]);
        if ($query->num_rows() == 0) {
            return show_404();
        }
        $result = $query->row_array();
        $path = FCPATH . 'assets/transfile/';

        $stored_file_name = $result['doc_name'];
        $namefile = str_replace(' ', '_', $stored_file_name);

        $original = $result['doc_storage'];
        $file_parts = pathinfo($original);

        if ($file_parts['extension'] == "docx") {
            $ext = '.docx';
        } elseif ($file_parts['extension'] == "doc") {
            $ext = '.doc';
        } elseif ($file_parts['extension'] == "pdf") {
            $ext = '.pdf';
        }

        force_download($namefile . '_' . date('d-m-Y') . $ext, file_get_contents($path . $original));
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
