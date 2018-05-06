<?php

class Report_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all sell invoices
     * */
    function get_all_sell_invoices($customer_id, $star_date, $end_date){
        $where = '(bi.status="1" OR bi.status="0") AND bi.invoice_type=1';
        $this->db->select("bi.*, c.full_name");
        $this->db->from("invoices as bi");
        $this->db->where("bi.customer_id", $customer_id);
        $this->db->join('customers as c', 'c.id = bi.customer_id', 'left');
        //$this->db->join('products as p', 'p.id = bi.product_id', 'left');
        $this->db->where('bi.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

}