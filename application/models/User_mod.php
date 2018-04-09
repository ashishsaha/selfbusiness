<?php

class User_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* Check is any corporate super admin exist */
    function is_corporate_super_admin_exist($corporate_account_id){
        $query = $this->db->query("SELECT ur.role_id, u.id
                                FROM users AS u
                                LEFT JOIN user_roles AS ur ON ur.user_id = u.id
                                WHERE ur.role_id = 2 AND u.corporate_account_id=".$corporate_account_id);
        $row = $query->row();
        $num_rows = $query->num_rows();
        if ($num_rows === 1) {
            return $row;
        } else {
            return false;
        }
    }

    /**
    This function is using for check login
    */
    function get_user($username, $password)
    {
        /*For Admin User*/
        $where = '(username="' . $username . '" AND password="' . $password . '")';
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            return $row1;
        } else {
            return false;
        }
    }

    /**
    This function is using for getting user role
     */
    function get_role_by_user_id($userId){
        $query = $this->db->query("SELECT r.id, r.name
                                    FROM user_roles AS ur
                                    LEFT JOIN roles AS r ON ur.role_id = r.id
                                    WHERE ur.user_id = ".$userId);
        $row = $query->row();
        $num_rows = $query->num_rows();
        if ($num_rows === 1) {
            return $row;
        } else {
            return false;
        }
    }

    /**
    LIST for ROle
     */
     function get_all_role(){
         $where = '(status="1" OR status="0")';
         $this->db->select("*");
         $this->db->from("roles");
         $this->db->where($where);
         $query = $this->db->get();
         return $query->result();
     }

    /*
     * SELECT INDIVIDUAL ROLE INFO
     * */
    function get_role_by_id($id){
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("roles");
        $this->db->where($where);
        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if($num_rows === 1)
        {
            $row = $query->row();
            // Return the rate id.
            return $row;
        }else {
            return false;
        }
    }

    /**
     ADD ROLE
     */
    function add_role($role_array) /*Add New User*/
    {
        // Insert the new user array into the user table
        $this->db->insert('roles', $role_array);
        return $this->db->insert_id();
    }

    /**
     UPDATE ROLE
     */
    function update_role($data, $role_id)
    {
        $where = "id=" . $role_id;
        $str = $this->db->update_string($this->db->dbprefix('roles'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * DELETE ROLE
     * */
    function delete_role($role_id)
    {
        $data = array('status' => '-1');
        $this->db->where('id', $role_id);
        $this->db->update('roles', $data);
    }

    /*Get User List*/
    function get_all_user()
    {

        $query = $this->db->query("SELECT u.id, u.salutation, u.first_name, u.last_name, u.username, u.contact_no, u.profile_image, u.status, r.name AS role_type
                                    FROM users AS u
                                    LEFT JOIN user_roles AS ur ON ur.user_id = u.id
                                    LEFT JOIN roles AS r ON r.id = ur.role_id
                                    WHERE (u.status= 1 OR u.status=0) AND u.id !=1");
        //echo $this->db->last_query(); exit();
        return $query->result();

    }

    /* GET a specific user info*/
    function get_user_by_id($id)
    {
        $where = '(id="' . $id . '")';
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where($where);
        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if ($num_rows === 1) {
            $row = $query->row();
            // Return the user id.
            return $row;
        } else {
            return false;
        }
    }

    /* GET ROLe  id by user id */
    function get_role_id_by_user_id($user_id){
        $where = '(user_id="' . $user_id . '")';
        $this->db->select("*");
        $this->db->from("user_roles");
        $this->db->where($where);
        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if ($num_rows === 1) {
            $row = $query->row();
            // Return the user id.
            return $row;
        } else {
            return false;
        }
    }

    /*Add New User*/
    function add_user($user_array)
    {
        // Insert the new user array into the user table
        $this->db->insert('users', $user_array);
        return $this->db->insert_id();
    }

    /*Add New User*/
    function add_user_role($user_array)
    {
        // Insert the new user array into the user table
        $this->db->insert('user_roles', $user_array);
        return $this->db->insert_id();
    }

    /*Update User*/
    function update($data, $id)
    {
        $where = "id=" . $id;
        $str = $this->db->update_string($this->db->dbprefix('users'), $data, $where);
        $query = $this->db->query($str);
    }

    /*Update User role*/
    function update_user_role($data, $id)
    {
        $where = "user_id=" . $id;
        $str = $this->db->update_string($this->db->dbprefix('user_roles'), $data, $where);
        $query = $this->db->query($str);
    }

    /* Delete User*/
    function delete_user($user_id) /*Delete User*/
    {
        $data = array('status' => '-1');
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    /* Check any existing user   */
    function unique_username($condition){

        $this->db->select("u.id");
        $this->db->from("users as u");
        $this->db->join('corporate_accounts as ca', 'u.corporate_account_id = ca.id', 'left');
        $this->db->where($condition);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows === 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
    This function is using for check login
     */
    function get_user_by_username($username)
    {
        /*For Admin User*/
        $where = '(username="' . $username . '")';
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            return $row1;
        } else {
            return false;
        }
    }

    function reset_password_activation_system($id, $hash) /*For Forgot Password checking activation system*/
    {
        /*For Admin User*/
        $where = '(id="' . $id . '" AND activation_hash="' . $hash . '")';
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            // Return the user id.
            return $row1;
        } else {
            return false;
        }
    }


    //===================== ======================== ======================================

    function get_authenticate_user($email_id) /*For Forgot Password system*/
    {
        /*For Admin User*/
        $where = '(email_id="' . $email_id . '")';
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        /*For Staff*/
        $where = '(email_id="' . $email_id . '")';
        $this->db->select("*");
        $this->db->from("staff");
        $this->db->where($where);
        $query2 = $this->db->get();
        $num_rows2 = $query2->num_rows();

        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            // Return the user id.
            return $row1;
        } elseif ($num_rows2 === 1) {
            $row2 = $query2->row();
            // Return the user id.
            return $row2;
        } else {
            return false;
        }
    }

    function add_user_permission($user_permission_array) /*Add New User with Permission*/
    {
        $this->db->insert('user_roll', $user_permission_array);
        return $this->db->insert_id();
    }

    function get_user_by_id_permission($id) /*Get Individual User Information*/
    {
        $where = '(user_id="' . $id . '")';
        $this->db->select("*");
        $this->db->from("user_roll");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();


        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            // Return the user id.
            return $row1;
        } else {
            return false;
        }
    }

    function update_user_permission($data, $id) /*Update User Permission*/
    {
        $where = "user_id=" . $id;
        $str = $this->db->update_string($this->db->dbprefix('user_roll'), $data, $where);
        $query = $this->db->query($str);
    }

    function check_loggedin() /*Login Check*/
    {
        //return TRUE;
        if ($this->session->userdata('bt_session_logged_in')) {
            return TRUE;
        } else {
            $this->session->set_flashdata('err_msgs', 'Please Login');
            redirect(base_url() . 'login', 'location', '301');
            die;
        }
    }

    function update_user_staff($data, $id, $type) /*Update Admin User or Staff for Forgot Password System with */
    {
        if ($type == 'admin') {
            $where = "id=" . $id;
            $str = $this->db->update_string($this->db->dbprefix('user'), $data, $where);
            $query = $this->db->query($str);
        } else {
            $where = "id=" . $id;
            $str = $this->db->update_string($this->db->dbprefix('staff'), $data, $where);
            $query = $this->db->query($str);
        }
    }

    function reset_password_checking($id, $email_id) /*For Reset Password checking Email id and user id*/
    {
        /*For Admin User*/
        $where = '(id="' . $id . '" AND email_id="' . $email_id . '")';
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        /*For Staff*/
        $where = '(id="' . $id . '" AND email_id="' . $email_id . '")';
        $this->db->select("*");
        $this->db->from("staff");
        $this->db->where($where);
        $query2 = $this->db->get();
        $num_rows2 = $query2->num_rows();

        if ($num_rows1 === 1) {
            $row1 = $query1->row();
            // Return the user id.
            return $row1;
        } elseif ($num_rows2 === 1) {
            $row2 = $query2->row();
            // Return the user id.
            return $row2;
        } else {
            return false;
        }
    }

    function update_user_staff_password($data, $id, $email_id, $type) /*Update password for Admin User or Staff */
    {
        if ($type == 'admin') {
            $where = '(id="' . $id . '" AND email_id="' . $email_id . '")';
            $str = $this->db->update_string($this->db->dbprefix('user'), $data, $where);
            $query = $this->db->query($str);
        } else {
            $where = '(id="' . $id . '" AND email_id="' . $email_id . '")';
            $str = $this->db->update_string($this->db->dbprefix('staff'), $data, $where);
            $query = $this->db->query($str);
        }
    }

}