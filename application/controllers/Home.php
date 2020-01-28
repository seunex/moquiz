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
        $this->load->model('general_model');
        $this->configs = $this->general_model->configs();
    }

    public function index()
	{
	    $this->layouts->set_title(lang('welcome_title'));
        $this-> layouts->view('templates/default/account/index',array(),array(),true);
	}

}
