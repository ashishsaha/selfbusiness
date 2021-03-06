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
     * Get individual details by invoices id
     * */
    function get_invoice_details_by_invoice_id($invoice_id)
    {
        $where = '(invoice_id="'.$invoice_id.'")';
        $this->db->select("*");
        $this->db->from("invoice_details");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Delete buy invoices info
     * */
    function delete_invoice($invoice_id)
    {
        $sql = "DELETE inv, invd FROM invoices as inv INNER JOIN invoice_details as invd ON inv.id = invd.invoice_id WHERE inv.id = ?";
        $this->db->query($sql, array($invoice_id));
    }

    /*
     * Delete invoices details data
     * */
    function delete_invoice_details($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_details');
    }


    public function invoice_no_generator($invoice_type = 0) // 0-purchase, 1-sells
    {
        // Get the company setting info
        $this->db->select("purchase_invoice_prefix,sell_invoice_prefix");
        $this->db->from("company_setup");
        $this->db->where("id", 1);
        $query = $this->db->get();
        $result = $query->row();

        if($invoice_type == 0){
            $order_default_prefix = $result->purchase_invoice_prefix;
        }else{
            $order_default_prefix = $result->sell_invoice_prefix;
        }

        // Now get the last invoice info
        $this->db->select('invoice_no');
        $this->db->like('invoice_no', $order_default_prefix);
        $this->db->from('invoices');
        $this->db->where('invoice_type', $invoice_type);
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if ($num_rows > 0) {
            $row = $query->row();
            $invoice_no = $row->invoice_no;
            $str_to_arr = explode($order_default_prefix, $invoice_no);
            $only_number_val = $str_to_arr[1];
            $only_number_val = $only_number_val + 1;
            $length_of_total_number = strlen($str_to_arr[1]);
            $generated_number = str_pad($only_number_val,$length_of_total_number,"0",STR_PAD_LEFT);
        } else {
            $generated_number=  "000001";
        }

        return $order_default_prefix.$generated_number;
    }
    
    /*
     * Get individual buy invoices info
     * */
    function get_invoice($id)
    {
        $where = '(inv.id="'.$id.'")';
        $this->db->select("inv.id, inv.invoice_no, inv.customer_id, inv.total_cost, inv.created, c.id, c.full_name, c.contact_number, c.address");
        $this->db->from("invoices as inv");
        $this->db->join('customers as c', 'c.id = inv.customer_id', 'left');
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
     * Get individual details
     * */
    function get_invoice_details($invoice_id)
    {
        $where = '(invoice_id="'.$invoice_id.'")';
        $this->db->select("invd.*, p.name, b.name as brand_name");
        $this->db->from("invoice_details as invd");
        $this->db->join('products as p', 'p.id = invd.product_id', 'left');
        $this->db->join('brands as b', 'b.id = invd.brand_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * get the list of invoice
     * */
    function get_invoice_list($invoice_type){
        $where = "invoice_type=".$invoice_type;
        $this->db->select("id, invoice_no");
        $this->db->limit(10);
        $this->db->from("invoices");
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * get available quantity by product_id, brand_id & bosta_per_kg
     * */
    function get_available_quantity($product_id, $brand_id , $bosta_per_kg){
        $where = '(inv.status="1" OR inv.status="0")';
        $this->db->select("invd.*, inv.invoice_type, inv.status, SUM(invd.total_bosta) as total_qty");
        $this->db->from("invoice_details as invd");
        $this->db->where("invd.product_id", $product_id);
        $this->db->where("invd.brand_id", $brand_id);
        $this->db->where("invd.bosta_per_kg", $bosta_per_kg);
        $this->db->join('invoices as inv', 'inv.id = invd.invoice_id', 'left');
        $this->db->where($where);
        $this->db->group_by('inv.invoice_type');
        $this->db->order_by('inv.invoice_type', 'asc');
        $query = $this->db->get();
        return  $query->result();
    }

    function today_total_invoice($invoice_type){

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $where = '(status="1" OR status="0")';
        $this->db->select("SUM(total_cost) as total_cost");
        $this->db->from("invoices");
        $this->db->where($where);
        $this->db->where("invoice_type", $invoice_type);
        $this->db->where("DATE(created)", $curr_date);
        $query = $this->db->get();
        return $query->result();
    }



    /*total donate according to campaign */
    public function raised_amount_info($invoice_type){

        $where = '(status="1" OR status="0")';
        $this->db->select('MONTH(created) AS calender_month, SUM(total_cost) AS raised_purchase_cost');
        $this->db->from('invoices');
        $this->db->where("invoice_type", $invoice_type);
        $this->db->group_by('MONTH(created)');
        $query=$this->db->get();
        return $query->result();
    }

}