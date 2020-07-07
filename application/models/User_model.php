<?php

class User_model extends CI_Model{
    function insert($arr){
        $this->db->insert('users',$arr);
        return $this->db->insert_id();
    }

    function update_user($data,$id = null){
        $uid = ($id) ? $id : user_id();
        $this->db->where('id', $uid);
        $this->db->update('users', $data);
    }

    function delete_user($id){
        $this->db->delete('users', array('id' => $id));
        $this->db->delete('quiz_result_overall', array('user_id' => $id));
        $this->db->delete('quiz_result_by_question', array('user_id' => $id));
        $this->db->delete('quiz_friend_answers', array('user_id' => $id));
        $this->db->delete('quiz_details', array('user_id' => $id));

    }

    function find_user($uid){
        $this->db->or_where('id', $uid);
        $this->db->or_where('username', $uid);
        $this->db->or_where('email_address', $uid);
        $query = $this->db->get('users');
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