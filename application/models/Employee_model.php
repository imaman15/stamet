<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    private $_table = "employee";
    public $emp_id;
    public $email;
    public $password;
    public $photo = "default.jpg";
    public $first_name;
    public $last_name;
    public $csidn;
    public $position_name;
    public $address;
    public $phone;
    public $level;
    public $is_active = 0;
    public $date_created;

    // start datatables
    var $column_order = array(null, 'csidn', 'fullname', 'pos_name', 'level', 'employee.date_update', null); //set column field database for datatable orderable
    var $column_search = array('csidn', 'CONCAT(employee.first_name, " ", employee.last_name)', 'pos_name', 'level', 'employee.date_update'); //set column field database for datatable searchable
    var $order = array('emp_id' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $this->db->select('employee.emp_id, employee.csidn, employee.level, employee.date_update, CONCAT(employee.first_name, " ", employee.last_name) as fullname, position.pos_name');
        $this->db->from('employee');
        $this->db->join('position', 'position.pos_id = employee.position_name');

        $user = $this->session->userdata('emp_id');
        $this->db->where('emp_id !=', $user);

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
        $this->db->from('employee');
        return $this->db->count_all_results();
    }

    public function add($pass)
    {
        $post = $this->input->post(null, TRUE);
        $this->email = htmlspecialchars($post["email"], true);
        $this->password = password_hash($pass, PASSWORD_DEFAULT);
        $this->first_name = htmlspecialchars(ucwords($post["first_name"]), true);
        $this->last_name = htmlspecialchars(ucwords($post["last_name"]), true);
        $this->csidn = $post["csidn"];
        $this->position_name = $post["position_name"];
        $this->address = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $this->phone = phoneNumber($post["phone"], true);
        $this->level = $post["level"];
        $this->is_active;
        $this->date_created = time();

        if (!empty($_FILES['photo']['name'])) {
            $upload = $this->_do_upload();
            $this->photo = $upload;
        }

        $this->db->insert($this->_table, $this);
        return $this->db->insert_id();
    }

    public function update($post, $id = NULL)
    {
        $params['email'] = htmlspecialchars($post["email"], true);
        $params['first_name'] = htmlspecialchars(ucwords($post["first_name"]), true);
        $params['last_name'] = htmlspecialchars(ucwords($post["last_name"]), true);
        $params['csidn'] = $post["csidn"];
        $params['address'] = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $params['phone'] = phoneNumber($post["phone"], true);
        if (isset($post["position_name"]) || isset($post["level"])) {
            $params['position_name'] = $post["position_name"];
            $params['level'] = $post["level"];
        }

        if (!empty($_FILES['photo']['name'])) {
            $upload = $this->_do_upload($id);
            $params["photo"] = $upload;
            //delete file
            $old_image = $this->getDataBy($post['emp_id'], 'emp_id')->row()->photo;
            if ($old_image != 'default.jpg' && $old_image) {
                unlink(FCPATH . 'assets/img/profil/' . $old_image);
            }
        }

        if (isset($post['remove_photo'])) // if remove photo checked
        {
            if (file_exists('assets/img/profil/' . $post['remove_photo']) && $post['remove_photo'])
                unlink('assets/img/profil/' . $post['remove_photo']);
            $params["photo"] = 'default.jpg';
        }

        if ($id) {
            $this->db->update($this->_table, $params, ['emp_id' => $id]);
        } else {
            $this->db->update($this->_table, $params, ['emp_id' => $post["emp_id"]]);
            return $this->db->affected_rows();
        }
    }

    public function changepass($data)
    {
        $this->password = password_hash($data['pass'], PASSWORD_DEFAULT);
        $this->email = $data['email'];
        $this->db->set('password', $this->password);
        $this->db->where('email', $this->email);
        $this->db->update($this->_table);
    }

    public function changepassword($post)
    {
        $user =  dAdmin();
        $currentPassword = $post['currentPassword'];
        $newPassword = $post['password'];
        if (!password_verify($currentPassword, $user->password)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
            <strong>Maaf!</strong> Kata sandi saat ini salah.</div>');
            redirect(UE_CHANGEPASSWORD);
        } else {
            if ($currentPassword == $newPassword) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">
                <strong>Maaf!</strong> Kata sandi baru tidak boleh sama dengan kata sandi lama.</div>');
                redirect(UE_CHANGEPASSWORD);
            } else {
                //password ok
                $password = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->set('password', $password);
                $this->db->where(array('emp_id' => $user->emp_id, 'email' => $user->email));
                $this->db->update($this->_table);
            }
        }
    }

    function get_position($id)
    {
        $query = $this->db->get_where('position', array('pos_id' => $id));
        return $query;
    }


    public function delete($data, $field)
    {
        $this->db->where($field, $data);
        $this->db->delete($this->_table);
    }

    public function getDataBy($id, $name)
    {
        $this->db->select('employee.emp_id,employee.password, employee.email, employee.photo, employee.first_name, employee.last_name, employee.csidn, employee.position_name, employee.address, employee.phone, employee.level, employee.is_active, employee.date_created, employee.date_update, position.pos_name');
        $this->db->from($this->_table);
        $this->db->join('position', 'position.pos_id = employee.position_name');
        $this->db->where([$name => $id]);
        return $this->db->get();
    }

    public function checkData($where = NULL)
    {
        return $this->db->get_where($this->_table, $where);
    }

    public function updateActivation($email)
    {
        $this->db->set('is_active', 1);
        $this->db->where('email', $email);
        $this->db->update($this->_table);
    }

    private function _do_upload($id = NULL)
    {
        $config['upload_path']          = './assets/img/profil/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) //upload and validate
        {
            if ($id != NULL) {
                $eror = $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div class="alert alert-danger animated zoomIn" role="alert">' . $eror . '</div>');
                redirect(UE_EDITPROFILE);
            } else {
                $data['inputerror'][] = 'photo';
                $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }
        }
        return $this->upload->data('file_name');
    }
}

/* End of file Employee_model.php */
