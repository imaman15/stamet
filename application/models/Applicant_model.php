<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

    private $_table = "applicant";

    public $applicant_id;
    public $email;
    public $password;
    public $photo = "default.jpg";
    public $first_name;
    public $last_name;
    public $nin;
    public $address;
    public $education;
    public $job_category;
    public $institute;
    public $phone;
    public $is_active = 1;
    public $date_created;

    public function login($post)
    {
        $this->email = $post["email"];
        return $this->db->get_where($this->_table, ["email" => $this->email])->row();
        // row() fungsi untuk mengambil satu data dari hasil query
    }

    public function getData($user = NULL)
    {
        $this->applicant_id = $user;
        $this->db->from($this->_table);
        if ($this->applicant_id != NULL) {
            $this->db->where('applicant_id', $this->applicant_id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $this->email = htmlspecialchars($post["email"], true);
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->photo;
        $this->first_name = htmlspecialchars(ucwords($post["first_name"]), true);
        $this->last_name = htmlspecialchars(ucwords($post["last_name"]), true);
        $this->nin = $post["nin"];
        $this->address = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $this->education = $post["education"];
        $this->job_category = $post["job_category"];
        $this->institute = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $this->phone = phoneNumber($post["phone"]);
        $this->is_active;
        $this->date_created = time();
        $this->db->insert($this->_table, $this);
    }

    public function update($post)
    {
        $this->applicant_id = $this->session->userdata('applicant_id');
        $this->email = $post["email"];
        $params['first_name'] = htmlspecialchars(ucwords($post["first_name"]), true);
        $params['last_name'] = htmlspecialchars(ucwords($post["last_name"]), true);
        $params['nin'] = $post["nin"];
        $params['address'] = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $params['education'] = $post["education"];
        $params['job_category'] = $post["job_category"];
        $params['institute'] = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $params['phone'] = phoneNumber($post["phone"]);

        // Cek Jika ada gambar yang akan diupload
        $upload_image = $_FILES['photo']['name'];
        if ($upload_image) {
            $config['upload_path']          = './assets/img/profil/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['file_name']            = $this->users->applicant()->nin;
            $config['max_size']             = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                $old_image = $this->users->applicant()->photo;
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/profil/' . $old_image);
                }
                $params['photo'] = $this->upload->data('file_name');
            } else {
                $eror = $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">' . $eror . '</div>');
                redirect(UA_EDITPROFILE);
            }
        }

        $this->db->where(array('applicant_id' => $this->applicant_id, 'email' => $this->email));
        $this->db->update($this->_table, $params);
    }

    public function changepassword($post)
    {
        $currentPassword = $post['currentPassword'];
        $newPassword = $post['password'];
        $this->password = $this->users->applicant()->password;
        $this->applicant_id = $this->session->userdata('applicant_id');
        $this->email = $this->users->applicant()->email;
        if (!password_verify($currentPassword, $this->password)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
            <strong>Maaf!</strong> Kata sandi lama Anda salah.</div>');
            redirect(UA_CHANGEPASSWORD);
        } else {
            if ($currentPassword == $newPassword) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Kata sandi baru tidak boleh sama dengan kata sandi lama.</div>');
                redirect(UA_CHANGEPASSWORD);
            } else {
                //password ok
                $password = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->set('password', $password);
                $this->db->where(array('applicant_id' => $this->applicant_id, 'email' => $this->email));
                $this->db->update($this->_table);
            }
        }
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ["applicant_id" => $id]);
    }
}

/* End of file Applicant_model.php */
