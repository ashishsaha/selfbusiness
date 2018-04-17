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
    function delete_product($product_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$product_id);
        $this->db->update('invoices',$data);
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
     * Set invoice number
     * */
    function set_invoice_no($invoice_type, $is_save = false, $existing_sell_invoice_no = 0){
        if($invoice_type == 0){
            $field_name = "purchase_invoice_no";
        }else{
            $field_name = "sell_invoice_no";
        }

        if($is_save == true){
            $where = "id=1";
            $data[$field_name] = $existing_sell_invoice_no;
            $str = $this->db->update_string($this->db->dbprefix('company_setup'), $data, $where);
            $query = $this->db->query($str);
        }else{
            $this->db->select($field_name);
            $this->db->from("company_setup");
            $query1 = $this->db->get();

            $row1 = $query1->row();
            if($invoice_type == 0){
                $invoice_no = $row1->purchase_invoice_no;
            }else{
                $invoice_no = $row1->sell_invoice_no;
            }

            if($invoice_no == 0){
                $invoice_no = 1;
            }else{
                $invoice_no = $invoice_no+1;
            }
            return $invoice_no;
        }
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

}