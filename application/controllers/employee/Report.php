<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2]);
        $this->load->library(['form_validation']);
        $this->load->model(['report_model']);
    }

    // List all your items
    public function reportTransRate()
    {
        $data['title'] = 'Laporan Transaksi Data Tarif';
        $this->template->loadadmin(UE_FOLDER . '/reporttransrates', $data);
    }

    // List all your items
    public function reportTransNonRate()
    {
        $data['title'] = 'Laporan Transaksi Non Tarif';
        $this->template->loadadmin(UE_FOLDER . '/reporttransnonrates', $data);
    }

    //List All
    public function list($for = NULL)
    {

        if ($_POST["is_date_search"] == "yes") {
            $startDate = $_POST["start_date"];
            $endDate = $_POST["end_date"];
        } else {
            $startDate = NULL;
            $endDate = NULL;
        }

        $list = $this->report_model->get_datatables($for,  $startDate, $endDate);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $d) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = date('d-M-Y', strtotime($d->date_created));
            $row[] = $d->apply_name . '<br>' . $d->apply_institute;
            $row[] = $d->trans_code . '<br>' . $d->trans_request;
            if ($for == "rates") {
                $row[] = rupiah($d->trans_sum);
            };

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all($for,  $startDate, $endDate),
            "recordsFiltered" => $this->report_model->count_filtered($for,  $startDate, $endDate),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function printTransRate($startDate = NULL, $endDate = NULL)
    {
        $for = 'rates';

        $data['trans'] = $this->report_model->print($for,  $startDate, $endDate);

        $data['for'] = $for;
        $html = $this->load->view('printTransRate', $data, TRUE);
        PdfGenerator($html, 'Laporan SIPJAMET - ' . date('dmyHis'), 'A4', 'portrait');
    }

    function printTransNonRate($startDate = NULL, $endDate = NULL)
    {
        $for = NULL;
        if ($startDate &&  $endDate) {
            $data['trans'] = $this->report_model->print($for,  $startDate, $endDate);
        } else {
            $data['trans'] = $this->report_model->print($for,  NULL, NULL);
        }

        $data['for'] = $for;
        $html = $this->load->view('printTransRate', $data, TRUE);
        PdfGenerator($html, 'Laporan SIPJAMET - ' . date('dmyHis'), 'A4', 'portrait');
    }
}

/* End of file Report.php */
