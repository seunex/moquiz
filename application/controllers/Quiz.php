<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session'));
        $this->load->language('main');
        $this->load->helper('language');
        $this->load->database();
        //load settings now
        $this->load->model(array('general_model','quiz_model'));
        $this->configs = $this->general_model->configs();
    }

    public function create()
    {

        if(isset($_POST['title'])){
               //echo $this->input->post('title');
               $quiz_title = $this->input->post('title');

            echo json_encode(array('here'=>'good'));
        }else{
            if(!$this->session->userdata('id')) redirect(site_url());
            $this->layouts->set_title(lang('create_a_quiz'));
            $this-> layouts->view('templates/default/quiz/create',array(),array(),true,true,array('active'=>'create-quiz'));

        }

    }

}