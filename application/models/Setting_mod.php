<?php

class Setting_mod extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* Get Setting color - template */
    function get_setting_by_id($id) /*Get Individual Staff Service Information*/
    {
        $where = '(id="' . $id . '")';
        $this->db->select("*");
        $this->db->from("company_setup");
        $this->db->where($where);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $row = $query->result();
            // Return the user id.
            return $row;
        } else {
            return false;
        }
    }


    /*
     * Update customer info
     * */
    function update_companysetup($data,$id)
    {
        $where = "id=".$id;
        $str = $this->db->update_string($this->db->dbprefix('company_setup'), $data, $where);
        $query = $this->db->query($str);
    }

}