<?php

class Register_model extends CI_Model{
    function insert($arr){
        $this->db->insert('users',$arr);
        return $this->db->insert_id();
    }
}