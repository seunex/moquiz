<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','layouts','session'));
        $this->load->model(array('register_model','general_model'));
        $this->load->helper('language');
        $this->load->language('main');
        $this->load->database();
    }

    public function login()
	{
		$this->load->view('templates/default/login/main');
	}


	public function register(){
        //var_dump('here');
        //set rules
        $this->form_validation->set_rules('full_name','Full Name','required|trim');
        $this->form_validation->set_rules('username','User Name','required|trim|alpha_numeric|min_length[3]|callback_check_username');
        $this->form_validation->set_rules('email_address','Email Address','required|trim|valid_email|callback_check_email');
        $this->form_validation->set_rules('password','password','required|min_length[5]');

        if($this->form_validation->run()){
            //form success
            $data = array(
                'username'=>$this->input->post('username'),
                'full_name'=>$this->input->post('full_name'),
                'email_address'=>$this->input->post('email_address'),
                'password'=>md5($this->input->post('password')),
            );
            $id = $this->register_model->insert($data);
            $this->session->set_userdata('id',$id);
            redirect('home');
        }else{
            $this->layouts->set_title(lang('welcome_title'));
            $this->layouts->view('templates/default/register/main',array(),array(),true);
        }
    }

    public function check_username($username) {
        $result = $this->general_model->username_exists($username);
        if($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_username', 'Username already exists');
            $response = false;
        }
        return $response;
    }

    public function check_email($email){
        $result = $this->general_model->email_exists($email);
        if($result == 0){
            return true;
        }else{
            $this->form_validation->set_message('check_email','Email Address Already exists');
            return false;
        }
    }

}
