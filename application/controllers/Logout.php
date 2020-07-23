<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session'));
        $this->load->language('main');
        $this->load->helper('language');
        $this->load->model(array('general_model'));
        $this->load->database();
        $this->configs = $this->general_model->configs();
    }

    public function index()
	{
        if(!$this->session->userdata('id')) redirect(site_url());
        logout_user();
	}
}
