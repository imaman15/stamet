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
    public $job_category;
    public $institute;
    public $phone;
    public $is_active = 0;
    public $date_created;

    public function getDataByEmail($email)
    {
        return $this->db->get_where($this->_table, ['email' => $email]);
    }

    public function resetpassword($email)
    {
        $query = $this->db->get_where($this->_table, ['email' => $email, 'is_active' => 1])->row_array();
        return $query;
    }

    public function getData()
    {
        $this->applicant_id = $this->session->userdata('applicant_id');
        $this->db->from($this->_table);
        if ($this->applicant_id != NULL) {
            $this->db->join('job_category', 'job_category.jobcat_id = ' . $this->_table . '.job_category');
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
        $this->job_category = $post["job_category"];
        $this->institute = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $this->phone = phoneNumber($post["phone"], true);
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
        $params['job_category'] = $post["job_category"];
        $params['institute'] = $post['institute'] != "" ? htmlspecialchars(ucwords($post["institute"]), true) : null;
        $params['phone'] = phoneNumber($post["phone"]);

        // Cek Jika ada gambar yang akan diupload
        $upload_image = $_FILES['photo']['name'];
        if ($upload_image) {
            $config['upload_path']          = './assets/img/profil/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['file_name']            = round(microtime(true) * 1000);
            $config['max_size']             = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                $old_image = $this->getData()->row()->photo;
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

    public function updateActivation($email)
    {
        $this->db->set('is_active', 1);
        $this->db->where('email', $email);
        $this->db->update($this->_table);
    }

    public function changepass($post)
    {
        $this->password = password_hash($post['password'], PASSWORD_DEFAULT);
        $this->email = $this->session->userdata('reset_email');
        $this->db->set('password', $this->password);
        $this->db->where('email', $this->email);
        $this->db->update($this->_table);
    }
    public function changepassword($post)
    {
        $this->applicant_id = $this->session->userdata('applicant_id');
        $user =  $this->getData($this->applicant_id)->row();
        $currentPassword = $post['currentPassword'];
        $newPassword = $post['password'];
        $this->password = $user->password;
        $this->email = $user->email;
        if (!password_verify($currentPassword, $this->password)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
            <strong>Maaf!</strong> Kata sandi saat ini salah.</div>');
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
    public function delByEmail($email)
    {
        return $this->db->delete($this->_table, ["email" => $email]);
    }
}

/* End of file Applicant_model.php */
