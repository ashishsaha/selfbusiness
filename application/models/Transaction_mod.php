<?php

class Transaction_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
     * Get all transaction
     * */
    function get_all_transaction($condition){
        //$where = '(bi.status="1" OR bi.status="0")';
        $this->db->select("t.*, ca.name");
        $this->db->from("transaction as t");
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
        $this->db->where("t.status",1);
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Get all transaction
     * */
    function get_all_transaction_for_employee($condition){
        //$where = '(bi.status="1" OR bi.status="0")';
        $this->db->select("t.*, ca.name, c.full_name, c.employee_type");
        $this->db->from("transaction as t");
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
        $this->db->join('customers as c', 'c.id = t.payment_from_or_to', 'left');
        $this->db->where("t.status",1);
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Add buy invoices info
     * */
    function add_transaction($transaction_array)
    {
        // Insert the new icon array into the rate table
        $this->db->insert('transaction',$transaction_array);
        return $this->db->insert_id();
    }

    /*
     * Get individual transaction info
     * */
    function get_transaction_info_by_id($id)
    {
        $this->db->select("*");
        $this->db->from("transaction");
        $this->db->where('id',$id);
        $query1 = $this->db->get();
        return $query1->row();
    }

    /*
     * Get individual transaction info
     * */
    function update_transaction($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('transaction'), $data, $where);
        $query = $this->db->query($str);
    }
    
    /*
     * Get paid amount by invoice id
     * */
    function get_paid_amount_by_invoice_id($id)
    {
        $this->db->select("id, ref_invoice_no, amount");
        $this->db->from("transaction");
        $this->db->where('ref_invoice_no',$id);
        $query1 = $this->db->get();
        
        return $query1->row();
    }


    /*
     * Delete transaction info
     * */
    function delete_transaction($transaction_id)
    {
        $data=array('status'=>'-1');
        $this->db->where('id',$transaction_id);
        $this->db->update('transaction',$data);
    }



    /*
     * Get all sell or purchase invoice by product id
     * */
    function get_all_type_of_expense(){
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $this->db->select("SUM(t.amount) as total_cost, ca.name");
        $this->db->from("transaction as t");
        $this->db->join('child_accounts as ca', 'ca.id = t.child_account_id', 'left');
        $this->db->where("DATE(t.created)", $curr_date);
        $this->db->where("t.status",1);
        $this->db->group_by('t.child_account_id');
        $this->db->order_by('ca.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

}