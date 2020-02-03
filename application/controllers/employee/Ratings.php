<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Ratings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([3]);
        $this->load->library(['form_validation']);
        $this->load->model(['cands_model', 'answer_model', 'questions_model']);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['title'] = 'Hasil Survey';
        $this->template->loadadmin(UE_FOLDER . '/ratings', $data);
    }

    public function listCands()
    {
        $list = $this->cands_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cands) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $cands->applicant_name . '<hr class="my-0">' . $cands->applicant_email . '<hr class="my-0">' . $cands->applicant_phone;
            $row[] = $cands->cands_message;
            $row[] = timeIDN(date('Y-m-d'), strtotime($cands->date_created));

            if ($cands->status == "belum") {
                $canstat = ucfirst($cands->status) . '<hr class="my-0"><a href="javascript:void(0)" id="btnStat" onclick="status(' . "'" . $cands->cands_id . "'" . ')" class="badge badge-info p-1 m-1">Ganti Status</a>';
            } else {
                $canstat = ucfirst($cands->status);
            }

            $row[] = $canstat;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cands_model->count_all(),
            "recordsFiltered" => $this->cands_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function statusCands($id)
    {
        $this->cands_model->status($id);
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Ratings.php */
