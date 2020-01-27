<?php

class General_model extends CI_Model{
    function username_exists($str){
        $this->db->where('username', $str);
        return $this->db->get('users')->num_rows();
    }

    function email_exists($email){
        $this->db->where('email_address',$email);
        return $this->db->get('users')->num_rows();
    }
}