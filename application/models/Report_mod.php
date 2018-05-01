<?php

class Report_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all parent info
     * */
    function get_all_parent_accounts(){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("parent_accounts");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add parent account info
     * */
    function add_parent_account($parent_account_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('parent_accounts',$parent_account_array);
        return $this->db->insert_id();
    }

    /*
     * Update parent account info
     * */
    function update_parent_account($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('parent_accounts'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual parent account info
     * */
    function get_parent_account_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("parent_accounts");
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
     * Delete parent account info
     * */
    function delete_parent_account($parent_account_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$parent_account_id);
        $this->db->update('parent_accounts',$data);
    }

    /*
     * Get all child account info
     * */
    function get_all_child_accounts(){
        $where = '(c.status="1" OR c.status="0")';
        $this->db->select("c.*, p.id as parent_id, p.name as parent_name");
        $this->db->from("child_accounts as c");
        $this->db->join('parent_accounts as p', 'p.id = c.parent_account_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add child account info
     * */
    function add_child_account($child_account_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('child_accounts',$child_account_array);
        return $this->db->insert_id();
    }

    /*
     * Update child account info
     * */
    function update_child_account($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('child_accounts'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual child account info
     * */
    function get_child_account_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("child_accounts");
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
     * Delete child account info
     * */
    function delete_child_account($child_account_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$child_account_id);
        $this->db->update('child_accounts',$data);
    }

}