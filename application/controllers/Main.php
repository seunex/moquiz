<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session'));
        $this->load->language('main');
        $this->load->helper('language');
    }

    public function index()
	{
        if($this->session->userdata('id')) return redirect('home');
	    $this->layouts->set_title(lang('welcome_title'));
        $this-> layouts->view('templates/default/layouts/home',array(),array(),true);
	}

	public function login()
	{
	    $this->layouts->set_title(lang('welcome_title'));
        $this-> layouts->view('templates/default/layouts/home',array(),array(),true);
	}

}
