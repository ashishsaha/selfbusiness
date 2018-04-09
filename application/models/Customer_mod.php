<?php

class Customer_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all customer info
     * */
    function get_all_customers($condition){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("customers");
        $this->db->where($where);
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        return $query->result();
    }

    /*
     * Get all labor info
     * */
    function get_all_labors(){
        $where = '(status="1" OR status="0") AND (employee_type="1" OR employee_type="2")';
        $this->db->select("*");
        $this->db->from("customers");
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        return $query->result();
    }

    /*
     * Add customer info
     * */
    function add_customer($customer_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('customers',$customer_array);
        return $this->db->insert_id();
    }

    /*
     * Update customer info
     * */
    function update_customer($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('customers'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual customer info
     * */
    function get_customer_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("customers");
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

    /*
     * Delete customer info
     * */
    function delete_customer($customer_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$customer_id);
        $this->db->update('customers',$data);
    }

    /*
     * get the list of suppliers
     * */
    function get_all_supplier_customer($condition){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("customers");
        $this->db->where($where);
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();
    }



    /* Get all services name by corporate_account_id */
    function get_all_services_by_corporate_account_id($corporate_account_id) /*Get Service List*/
    {
        $condition = ' AND s.corporate_account_id ='.$corporate_account_id;
        $where = '(s.status="1" OR s.status="0") AND s.id !=1'.$condition;
        $this->db->select("s.id, s.name");
        $this->db->from("services s");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*  Get service info according to selected service_id */
    function get_service_by_selected_service_id($id) /*Get Individual Service Information*/
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

    /* Is service exist under this corporate account */
    function is_service_exit_by_corporate_account_id($corporate_account_id){
        $query = $this->db->query("SELECT s.id  FROM services AS s WHERE s.corporate_account_id=".$corporate_account_id);
        $num_rows = $query->num_rows();

        if($num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /* Is service description show/(not show) under this corporate account */
    function is_service_show($corporate_account_id){
        $query = $this->db->query("SELECT s.is_show_service_description  FROM settings AS s WHERE s.corporate_account_id=".$corporate_account_id);
        $result = $query->row();
        $resultData = $result->is_show_service_description;
        if ($resultData == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /* what is the service selection type define
    0: None 1: Single 2: Multiple
     */
    function get_service_selection_type($corporate_account_id){
        $query = $this->db->query("SELECT s.service_selection_type  FROM settings AS s WHERE s.corporate_account_id=".$corporate_account_id);
        $result = $query->row();
        return $result->service_selection_type;
    }

    /* what is the staff selection type define
    0: None 1: Single
    */
    function get_staff_selection_type($corporate_account_id){
        $query = $this->db->query("SELECT s.staff_selection_type  FROM settings AS s WHERE s.corporate_account_id=".$corporate_account_id);
        $result = $query->row();
        return $result->staff_selection_type;
    }

    /* Is price ragne show/(not show) under this corporate account */
    function is_price_range_show($corporate_account_id){
        $query = $this->db->query("SELECT s.is_show_price_range  FROM settings AS s WHERE s.corporate_account_id=".$corporate_account_id);
        $result = $query->row();
        $resultData = $result->is_show_price_range;
        if ($resultData == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /* Select staff according to services */
    function staff_details($condition)
    {
        $this->db->select("u.id, u.contact_no, u.corporate_account_id, u.first_name, u.last_name, u.profile_image, u.salutation, u.username, u.status");
        $this->db->from("users as u");
        $this->db->join('staff_services as s', 'u.id = s.user_id', 'left');
        $this->db->where($condition);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if($num_rows1 === 1) {
            $row1 = $query1->row();
            return $row1;
        } else {
            return false;
        }
    }



}