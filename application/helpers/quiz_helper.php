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