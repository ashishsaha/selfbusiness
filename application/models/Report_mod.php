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
        $this->db->select("invd.*, inv.invoice_no, inv.status, inv.invoice_type, inv.created, p.name");
        $this->db->from("invoice_details as invd");
        $this->db->where("invd.product_id", $product_id);
        $this->db->join('invoices as inv', 'inv.id = invd.invoice_id', 'left');
        $this->db->join('products as p', 'p.id = invd.product_id', 'left');
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
        $this->db->select("bi.id, bi.invoice_no, bi.customer_id, bi.total_cost, bi.invoice_type, bi.created, c.full_name");
        $this->db->from("invoices as bi");
        $this->db->where("bi.customer_id", $customer_id);
        $this->db->join('customers as c', 'c.id = bi.customer_id', 'left');
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
    
    /*
     * Get Customer Collection 
     * */
    function get_profit($star_date, $end_date){
        
        $where = '(t.status="1" OR t.status="0")';
        $this->db->select("t.id, t.trans_type, t.child_account_id, t.payment_from_or_to, t.amount, t.status, t.trans_date, t.created, ca.parent_account_id, ca.name");
        $this->db->from("transaction as t");
       // $this->db->where("t.payment_from_or_to", $customer_id);
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
       // $this->db->join('customers as c', 'c.id = t.payment_from_or_to', 'left');
        //$this->db->where("t.status",1);
        $this->db->where('t.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Get all brands of product by product_id
     * */
    function get_all_brands($product_id){
        // Get brand ids from product table
        $where = '(id="'.$product_id.'")';
        $this->db->select("id, brand_id");
        $this->db->from("products");
        $this->db->where($where);
        $query1 = $this->db->get();
        $num_rows1 = $query1->num_rows();

        if($num_rows1 === 1) {
            $product = $query1->row();
        } else {
            return false;
        }
        $brand_ids = json_decode($product->brand_id);
        
        // Get brand list of a product
        $where = '(status="1" OR status="0")';
        $this->db->select("*");
        $this->db->from("brands");
        $this->db->where_in('id', $brand_ids);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Get Stock Information
     * */
    function get_stock_info($product_id, $brand_id, $star_date, $end_date){

        $where = '(inv.status="1" OR inv.status="0")';
        $this->db->select("invd.*, inv.invoice_type, inv.status, inv.created, p.name as product_name, b.name, SUM(total_bosta) as total_qty");
        $this->db->from("invoice_details as invd");
        if($product_id != 'all'){
            $this->db->where("invd.product_id", $product_id);
        }
        if($brand_id != 'all'){
            $this->db->where("invd.brand_id", $brand_id);
        }
        $this->db->join('invoices as inv', 'inv.id = invd.invoice_id', 'left');
        $this->db->join('products as p', 'p.id = invd.product_id', 'left');
        $this->db->join('brands as b', 'b.id = invd.brand_id', 'left');
        $this->db->where('inv.created BETWEEN "'. date('Y-m-d', strtotime($star_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        $this->db->where($where);
        $this->db->group_by('invd.product_id, invd.brand_id, invd.bosta_per_kg, inv.invoice_type');
        $this->db->order_by('invd.product_id', 'asc');
        $query = $this->db->get();
        $result =  $query->result();
        //echo '<pre>'; print_r($result);//die();
        
        $data = array();
        $i = 1;
        $product = '';
        $bosta_per_kg = '';
        foreach($result as $val){
            
            if($product != $val->product_id){
                $product = $val->product_id;
                $bosta_per_kg = '';
                $i = 1;
                
            }
            
            $data[$val->product_id]['product_rowspan'] = $i;
            $data[$val->product_id]['product_name'] = $val->product_name;
            $data[$val->product_id]['brands'][$val->brand_id]['brand_name'] = $val->name;
            $data[$val->product_id]['brands'][$val->brand_id]['bosta'][$val->bosta_per_kg]['bosta_per_kg'] = $val->bosta_per_kg;
            if($val->invoice_type == 1){
                $data[$val->product_id]['brands'][$val->brand_id]['bosta'][$val->bosta_per_kg]['total_sold'] = $val->total_qty;
            }else{
                $data[$val->product_id]['brands'][$val->brand_id]['bosta'][$val->bosta_per_kg]['total_purchased'] = $val->total_qty;
            }
            if(($product == $val->product_id) && ($bosta_per_kg != $val->bosta_per_kg)){
                $i++;
            }
            $bosta_per_kg = $val->bosta_per_kg;
        }//echo $i;echo '<pre>'; print_r($data);die();
        return $data;

    }
    
    

}