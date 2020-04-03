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

    function add_quiz_details($arr){
        $this->db->insert('quiz_details',$arr);
        return $this->db->insert_id();
    }

    function add_question($arr){
        $this->db->insert('quiz_questions',$arr);
        return $this->db->insert_id();
    }

    function add_answer($arr){
        $this->db->insert('quiz_answers',$arr);
        return $this->db->insert_id();
    }

    function get($id){
        $query = $this->db->query("SELECT * FROM quiz_details WHERE id='{$id}' OR slug='{$id}'");
        $r = $query->result_array();
        if($r){
            return $r[0];
        }
        return array();
    }

    function get_questions($quiz_id){
        $query = $this->db->query("SELECT * FROM quiz_questions WHERE quiz_id='{$quiz_id}'");
        return $query->result_array();
    }

    function get_answers($qid){
        $query = $this->db->query("SELECT * FROM quiz_answers WHERE question_id='{$qid}'");
        return $query->result_array();
    }

    function save_friends_answers($arr){
        $this->db->insert('quiz_friend_answers',$arr);
        return $this->db->insert_id();
    }

    function quiz_result_by_question($arr){
        $this->db->insert('quiz_result_by_question',$arr);
        return $this->db->insert_id();
    }

    function quiz_result_overall($arr){
        $this->db->insert('quiz_result_overall',$arr);
        return $this->db->insert_id();
    }
}