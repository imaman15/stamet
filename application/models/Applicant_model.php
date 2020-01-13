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

    // start datatables
    var $column_order = array(null, 'nin', 'fullname', 'email', 'phone', 'applicant.date_update', null); //set column field database for datatable orderable
    var $column_search = array('nin', 'CONCAT(applicant.first_name, " ", applicant.last_name)', 'email', 'phone', 'applicant.date_update'); //set column field database for datatable searchable
    var $order = array('applicant_id' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $this->db->select('applicant.applicant_id, applicant.nin, applicant.email, applicant.date_update, CONCAT(applicant.first_name, " ", applicant.last_name) as fullname, job_category.jobcat');
        $this->db->from('applicant');
        $this->db->join('job_category', 'job_category.jobcat_id = applicant.job_category');

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('applicant');
        return $this->db->count_all_results();
    }
    //=======================================================

    public function getDataBy($id, $name)
    {
        $this->db->select('applicant.applicant_id,applicant.password, applicant.email, applicant.photo, applicant.first_name, applicant.last_name, applicant.nin, applicant.job_category, applicant.address, applicant.phone, applicant.institute, applicant.is_active, applicant.date_created, applicant.date_update, job_category.jobcat');
        $this->db->from($this->_table);
        $this->db->join('job_category', 'job_category.jobcat_id = applicant.job_category');
        $this->db->where([$name => $id]);
        return $this->db->get();
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

    public function add($post, $pass = NULL)
    {
        $password = ($pass != NULL) ? $pass : $post["password"];
        $this->email = htmlspecialchars($post["email"], true);
        $this->password = password_hash($password, PASSWORD_DEFAULT);
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
        $session_id = $this->session->userdata('applicant_id');
        $post_id = $post["applicant_id"];
        if (isset($post_id)) {
            $this->applicant_id = $post_id;
        } else {
            $this->applicant_id = $session_id;
        };

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

        if (isset($post['remove_photo'])) // if remove photo checked
        {
            if (file_exists('assets/img/profil/' . $post['remove_photo']) && $post['remove_photo'])
                unlink('assets/img/profil/' . $post['remove_photo']);
            $params["photo"] = 'default.jpg';
        }

        if ($post["email"]) {
            $params['email'] = $post["email"];
        };

        $this->db->where(array('applicant_id' => $this->applicant_id));
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
