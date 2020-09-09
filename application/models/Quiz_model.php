<?php

class Quiz_model extends CI_Model
{

    function delete_quiz($quiz_id)
    {
        $this->db->delete('quiz_details', array('id' => $quiz_id));
    }

    function delete_answers($quiz_id)
    {
        $this->db->delete('quiz_answers', array('quiz_id' => $quiz_id));
    }

    function delete_questions($quiz_id)
    {
        $this->db->delete('quiz_questions', array('quiz_id' => $quiz_id));
        $this->db->delete('quiz_result_by_question', array('quiz_id' => $quiz_id));
    }

    function delete_results($quiz_id)
    {
        $this->db->delete('quiz_result_overall', array('quiz_id' => $quiz_id));
        $this->db->delete('quiz_results', array('quiz_id' => $quiz_id));
    }

    function get_participants($quiz_id, $type)
    {
        $query = $this->db->select('*')
            ->from('quiz_result_overall')
            ->where('quiz_id', $quiz_id)
            ->get();
        if ($type == 'count') {
            return $query->num_rows();
        }
        return $query->result_array();
    }

    function quiz_count_questions($quiz_id)
    {
        $query = $this->db->select('*')
            ->from('quiz_questions')
            ->where('quiz_id', $quiz_id)
            ->get();
            return $query->num_rows();
    }

    function has_participated($quiz_id,$uid = null)
    {
        $query = $this->db->select('*')
            ->from('quiz_result_overall')
            ->where('quiz_id', $quiz_id)
            ->where('user_id', $uid)
            ->get();
            return $query->num_rows();
    }

    function get_quiz($type = 'mine', $limit = 3, $offset = 0)
    {
        switch ($type) {
            case 'mine':
                $userid = user_id();
                $query = $this->db->select('*')
                    ->from('quiz_details')
                    ->where('user_id', $userid)
                    ->limit($limit, $offset)
                    ->order_by('time', 'DESC')
                    ->get();
                return $query->result_array();
                break;
            case 'all':
                $query = $this->db->select('*')
                    ->from('quiz_details')
                    ->limit($limit, $offset)
                    ->order_by('time', 'DESC')
                    ->get();
                return $query->result_array();
                break;
        }
    }

    function quiz_num_rows($type = 'all')
    {
        $userid = user_id();
        if ($type == 'mine') {
            $query = $this->db->select('*')
                ->from('quiz_details')
                ->where('user_id', $userid)
                ->get();
        } else {
            $query = $this->db->select('*')
                ->from('quiz_details')
                ->get();
        }
        return $query->num_rows();
    }

    function add_quiz_details($arr)
    {
        $this->db->insert('quiz_details', $arr);
        return $this->db->insert_id();
    }

    function add_question($arr)
    {
        $this->db->insert('quiz_questions', $arr);
        return $this->db->insert_id();
    }

    function add_answer($arr)
    {
        $this->db->insert('quiz_answers', $arr);
        return $this->db->insert_id();
    }

    function get($id)
    {
        $query = $this->db->query("SELECT * FROM quiz_details WHERE id='{$id}' OR slug='{$id}'");
        $r = $query->result_array();
        if ($r) {
            return $r[0];
        }
        return array();
    }

    function get_questions($quiz_id)
    {
        $query = $this->db->query("SELECT * FROM quiz_questions WHERE quiz_id='{$quiz_id}'");
        return $query->result_array();
    }

    function get_question($qid)
    {
        $query = $this->db->query("SELECT * FROM quiz_questions WHERE id='{$qid}'");
        return $query->result_array();
    }

    function get_answers($qid)
    {
        $query = $this->db->query("SELECT * FROM quiz_answers WHERE question_id='{$qid}'");
        return $query->result_array();
    }

    function save_friends_answers($arr)
    {
        $this->db->insert('quiz_friend_answers', $arr);
        return $this->db->insert_id();
    }

    function quiz_result_by_question($arr)
    {
        $this->db->insert('quiz_result_by_question', $arr);
        return $this->db->insert_id();
    }

    function quiz_result_overall($arr)
    {
        $this->db->insert('quiz_result_overall', $arr);
        return $this->db->insert_id();
    }

    //retrieving quiz result
    function get_overall_quiz_result($result_id)
    {
        $query = $this->db->query("SELECT * FROM quiz_result_overall WHERE id={$result_id}");
        return $query->result_array();
    }

    function get_quiz_questions_result($quiz_id, $uid)
    {
        $query = $this->db->query("SELECT * FROM quiz_result_by_question WHERE quiz_id='{$quiz_id}' AND user_id='{$uid}'");
        return $query->result_array();
    }

    function get_all_quiz_paticipants($quiz_id, $limit = 2, $offset = 0)
    {
        $query = $this->db->select('*')
            ->from('quiz_result_overall')
            ->where('quiz_id', $quiz_id)
            ->limit($limit, $offset)
            ->order_by('correct_questions', 'DESC')
            ->get();
        //var_dump($query);die();
        return $query->result_array();
    }
}