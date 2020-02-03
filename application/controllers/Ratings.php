<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Ratings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        app_not_login();
        $this->load->library(['form_validation']);
        $this->load->model(['questions_model', 'answer_model', 'cands_model']);
    }

    // List all your items
    public function index()
    {

        $que = $this->questions_model->getData()->result_array();
        $i = 1;
        foreach ($que as $d) {
            $this->form_validation->set_rules(
                'answer' . $i . $d['ratque_id'],
                '<strong>Pertanyaan</strong>',
                'trim|required',
                array('required' => '%s ini belum diisi.')
            );
            $i++;
        }
        $required = '%s harus diisi.';
        $this->form_validation->set_rules(
            'applicant_name',
            '<strong>Nama</strong>',
            'trim|required',
            array('required' => $required)
        );

        $this->form_validation->set_rules(
            'applicant_email',
            '<strong>Email</strong>',
            'trim|required',
            array('required' => $required)
        );

        $this->form_validation->set_rules(
            'applicant_phone',
            '<strong>No. Handphone</strong>',
            'trim|required',
            array('required' => $required)
        );

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = dUser();
            $data['question'] = $que;
            $data['title'] = 'Pendapat Anda tentang pelayanan kami';
            $this->template->load('user/ratings', $data);
        } else {
            $this->cands_model->add();
            $cands_id = $this->db->insert_id();
            $this->answer_model->add($cands_id, $que);
        }
    }
}

/* End of file Ratings.php */
