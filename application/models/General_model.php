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

    function configs(){
        $configs = array();
        $query = $this->db->query("SELECT * FROM settings");
        foreach ($query->result() as $row)
        {
            $configs[$row->val] = $row->value;
        }
        return $configs;
    }

    function config($key,$default){
        $this->db->where('val',$key);
        if($this->db->get('settings')->num_rows()){
            $results = $this->db->result();
            return $results->val;
        }else{
            //insert new
            $this->db->insert('settings',array('val'=>$key,'value'=>$default));
            return $default;
        }
    }
}