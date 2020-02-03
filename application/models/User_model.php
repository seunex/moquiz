<?php

class User_model extends CI_Model{
    function insert($arr){
        $this->db->insert('users',$arr);
        return $this->db->insert_id();
    }

    function find_user($uid){
        $query = $this->db->get_where('users', array('id' => $uid), 1, 0);
        return $query->result_array();
    }
}