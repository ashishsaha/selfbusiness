<?php

class Staff_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* Add Staff Service */
    function add_staff_service($staff_service_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('staff_services',$staff_service_array);
        return $this->db->insert_id();
    }

    /* Delete Staff Service */
    function delete_staff_service($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->delete('staff_services');
    }

    /* Add Staff Settings */
    function add_staff_setting($staff_setting_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('staff_settings',$staff_setting_array);
        return $this->db->insert_id();
    }

    /* Update Staff Settings*/
    function update_staff_setting($data, $user_id){
        $where = "user_id=".$user_id;
        $str = $this->db->update_string($this->db->dbprefix('staff_settings'), $data, $where);
        $query = $this->db->query($str);
    }

    /* Get Staff Settings */
    function get_staff_settings_by_user_id($user_id){
        $where = '(user_id="'.$user_id.'")';
        $this->db->select("*");
        $this->db->from("staff_settings");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if($num_rows1 === 1) {
            $row1 = $query1->row();
            return $row1;
        } else {
            return false;
        }
    }

    /*  Get Staff Services */
    function get_staff_services_by_user_id($user_id){

        $where = '(user_id="'.$user_id.'")';
        $this->db->select("*");
        $this->db->from("staff_services");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }






    function get_all_staff_services($corporate_account_id) /*Get Service List*/
    {
        $condition = '';
        if ($corporate_account_id != 1){  $condition .= 'AND s.corporate_account_id ='.$corporate_account_id; }

        $where = '(s.status="1" OR s.status="0")'.$condition;
        $this->db->select("s.id, s.name,  s.service_image,  s.min_price,  s.max_price,  s.duration,  s.staff_selection_type,  s.status, ca.name as corporate_account_name, ca.corporate_email");
        $this->db->from("services s");
        $this->db->join("corporate_accounts ca", 'ca.id = s.corporate_account_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function get_service_by_id($id) /*Get Individual Service Information*/
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("services");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if($num_rows1 === 1) {
            $row1 = $query1->row();
            return $row1;
        } else {
            return false;
        }
    }

    function update($data,$id) /*Update Service*/
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('services'), $data, $where);
        $query = $this->db->query($str);
    }

    function delete_service($service_id) /*Delete Service*/
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$service_id);
        $this->db->update('services',$data);
    }

}