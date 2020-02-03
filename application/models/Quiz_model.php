<?php

class Quiz_model extends CI_Model{
    function get_quiz($type = 'mine'){
        switch ($type){
            case 'mine':
                $userid = user_id();
                $query = $this->db->query("SELECT * FROM quiz_details WHERE user_id='{$userid}'");
                return $query->result_array();
                break;
        }
    }
}