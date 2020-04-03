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
