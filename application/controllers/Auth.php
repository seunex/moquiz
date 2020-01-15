<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function Login()
	{
		$this->load->view('templates/default/login/main');
	}
}
