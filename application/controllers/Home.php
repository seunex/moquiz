<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session','pagination'));
        $this->load->language('main');
        $this->load->helper(array('language','quiz_helper'));
        $this->load->database(get_db_config());
        $this->load->model(array('general_model','quiz_model'));
        $this->configs = $this->general_model->configs();
    }

    public function mode($type = null)
    {
        $expected = array('dark','light');
        if(in_array($type,$expected)){
            session_put('active_mode',$type);
        }
        return false;
    }

    public function index($count =1)
	{
	    if(!isLoggedIn()) redirect(site_url());
	    $this->layouts->set_title(lang('welcome_title'));
        $config = array(
            'base_url' => base_url('home/index'),
            'per_page' => 2,
            'total_rows' => $this->quiz_model->quiz_num_rows('mine'),
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
        $quiz = $this->quiz_model->get_quiz('mine',$config['per_page'], $this->uri->segment(3)); // list of seeker

        $this-> layouts->view('templates/default/account/index',array(),array('quiz'=>$quiz),true,true,array('active'=>'home'));
	}

}
