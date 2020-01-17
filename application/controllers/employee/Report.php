<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->library(['form_validation']);
        $this->load->model(['employee_model', 'position_model', 'usertoken_model']);
    }

    // List all your items
    public function reportSurvey()
    {
        admin_not_login([3]);
        $data['title'] = 'Laporan Survey Pengguna';
        $this->template->loadadmin(UE_FOLDER . '/reportsurvey', $data);
    }

    // List all your items
    public function reportTransRate()
    {
        admin_not_login([2]);
        $data['title'] = 'Laporan Transaksi Data Tarif';
        $this->template->loadadmin(UE_FOLDER . '/reporttransrates', $data);
    }

    // List all your items
    public function reportTransNonRate()
    {
        admin_not_login([2]);
        $data['title'] = 'Laporan Transaksi Non Tarif';
        $this->template->loadadmin(UE_FOLDER . '/reporttransnonrates', $data);
    }
}

/* End of file Report.php */
