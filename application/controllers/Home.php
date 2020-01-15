<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
	    $this->load->library('layouts');
	    $this->load->language('main');
        $this->load->helper('language');
	    $this->layouts->set_title(lang('welcome'));
        $this-> layouts->view('templates/default/layouts/home',array(),array(),true);
	}
}
