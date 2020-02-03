<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


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

    public function index()
	{
	    if(!$this->session->userdata('id')) redirect(site_url());
	    $this->layouts->set_title(lang('welcome_title'));
	    $quiz = $this->quiz_model->get_quiz('mine');
        $this-> layouts->view('templates/default/account/index',array(),array('quiz'=>$quiz),true,true,array('active'=>'home'));
	}

}
