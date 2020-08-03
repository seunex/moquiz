<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('layouts');
        $this->load->language('main');
        $this->load->helper('language');
        $this->load->model(array('general_model'));
        $this->load->database(get_db_config());
        $this->configs = $this->general_model->configs();
    }

    public function index()
	{
        $this->layouts->set_title(lang('welcome_title'));
        $this-> layouts->view('templates/default/register/main',array(),array(),true);
	}
}
