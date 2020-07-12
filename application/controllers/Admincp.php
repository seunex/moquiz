<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admincp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'layouts', 'session'));
        $this->load->model(array('user_model', 'general_model','quiz_model'));
        $this->load->helper('language');
        $this->load->language('main');
        $this->load->database();
        $this->configs = $this->general_model->configs();
    }

    public function index(){
        if(!isLoggedIn()) return redirect(site_url());
        $this->layouts->set_title(lang('website-settings'));
        $this-> layouts->view('templates/default/admincp/index',array(),array('quiz'=>''),true,true,array('active'=>'admin-panel'));
    }

}
