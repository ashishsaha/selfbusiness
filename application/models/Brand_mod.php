<?php

class Brand_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all brands info
     * */
    function get_all_brands(){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("brands");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add brand info
     * */
    function add_brand($brand_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('brands',$brand_array);
        return $this->db->insert_id();
    }

    /*
     * Update brand info
     * */
    function update_brand($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('brands'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual brand info
     * */
    function get_brand_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("brands");
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
     * Delete brand info
     * */
    function delete_brand($brand_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$brand_id);
        $this->db->update('brands',$data);
    }

}