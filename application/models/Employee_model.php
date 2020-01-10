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
    public $is_active = 1;
    public $date_created;

    // start datatables
    var $column_order = array(null, 'csidn', 'fullname', 'pos_name', 'level', 'employee.date_update', null); //set column field database for datatable orderable
    var $column_search = array('csidn', 'CONCAT(employee.first_name, " ", employee.last_name)', 'pos_name', 'level', 'employee.date_update'); //set column field database for datatable searchable
    var $order = array('emp_id' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $this->db->select('employee.*, CONCAT(employee.first_name, " ", employee.last_name) as fullname, position.pos_name');
        $this->db->from('employee');
        $this->db->join('position', 'employee.position_name = position.pos_id');

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

    public function add($post)
    {
        $pass = get_random_password(6, 8, true, true, false);
        $this->email = htmlspecialchars($post["email"], true);
        $this->password = password_hash('Admin0!', PASSWORD_DEFAULT);
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

    public function update($post)
    {
        $params['email'] = htmlspecialchars($post["email"], true);
        $params['first_name'] = htmlspecialchars(ucwords($post["first_name"]), true);
        $params['last_name'] = htmlspecialchars(ucwords($post["last_name"]), true);
        $params['csidn'] = $post["csidn"];
        $params['position_name'] = $post["position_name"];
        $params['address'] = $post["address"] != "" ? htmlspecialchars($post["address"], true) : null;
        $params['phone'] = phoneNumber($post["phone"], true);
        $params['level'] = $post["level"];

        if (!empty($_FILES['photo']['name'])) {
            $upload = $this->_do_upload();
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

        $this->db->update($this->_table, $params, ['emp_id' => $post["emp_id"]]);
        return $this->db->affected_rows();
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

    public function getDataBy($email, $name)
    {
        return $this->db->get_where($this->_table, [$name => $email]);
    }

    public function checkData($where = NULL)
    {
        return $this->db->get_where($this->_table, $where);
    }

    private function _do_upload()
    {
        $config['upload_path']          = './assets/img/profil/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }
}

/* End of file Employee_model.php */
