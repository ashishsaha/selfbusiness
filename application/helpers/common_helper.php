<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_brand_name')){
    function get_brand_name($brand_id){
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('name');
        $ci->db->from("brands");
        $ci->db->where("id", $brand_id);
        $query = $ci->db->get();
        $brand_data = $query->row();
        return $brand_data->name;
    }
}