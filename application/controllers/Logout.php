<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts','session'));
        $this->load->language('main');
        $this->load->helper('language');
    }

    public function index()
	{
        if(!$this->session->userdata('id')) redirect(site_url());
        //let us get the user session
        //we will now unset
        $this->session->unset_userdata(array('id','user'));
        redirect(site_url());
	}
}
