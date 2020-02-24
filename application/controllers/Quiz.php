<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts', 'session'));
        $this->load->language('main');
        $this->load->helper(array('language','quiz'));
        $this->load->database();
        //load settings now
        $this->load->model(array('general_model', 'quiz_model'));
        $this->configs = $this->general_model->configs();
    }

    public function create()
    {

        if (post_isset('title')) {
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


            $path0 = 'storage/uploads/' . $qid . '/' ;
            $path = './storage/uploads/' . $qid . '/' ;
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
                $questio_image_file_name = md5($quiz_title . time().$i);
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
                        $qnn = $path.$questio_image_file_name.$file_data['file_ext']; //question image new name
                        if(rename($path.$file_data['file_name'],$qnn)){
                            $question_data['image'] = $path0 . $questio_image_file_name.$file_data['file_ext'];
                        }else{
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
                            $answer_image_file_name = md5($answer_image_name.time());
                            if ($this->input->post($answer_text_name)) {
                                $answer_data['txt'] = $this->input->post($answer_text_name);
                            }
                            if ($this->upload->do_upload($answer_image_name)) {
                                $file_data = $this->upload->data();

                                $ann = $path.$answer_image_file_name.$file_data['file_ext']; //question image new name
                                if(rename($path.$file_data['file_name'],$ann)){
                                    $answer_data['image'] = $path0 . $answer_image_file_name.$file_data['file_ext'];
                                }else{
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
                $this->session->set_userdata('quiz_id',$qid);
                echo json_encode(array('status' => 1, 'message' => 'successful','url'=>site_url('quiz/share')));
                return;
            }else{
                echo json_encode(array('status' => 0, 'message' => lang('error_occured_adding_question')));
                return;
            }

        } else {
            if (!isLoggedIn()) redirect(site_url());
            $this->layouts->set_title(lang('create_a_quiz'));
            $this->layouts->view('templates/default/quiz/create', array(), array(), true, true, array('active' => 'create-quiz'));

        }

    }

    public function share(){
        if (!isLoggedIn()) redirect(site_url());
        //if (!get_session('quiz_id')) redirect(site_url());
        $this->layouts->set_title(lang('share_your_quiz'));
        $last_created_quiz = $this->session->userdata('quiz_id');
        $quiz = $this->quiz_model->get($last_created_quiz);
        $this->layouts->view('templates/default/quiz/share', array(), array('quiz'=>$quiz), true, true, array('active' => 'create-quiz'));
    }

    public function start($slug){
        $quiz = $this->quiz_model->get($slug);
        if(!$quiz) return redirect(site_url());
        $this->layouts->set_title(lang('take_quiz'));
        $user = find_user($quiz['user_id']);
        $questions = $this->quiz_model->get_questions($quiz['id']);
        return $this->layouts->view('templates/default/quiz/start', array(), array('quiz'=>$quiz,'user'=>$user,'questions'=>$questions), true, false, array('active' => 'create-quiz'));
    }

}