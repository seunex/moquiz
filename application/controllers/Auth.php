<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','layouts','session'));
        $this->load->model(array('user_model','general_model'));
        $this->load->helper('language');
        $this->load->language('main');
        $this->load->database();
    }

    public function facebook(){
        $config = array(
            'callback' => url('auth/facebook'),
            'keys' => array( 'key' => '317221782637534', 'secret' => '67b78bacd7df5ff37ad1d33dcd2f9fe1' )
        );

        try {
            $twitter = new Hybridauth\Provider\Facebook($config);

            $twitter->authenticate();

            $userProfile = $twitter->getUserProfile();

            if($userProfile->identifier){
                $username = $userProfile->identifier.'_'.$userProfile->displayName;
                $full_name = $userProfile->firstName;
                $email_address = ($userProfile->email) ? $userProfile->email : $userProfile->identifier.'@twitter.com';
                //it has returned a user
                $data = array(
                    'username'=>$username,
                    'full_name'=>$full_name,
                    'email_address'=>$email_address,
                    'password'=> md5(time()),
                );
                $user = find_user($email_address);
                if($user){
                    login_with_user($user);
                    $redirect_url = $this->session->userdata('redirect_url');
                    if($redirect_url){
                        return redirect($redirect_url);
                    }
                    return redirect(site_url('home'));
                }else{
                    $this->register_user($data);
                }
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function twitter(){
        $config = array(
            'callback' => url('auth/twitter'),
            'keys' => array( 'key' => 'HDgvOzae2GSG5v1L2usxNE2b0', 'secret' => 'PnLvPLdJxeBkF5wihz2JZF4bRyPUE1mGUMRtTOp3hIbV7uSgps' )
        );

        try {
            $twitter = new Hybridauth\Provider\Twitter($config);

            $twitter->authenticate();

            $userProfile = $twitter->getUserProfile();

            if($userProfile->identifier){
                $username = $userProfile->identifier.'_'.$userProfile->displayName;
                $full_name = $userProfile->firstName;
                $email_address = ($userProfile->email) ? $userProfile->email : $userProfile->identifier.'@twitter.com';
                //it has returned a user
                $data = array(
                    'username'=>$username,
                    'full_name'=>$full_name,
                    'email_address'=>$email_address,
                    'password'=> md5(time()),
                );
                $user = find_user($email_address);
                if($user){
                    login_with_user($user);
                    $redirect_url = $this->session->userdata('redirect_url');
                    if($redirect_url){
                        return redirect($redirect_url);
                    }
                    return redirect(site_url('home'));
                }else{
                    $this->register_user($data);
                }
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }
    public function google(){
        $config = array(
            'callback' => url('auth/google'),
            'keys' => array( 'key' => '318446711491-jeig1qdj4tcn4dqo9ktvuv6dtf9e72u8.apps.googleusercontent.com', 'secret' => 'lrmW_jfvJGKPX7_pRMXlBO3z' )
        );

        try {
            $twitter = new Hybridauth\Provider\Google($config);

            $twitter->authenticate();

            $userProfile = $twitter->getUserProfile();

            if($userProfile->identifier){
                $username = $userProfile->identifier.'_'.$userProfile->displayName;
                $full_name = $userProfile->firstName;
                $email_address = ($userProfile->email) ? $userProfile->email : $userProfile->identifier.'@twitter.com';
                //it has returned a user
                $data = array(
                    'username'=>$username,
                    'full_name'=>$full_name,
                    'email_address'=>$email_address,
                    'password'=> md5(time()),
                );
                $user = find_user($email_address);
                if($user){
                    login_with_user($user);
                    $redirect_url = $this->session->userdata('redirect_url');
                    if($redirect_url){
                        return redirect($redirect_url);
                    }
                    return redirect(site_url('home'));
                }else{
                    $this->register_user($data);
                }
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function login()
	{
        $this->form_validation->set_rules('email_address','Email Address','required|trim');
        if($this->form_validation->run()){
            $username = $this->input->post('email_address');
            $password = $this->input->post('password');

            $user = $this->user_model->login_user($username,$password);
            if($user){
                $this->session->set_userdata('id',$user['id']);
                $this->session->set_userdata('user',$user);
                //if we are coming from another place let, take the user there
                $redirect_url = $this->session->userdata('redirect_url');
                if($redirect_url){
                    return redirect($redirect_url);
                }
                return redirect(site_url('home'));
            }else{
                $message = "Invalid Credentials";
                return $this->layouts->view('templates/default/login/main',array(),array('message'=>$message),true);
            }

        }
        $this->layouts->view('templates/default/login/main',array(),array(),true);
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
            $this->register_user($data);
            /*$id = $this->user_model->insert($data);
            $this->session->set_userdata('id',$id);
            $user = $this->user_model->find_user($id);
            $this->session->set_userdata('user',$user);
            //if we are coming from another place let, take the user there
            $redirect_url = $this->session->userdata('redirect_url');
            if($redirect_url){
               return redirect($redirect_url);
            }
            redirect('home');*/
        }else{
            $this->layouts->set_title(lang('welcome_title'));
            $this->layouts->view('templates/default/register/main',array(),array(),true);
        }
    }

    protected function register_user($data){
        $id = $this->user_model->insert($data);
        $this->session->set_userdata('id',$id);
        $user = $this->user_model->find_user($id);
        $this->session->set_userdata('user',$user);
        //if we are coming from another place let, take the user there
        $redirect_url = $this->session->userdata('redirect_url');
        if($redirect_url){
            return redirect($redirect_url);
        }
        redirect('home');
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
