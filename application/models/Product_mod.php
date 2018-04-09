<?php

class Product_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all products info
     * */
    function get_all_products(){
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add products info
     * */
    function add_product($product_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('products',$product_array);
        return $this->db->insert_id();
    }

    /*
     * Update product info
     * */
    function update_product($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('products'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual product info
     * */
    function get_product_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("products");
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
     * Delete product info
     * */
    function delete_product($product_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$product_id);
        $this->db->update('products',$data);
    }

}