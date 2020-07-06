<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts', 'session','pagination'));
        $this->load->language('main');
        $this->load->helper(array('language', 'quiz'));
        $this->load->database();
        //load settings now
        $this->load->model(array('general_model', 'quiz_model'));
        $this->configs = $this->general_model->configs();
    }

    public function create()
    {

        if (post_isset('title')) {
            //echo '</pre>', print_r($_POST), '</pre>';die();
            //echo $this->input->post('title');
            $quiz_title = $this->input->post('title');
            $qid = $this->quiz_model->add_quiz_details(array(
                'status' => 1,
                'featured' => 0,
                'user_id' => user_id(),
                'title' => $quiz_title,
                'slug' => md5($quiz_title . time()),
                'time' => time(),
            ));

            $config['upload_path'] = './storage/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 100;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;


            $path0 = 'storage/uploads/' . $qid . '/';
            $path = './storage/uploads/' . $qid . '/';
            if (!is_dir($path)) {
                @mkdir($path, 0777, true);
                $file = @fopen($path . 'index.html', 'x+');
                fclose($file);
            }
            $config['upload_path'] = $path;
            $this->load->library('upload', $config);

            //count the questions we have
            //$questios = qimage_2; //question_2
            $i = 1;
            while (post_isset('question_' . $i)) {
                $questio_image_file_name = md5($quiz_title . time() . $i);
                $question_text = $this->input->post('question_' . $i);
                $question_file_name = 'qimage_' . $i;
                $question_check = false; //checking if we have the right questions
                $question_data = array();

                if ($question_text) {
                    //we don't henceforth need the image
                    $question_data['text'] = $question_text;
                    $question_check = true;
                }

                if (file_isset($question_file_name)) {
                    //$path = './storage/quiz/' . $qid . '/' . md5($question_file_name . time()) . '/';
                    //$config['upload_path'] = $path;
                    //$this->upload->initialize($config);
                    if (!$this->upload->do_upload($question_file_name)) {
                        //if the question file failed
                        //we are on the first iteration
                        //question text is empty, we can not
                        if ($i == 1) {
                            //by default, this should not but if client verification is not bypassed
                            //print_r($_FILES[$question_file_name]);
                            $message = $this->upload->display_errors();
                            $status = 0;
                            echo json_encode(array('message' => $message, 'status' => $status));
                            return;

                            break;
                        }
                    } else {
                        //if the upload is successful
                        $question_check = true;
                        $file_data = $this->upload->data();
                        $qnn = $path . $questio_image_file_name . $file_data['file_ext']; //question image new name
                        if (rename($path . $file_data['file_name'], $qnn)) {
                            $question_data['image'] = $path0 . $questio_image_file_name . $file_data['file_ext'];
                        } else {
                            //if we are unable to rename, use the preious
                            $question_data['image'] = $path0 . $file_data['file_name'];
                        }
                    }
                }
                if ($question_check) {
                    //let us add this question before we start looping through answers
                    $question_data['quiz_id'] = $qid;
                    $question_data['time'] = time();
                    $question_id = $this->quiz_model->add_question($question_data);

                    //now let us add the answers
                    //answer text format //answer_image_1_2
                    //answer text format //answer_text_1_2
                    //get all the answer digits from the post array
                    $exp = '/^answer_text_' . $i . '_' . '(\d*)$/';
                    foreach ($_POST as $key => $val) {
                        $match = Array();
                        //If this is one of the item name variables
                        if (preg_match($exp, $key, $match)) {
                            //then put it into the array of captured values
                            //$values[] = $val;
                            $answer_data = array(
                                'question_id' => $question_id,
                                'quiz_id' => $qid,
                                'time' => time(),
                                'image' => '',
                                'txt' => '',
                                'answer' => 0,
                            );
                            $answer_digit = $match[1]; //1, 2, 4 e.t.c
                            $answer_text_name = 'answer_text_' . $i . '_' . $answer_digit;
                            $answer_image_name = 'answer_image_' . $i . '_' . $answer_digit;
                            $answer_image_file_name = md5($answer_image_name . time());
                            if ($this->input->post($answer_text_name)) {
                                $answer_data['txt'] = $this->input->post($answer_text_name);
                            }
                            if ($this->upload->do_upload($answer_image_name)) {
                                $file_data = $this->upload->data();

                                $ann = $path . $answer_image_file_name . $file_data['file_ext']; //question image new name
                                if (rename($path . $file_data['file_name'], $ann)) {
                                    $answer_data['image'] = $path0 . $answer_image_file_name . $file_data['file_ext'];
                                } else {
                                    //if we are unable to rename, use the preious
                                    $answer_data['image'] = $path0 . $file_data['file_name'];
                                }
                                //$answer_data['image'] = $path0 . $file_data['file_name'];
                            }

                            //correct_1_2
                            if ($this->input->post('correct_' . $i . '_' . $answer_digit) == 1) {
                                $answer_data['answer'] = 1;
                            }
                            $this->quiz_model->add_answer($answer_data);
                        }
                    }
                }
                $i++;
            }
            //we are done with the questions
            if ($i > 0) {
                //save the quiz session
                $this->session->set_userdata('quiz_id', $qid);
                echo json_encode(array('status' => 1, 'message' => 'successful', 'url' => site_url('quiz/share')));
                return;
            } else {
                echo json_encode(array('status' => 0, 'message' => lang('error_occured_adding_question')));
                return;
            }

        } else {
            if (!isLoggedIn()) redirect(site_url());
            $this->layouts->set_title(lang('create_a_quiz'));
            $this->layouts->view('templates/default/quiz/create', array(), array(), true, true, array('active' => 'create-quiz'));

        }

    }

    public function delete($id){
        $quiz = find_quiz($id);
        if(!$quiz){
            return $this->layouts->view('templates/default/quiz/delete', array(), array('type' => 'no-quiz'), true, true, array('active' => 'home'));
        }
        if(!isLoggedIn()) redirect(site_url());
        if(is_admin() || $quiz['user_id'] == user_id()){
            delete_quiz($id);
            return $this->layouts->view('templates/default/quiz/delete', array(), array('type' => 'success'), true, true, array('active' => 'home'));
        }else{
            return $this->layouts->view('templates/default/quiz/delete', array(), array('type' => 'no-perm'), true, true, array('active' => 'home'));
        }
    }


    public function share($id)
    {
        if (!isLoggedIn()) redirect(site_url());
        //if (!get_session('quiz_id')) redirect(site_url());
        $this->layouts->set_title(lang('share_your_quiz'));
        $last_created_quiz = ($this->session->userdata('quiz_id')) ?  $this->session->userdata('quiz_id') : $id;
        $quiz = $this->quiz_model->get($last_created_quiz);
        $this->layouts->view('templates/default/quiz/share', array(), array('quiz' => $quiz), true, true, array('active' => 'create-quiz'));
    }

    public function start($slug)
    {
        $quiz = $this->quiz_model->get($slug);
        if (!$quiz) return redirect(site_url());
        $this->layouts->set_title(lang('take_quiz'));
        $user = find_user($quiz['user_id']);
        $questions = $this->quiz_model->get_questions($quiz['id']);
        $url = current_url();
        $this->session->set_userdata('redirect_url', $url);
        return $this->layouts->view('templates/default/quiz/start', array(), array('quiz' => $quiz, 'user' => $user, 'questions' => $questions), true, false, array('active' => 'create-quiz'));
    }

    function take()
    {
        if (post_isset('ajax')) {
            //echo '</pre>', print_r($_POST), '</pre>';die();
            //echo $this->input->post('title');
            $quiz_id = $this->input->post('quiz_id');
            $answers = $this->input->post('answer');
            $user_id = (int)user_id();
            $question_count = 0;
            $correct_questions_count = 0;
            $time = time();

            if (is_array($answers)) {
                $question_count = count($answers);
                foreach ($answers as $q_id => $answer) {
                    $arr = array();
                    $arr['time'] = $time;
                    $arr['quiz_id'] = $quiz_id;
                    $arr['question_id'] = $q_id;
                    $arr['user_id'] = $user_id;
                    $answer_arr = get_question_answers($q_id);

                    //correct answer count expected
                    //this is number of the correct
                    //answers expected for this question
                    $expected_correct_answer_count = 0;
                    foreach ($answer_arr as $a) {
                        if ($a['answer'] == 1) {
                            $expected_correct_answer_count = $expected_correct_answer_count + 1;
                        }
                    }
                    $provided_correct_answer_count = 0;
                    $miss_one_miss_all = false;
                    if (is_array($answer)) {
                        foreach ($answer as $aa) {
                            $is_correct = is_question_answer_correct($aa, $answer_arr);

                            // we want to mark the answer wrong when 1 of the selected answer is
                            // or when the selected answer does not satisfy the expected selected answer
                            // e.g 3 selected answers expected but 2 given
                            if ($is_correct) {
                                $provided_correct_answer_count = $provided_correct_answer_count + 1;
                            }else{
                                //as long as we have a wrong anwer, this question wrong;
                                $miss_one_miss_all = true;
                                $provided_correct_answer_count = 0;
                            }

                            $arr['correct'] = $is_correct;
                            $arr['answer_id'] = $aa;
                            $this->quiz_model->save_friends_answers($arr);

                        }
                    } else {
                        $is_correct = is_question_answer_correct($answer, $answer_arr);
                        if ($is_correct) {
                            $provided_correct_answer_count = $provided_correct_answer_count + 1;
                        }
                        $arr['correct'] = $is_correct;
                        $arr['answer_id'] = $answer;
                        $this->quiz_model->save_friends_answers($arr);
                    }

                    //you get this question
                    if($miss_one_miss_all){
                        //this user have atleaset one wrong answer
                        $question_is_correct = 0; //this correct is not correct
                    }else{
                        if ($provided_correct_answer_count == $expected_correct_answer_count) {
                            //the answer provided to this question is correct
                            $correct_questions_count = $correct_questions_count + 1;
                            $question_is_correct = 1; //yes
                        } else {
                            $question_is_correct = 0; //no
                        }
                    }


                    $arr1 = array(
                        'quiz_id' => $quiz_id,
                        'question_id' => $q_id,
                        'correct' => $question_is_correct,
                        'user_id' =>$user_id,
                        'time'=>$time
                    );
                    $this->quiz_model->quiz_result_by_question($arr1);
                }
            }

            $arr2 = array(
                'quiz_id'=>$quiz_id,
                'user_id'=>$user_id,
                'question_count'=>$question_count,
                'correct_questions'=>$correct_questions_count,
                'time'=>$time
            );
            $overall = $this->quiz_model->quiz_result_overall($arr2);

            if ($overall) {
                //save the quiz session
                $this->session->set_userdata('q_result_id', $overall);
                echo json_encode(array('status' => 1, 'message' => 'successful', 'url' => site_url('quiz/outcome')));
                return;
            } else {
                echo json_encode(array('status' => 0, 'message' => lang('error_occured_adding_question')));
                return;
            }
        }
        //echo "Welcome Take";
    }

    function outcome($id = null){
        //echo $id;
        if(!isLoggedIn()) return redirect(site_url());
        $quiz = array();
        $uid = user_id();
        $result_id = ($id) ? $id : $this->session->userdata('q_result_id');
        //print_r($result_id);die();
        if(!$result_id) return redirect(site_url());
        $quiz_overall_result = $this->quiz_model->get_overall_quiz_result($result_id);
        $quiz_overall_result_indexed = $quiz_overall_result[0];
        $quiz = $this->quiz_model->get($quiz_overall_result_indexed['quiz_id']);

        //$question_result
        $question_result = $this->quiz_model->get_quiz_questions_result($quiz_overall_result_indexed['quiz_id'],$uid);

        $user = find_user($quiz['user_id']);
        $this->layouts->set_title(lang('quiz_result'));
        $this->layouts->view('templates/default/quiz/result', array(), array(
            'quiz_result' => $quiz_overall_result_indexed,
            'question_result'=>$question_result,
            'user'=>$user,
            'quiz'=>$quiz), true, true, array('active' => 'score-board'));
    }

    function scoreboard($quiz_id = null,$offset = 0){
        $this->layouts->set_title(lang('score_board'));
        $quiz = $this->quiz_model->get($quiz_id);
        //$quiz_results = $this->quiz_model->get_all_quiz_paticipants($quiz_id);

        $config = array(
            'base_url' => base_url('quiz/scoreboard/'.$quiz_id),
            'per_page' => 10,
            'total_rows' => get_participants($quiz,'count'),
        );

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config); // model function
        //$quiz = $this->quiz_model->get_quiz('mine',$config['per_page'], $this->uri->segment(3));
        $quiz_results = $this->quiz_model->get_all_quiz_paticipants($quiz_id,$config['per_page'], $this->uri->segment(4));
        $i = 1;
        if($offset) $i = $offset;
        //$this->layouts->view('templates/default/quiz/result', array(), array('quiz'=>$quiz, 'quiz_results'=>$quiz_results), true, true, array('active' => 'home'));
        $this->layouts->view('templates/default/quiz/scoreboard', array(), array('quiz'=>$quiz, 'quiz_results'=>$quiz_results,'i'=>$i), true, true, array('active' => 'home'));
    }

}