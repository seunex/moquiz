<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session','pagination'));
        $this->load->language('main');
        $this->load->helper(array('language','quiz_helper'));
        $this->load->database();
        $this->load->model(array('general_model','quiz_model'));
        $this->configs = $this->general_model->configs();
    }

    public function index($slug =1)
	{
	    $slug = sanitizeText($slug);
        $p = $this->general_model->get_page($slug);
        if($p){
            $this->layouts->set_title($p['title']);
           return  $this->layouts->view('templates/default/static/index', array(), array('p' => $p), true, false, array('active' => 'admin-panel'));
        }else{

        }
        //return redirect(url('home'));
	}

}
