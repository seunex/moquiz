<?php

class User_model extends CI_Model{
    function insert($arr){
        $this->db->insert('users',$arr);
        return $this->db->insert_id();
    }

    function find_user($uid){
        $query = $this->db->get_where('users', array('id' => $uid), 1, 0);
        if($result = $query->result_array()){
            return $result[0];
        }
        return array();
    }

    function login_user($username,$password){
        if($username == '' || $password == '') return false;
        $query = $this->db->query("SELECT * FROM users WHERE username='{$username}' OR email_address='{$username}'");
        if($result = $query->result_array()){
            $user = $result[0];
            if($user['password'] === md5($password)){
                return $user;
            }
        };
        return false;
    }
}