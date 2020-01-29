<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Configuration extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        admin_not_login([2, 3]);
        $this->load->model('configuration_model');
        $this->load->library(['form_validation']);
    }

    // List all your items
    public function index()
    {
        if ($this->form_validation->run('confadd') == FALSE) {
            $data['conf'] = $this->configuration_model->getField(NULL, ['id' => 1])->row();
            $data['title'] = 'Konfigurasi';
            $this->template->loadadmin(UE_FOLDER . '/configuration', $data);
        } else {
            $this->configuration_model->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success animated zoomIn fast" role="alert">Konfigurasi berhasil diedit.</div>');
                redirect(UE_CONFIGURATION);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Konfigurasi gagal diedit</div>');
                redirect(UE_CONFIGURATION);
            }
        }
    }
}

/* End of file Controllername.php */
