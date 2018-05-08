<?php

class Report_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all sell or purchase invoices by customer or supplier id
     * */
    function get_all_sell_or_purchase_invoices($customer_id, $invoice_type, $star_date, $end_date){
        $where = '(bi.status="1" OR bi.status="0") AND bi.invoice_type='.$invoice_type;
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
    
    /*
     * Get all sell or purchase transaction by customer or supplier id
     * */
    function get_customer_wise_transaction($customer_id, $type, $star_date, $end_date){
        if($type == 1){
            $child_account_id = 6;
        }else{
            $child_account_id = 3;
        }
        $where = '(t.status="1" OR t.status="0") AND t.child_account_id='.$child_account_id;
        $this->db->select("t.*, ca.name, c.full_name, c.employee_type");
        $this->db->from("transaction as t");
        $this->db->where("t.payment_from_or_to", $customer_id);
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
        $this->db->join('customers as c', 'c.id = t.payment_from_or_to', 'left');
        //$this->db->where("t.status",1);
        $this->db->where('t.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Get all sell or purchase invoice by product id
     * */
    function get_product_wise_invoice($product_id, $invoice_type, $star_date, $end_date){
        
        $where = '(inv.status="1" OR inv.status="0") AND inv.invoice_type='.$invoice_type;
        $this->db->select("invd.*, inv.invoice_no, inv.status, inv.invoice_type, inv.created");
        $this->db->from("invoice_details as invd");
        $this->db->where("invd.product_id", $product_id);
        $this->db->join('invoices as inv', 'inv.id = invd.invoice_id', 'left');
        //$this->db->where("t.status",1);
        $this->db->where('inv.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Get all sell or purchase invoice by product id
     * */
    function get_expense_or_income($child_account_id, $star_date, $end_date){

        //$where = 't.child_account_id='.$child_account_id;
        $this->db->select("t.*, ca.name, c.full_name, c.employee_type");
        $this->db->from("transaction as t");
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
        $this->db->join('customers as c', 'c.id = t.payment_from_or_to', 'left');
        $this->db->where('t.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where("t.status",1);
        if(is_array($child_account_id)){
             $this->db->where_in('t.child_account_id', $child_account_id); 
        }else{
            $this->db->where("t.child_account_id", $child_account_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Get Customer Collection 
     * */
    function get_customer_collection($customer_id, $invoice_type, $star_date, $end_date){

        $where = '(bi.status="1" OR bi.status="0") AND bi.invoice_type='.$invoice_type;
        $this->db->select("bi.id, bi.invoice_no, bi.customer_id, bi.total_cost, bi.invoice_type, bi.created");
        $this->db->from("invoices as bi");
        $this->db->where("bi.customer_id", $customer_id);
        //$this->db->join('products as p', 'p.id = bi.product_id', 'left');
        $this->db->where('bi.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        $invoice = $query->result();
        //echo '<pre>'; print_r($invoice);
        
        if($invoice_type == 1){
            $child_account_id = 6;
        }else{
            $child_account_id = 3;
        }
        $where = '(t.status="1" OR t.status="0") AND t.child_account_id='.$child_account_id;
        $this->db->select("t.id, t.trans_type, t.child_account_id, t.payment_from_or_to, t.amount, t.status, t.trans_date, t.created");
        $this->db->from("transaction as t");
        $this->db->where("t.payment_from_or_to", $customer_id);
        //$this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
       // $this->db->join('customers as c', 'c.id = t.payment_from_or_to', 'left');
        //$this->db->where("t.status",1);
        $this->db->where('t.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        $transaction = $query->result();
        
        
        //echo '<pre>'; print_r($transaction);
        
        $result = array_merge($invoice, $transaction);
        
        //echo '<pre>'; print_r($result);die();
        return $result;
    }

}