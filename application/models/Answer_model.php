<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Answer_model extends CI_Model
{
    private $_table = 'rate_answer';

    public function getData($where = NULL)
    {
        $this->db->from($this->_table);
        if ($where != NULL) {
            $this->db->where($where);
        }
        return $this->db->get();
    }

    public function amount($id)
    {
        $this->db->select('SUM(answerA) AS A, SUM(answerB) AS B, SUM(answerC) AS C, SUM(answerC) AS C, SUM(answerD) AS D, SUM(answerE) AS E', FALSE);
        $this->db->from($this->_table);
        $this->db->where('ratque_id', $id);
        return $this->db->get();
    }

    public function total()
    {
        $this->db->select('SUM(answerA) AS A, SUM(answerB) AS B, SUM(answerC) AS C, SUM(answerC) AS C, SUM(answerD) AS D, SUM(answerE) AS E', FALSE);
        $this->db->from($this->_table);
        return $this->db->get();
    }

    public function add($cands_id, $que)
    {
        $i = 1;
        foreach ($que as $c) {
            $answer = $this->input->post('answer' . $i . $c['ratque_id']);
            if ($answer == 'A') {
                $data['answer'] = $answer;
                $data['answerA'] = 1;
                $data['answerB'] = 0;
                $data['answerC'] = 0;
                $data['answerD'] = 0;
                $data['answerE'] = 0;
            } else if ($answer == 'B') {
                $data['answer'] = $answer;
                $data['answerA'] = 0;
                $data['answerB'] = 1;
                $data['answerC'] = 0;
                $data['answerD'] = 0;
                $data['answerE'] = 0;
            } else if ($answer == 'C') {
                $data['answer'] = $answer;
                $data['answerA'] = 0;
                $data['answerB'] = 0;
                $data['answerC'] = 1;
                $data['answerD'] = 0;
                $data['answerE'] = 0;
            } else if ($answer == 'D') {
                $data['answer'] = $answer;
                $data['answerA'] = 0;
                $data['answerB'] = 0;
                $data['answerC'] = 0;
                $data['answerD'] = 1;
                $data['answerE'] = 0;
            } else if ($answer == 'E') {
                $data['answer'] = $answer;
                $data['answerA'] = 0;
                $data['answerB'] = 0;
                $data['answerC'] = 0;
                $data['answerD'] = 0;
                $data['answerE'] = 1;
            } else {
                $data['answer'] = $answer;
                $data['answerA'] = 0;
                $data['answerB'] = 0;
                $data['answerC'] = 0;
                $data['answerD'] = 0;
                $data['answerE'] = 0;
            }
            $data['ratque_id'] = $c['ratque_id'];
            $data['cands_id'] = $cands_id;
            $this->db->insert($this->_table, $data);
            $i++;
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert"><strong>' . dUser()->first_name . ' ' . dUser()->last_name . '</strong> Terima kasih atas waktu yang telah diluangkan untuk melengkapi survey yang kami sediakan. <br>Pendapat Anda sangat berarti bagi kami untuk meningkatkan pelayanan.</div>');
            redirect(site_url());
        }
        $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
        <strong>Maaf!</strong> Anda gagal mengisi survey. Silahkan coba kembali.</div>');
        redirect(UA_RATINGS);
    }
}

/* End of file Answer_model.php */
