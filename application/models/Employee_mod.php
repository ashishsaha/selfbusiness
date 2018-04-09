<?php

class Employee_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all employees info
     * */
    function get_all_employees(){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("employees");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add employees info
     * */
    function add_employee($employee_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('employees',$employee_array);
        return $this->db->insert_id();
    }

    /*
     * Update employees info
     * */
    function update_employee($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('employees'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual employees info
     * */
    function get_employee_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("employees");
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
    function delete_employee($employee_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$employee_id);
        $this->db->update('employees',$data);
    }
}