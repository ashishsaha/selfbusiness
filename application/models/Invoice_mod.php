<?php

class Invoice_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all buy invoices
     * */
    function get_all_buy_invoices(){
        $where = '(bi.status="1" OR bi.status="0") AND bi.invoice_type=0';
        $this->db->select("bi.*, c.full_name");
        $this->db->from("invoices as bi");
        $this->db->join('customers as c', 'c.id = bi.customer_id', 'left');
        //$this->db->join('products as p', 'p.id = bi.product_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Get all sell invoices
     * */
    function get_all_sell_invoices(){
        $where = '(bi.status="1" OR bi.status="0") AND bi.invoice_type=1';
        $this->db->select("bi.*, c.full_name");
        $this->db->from("invoices as bi");
        $this->db->join('customers as c', 'c.id = bi.customer_id', 'left');
        //$this->db->join('products as p', 'p.id = bi.product_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add buy invoices info
     * */
    function add_invoice($buy_invoices_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('invoices',$buy_invoices_array);
        return $this->db->insert_id();
    }

    /*
     * Add  invoices detail info
     * */
    function add_invoice_detail($invoices_detail_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('invoice_details',$invoices_detail_array);
        return $this->db->insert_id();
    }

    /*
     * Update invoices info
     * */
    function update_invoice($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('invoices'), $data, $where);
        $query = $this->db->query($str);
    }

    /*
     * Get individual buy invoices info
     * */
    function get_invoice_by_id($id)
    {
        $where = '(id="'.$id.'")';
        $this->db->select("*");
        $this->db->from("invoices");
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
     * Delete buy invoices info
     * */
    function delete_product($product_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$product_id);
        $this->db->update('invoices',$data);
    }

}