<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_quiz_url($quiz){
   return site_url('quiz/start/'.$quiz['slug']);
}

function quiz_data($key,$quiz){
    if(!$quiz) return false;
    return $quiz[$key];
}

function get_question_answers($question){
    $qid = $question['id'];
    $CI = get_instance();
    $CI->load->model('quiz_model');
    $answers = $CI->quiz_model->get_answers($qid);
    return $answers;
}

function get_participants($quiz,$type = 'count'){
    $quiz_id = $quiz['id'];
    $CI = get_instance();
    $CI->load->model('quiz_model');
    $particpants = $CI->quiz_model->get_participants($quiz_id,$type);
    return $particpants;
}

function find_quiz($quiz_id){
    $CI = get_instance();
    $CI->load->model('quiz_model');
    $quiz = $CI->quiz_model->get($quiz_id);
    return $quiz;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function delete_quiz($quiz_id){
    $CI = get_instance();
    $CI->load->model('quiz_model');
    //delete quiz_model
    $CI->quiz_model->delete_quiz($quiz_id);
    //delete quiz answers
    $CI->quiz_model->delete_answers($quiz_id);
    //delete quiz_questions
    $CI->quiz_model->delete_questions($quiz_id);
    //delete quiz results
    $CI->quiz_model->delete_results($quiz_id);
    return true;
}

function get_question($qid){
    $CI = get_instance();
    $CI->load->model('quiz_model');
    $question = $CI->quiz_model->get_question($qid);
    return $question;
}

function answers_type($answers){
    $default = 'radio';
    //return $default;
    //return 'checkbox';
    $cc = 0; //correct count;
    foreach ($answers as $a){
        if($a['answer'] == 1){
            $cc = $cc + 1;
        }
    }
    if($cc > 1) $default = 'checkbox';
    return $default;
}

function is_question_answer_correct($answer, $databaseAnswer){
    $is_correct =  false;
    foreach ($databaseAnswer as $a){
        if ($databaseAnswer['id'] == $answer){
            if($a['answer'] == 1){
                $is_correct =  true;
            }
        }
    }
    return $is_correct;
}

function get_quiz_score($result, $add_symbol = true){
    $correct_questions = $result['correct_questions'];
    $question = $result['question_count'];
    $number = 0;
    if($question && $correct_questions){
        $number = ($correct_questions/$question * 100);
        if(is_float($number)){
            $number = round($number,2);
            //$number = number_format((float)$number, 2, '.', '');
        }
    }
    if($add_symbol) return $number.'%';
    return $number;
}