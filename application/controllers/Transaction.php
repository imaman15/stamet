<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
        $this->load->library(['form_validation', 'upload', 'email']);
        $this->load->model(['transaction_model', 'type_model', 'subtype_model', 'document_model', 'configuration_model']);
    }

    public function index()
    {
        $data['title'] = 'Riwayat Transaksi';
        $this->template->load('transaction/list', $data);
    }

    //List
    public function list()
    {
        $list = $this->transaction_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $d->trans_code;
            $row[] = timeIDN(date('Y-m-d', strtotime($d->date_created)), true);
            $array = ['trans_code' => $d->trans_code, 'trans_sum' => $d->trans_sum,];
            $row[] = statusTrans($d->payment_status, 'pay', $array);
            $row[] = statusTrans($d->trans_status, 'transaction');

            if (in_array($d->trans_status, [0, 1])) {
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
            "recordsTotal" => $this->transaction_model->count_all(),
            "recordsFiltered" => $this->transaction_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        if ($this->form_validation->run('transadd') == FALSE) {
            $data['user'] = dUser();
            $data['type'] = $this->type_model->getData()->result_array();
            $data['title'] = 'Form Permintaan Data';
            $this->template->load('transaction/add', $data);
        } else {
            $this->transaction_model->apply();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert"><strong>Selamat!</strong> Formulir permintaan data Anda berhasil di kirim. Cek Riwayat Transaksi atau Email Anda secara berkala.</div>');
                redirect(UA_TRANSHISTORY);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Formulir permintaan data Anda gagal di kirim. Silahkan coba kembali</div>');
                redirect(UA_TRANSACTION);
            }
        }
    }

    public function viewPay($id)
    {
        $user = $this->session->userdata('applicant_id');
        $select = 'apply_id,payment_to,payment_date,payment_bank,payment_number,payment_from,payment_amount,payment_img,payment_status';
        $where = ['trans_code' => $id, 'apply_id' => $user];
        $data = $this->transaction_model->getField($select, $where)->row();

        if ((!isset($id)) || (!$data) || ($data->apply_id !== $user)) redirect(show_404());

        if ($data && $data->apply_id == $user) {
            $data->payment_dateConvert = DateTime($data->payment_date);
            $data->payment_amountConvert = rupiah($data->payment_amount);
            $data->status = true;
            echo json_encode($data);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function viewBeforePay($id)
    {
        $user = $this->session->userdata('applicant_id');
        $trans = $this->transaction_model->getField('apply_id,trans_sum, payment_to,payment_date,payment_bank,payment_number,payment_from,payment_amount,payment_img,payment_status', ['trans_code' => $id, 'apply_id' => $user])->row();

        $select = 'bank_name, account_number, account_name';
        $conf = $this->configuration_model->getField($select, ['id' => 1])->row();

        if ((!isset($id)) || (!$trans) || ($trans->apply_id !== $user || (!$conf))) redirect(show_404());

        if ($trans->payment_status == 4) {
            if ($trans && $trans->apply_id == $user) {
                $trans->convertDate = date('Y-m-d\TH:i:s', strtotime($trans->payment_date));
                $trans->status = 1;
                echo json_encode($trans);
            } else {
                echo json_encode(['status' => false]);
            }
        } else  if ($trans->payment_status == 1) {
            if ($trans && $trans->apply_id == $user && $conf) {
                $data = new stdClass();
                $data->name = dUser()->first_name . ' ' . dUser()->last_name;
                $data->payfrom_bank_name = $conf->bank_name;
                $data->payfrom_account_number = $conf->account_number;
                $data->payfrom_account_name = $conf->account_name;
                $data->payfrom_sum = $trans->trans_sum;
                $data->sum = rupiah($trans->trans_sum);
                $data->status = 2;
                echo json_encode($data);
            } else {
                echo json_encode(['status' => false]);
            }
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function addpayment()
    {
        $this->_validPayment();
        $this->transaction_model->updatePayment();
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id = NULL)
    {
        $user = $this->session->userdata('applicant_id');
        $trans = $this->transaction_model->getField('*', ['trans_code' => $id, 'apply_id' => $user])->row();
        $req = $this->subtype_model->groupTrans($trans->subtype_id)->row();
        if ($req && $trans->subtype_id) {
            $request = $req->sub_description . " - " . $req->description;
        } else {
            $request = "Jenis permintaan tidak ditemukan";
        }

        if ((!isset($id)) || (!$trans) || ($trans->apply_id !== $user)) redirect(show_404());

        $data['user'] = dUser();
        $data['trans'] = $trans;
        $data['request'] =  $request;
        $data['title'] = 'Detail Transaksi';
        $this->template->load('transaction/detail', $data);
    }

    public function canceltransaction($id)
    {
        $this->transaction_model->cancelTransaction($id);
        // if ($this->db->affected_rows() > 0) {}
        echo json_encode(array("status" => TRUE));
    }


    // summernote ==============================
    public function save()
    {
        $title = $this->input->post('title', FALSE);
        $contents = $this->input->post('contents', FALSE);
        $this->transaction_model->insert_post($title, $contents);
        $id = $this->db->insert_id();
        $result = $this->transaction_model->get_article_by_id($id)->row_array();
        $data['title'] = $result['title'];
        $data['contents'] = $result['contents'];
        $this->template->load('transaction/list', $data);
    }

    public function upload_image()
    {
        upload_image();
    }

    public function delete_image()
    {
        delete_image();
    }

    private function _validPayment($method = NULL)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('payment_date') == '') {
            $data['inputerror'][] = 'payment_date';
            $data['error_string'][] = 'Tanggal Bayar tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($this->input->post('payment_bank') == '') {
            $data['inputerror'][] = 'payment_bank';
            $data['error_string'][] = 'Nama Bank tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('payment_number') == '') {
            $data['inputerror'][] = 'payment_number';
            $data['error_string'][] = 'No. Rekening tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('payment_from') == '') {
            $data['inputerror'][] = 'payment_from';
            $data['error_string'][] = 'Atas Nama tidak boleh kosong.';
            $data['status'] = FALSE;
        }
        if ($this->input->post('payment_amount') == '') {
            $data['inputerror'][] = 'payment_amount';
            $data['error_string'][] = 'Jumlah bayar tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($_FILES['photo']['name'] == '') {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Foto Bukti Bayar tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Transaction.php */
