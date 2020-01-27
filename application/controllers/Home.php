<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library('layouts');
        $this->load->language('main');
        $this->load->helper('language');
    }

    public function index()
	{
	    $this->layouts->set_title(lang('welcome_title'));
        $this-> layouts->view('templates/default/account/home',array(),array(),true);
	}

}
