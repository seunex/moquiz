<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
	    $this->load->library('layouts');
	    $this->layouts->set_title("We are here");
        $this-> layouts->view('templates/default/layouts/index',array(),array(),true);
	}
}
