<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('layouts', 'session','form_validation'));
        $this->load->language('main');
        $this->load->helper(array('language', 'quiz_helper'));
        $this->configs = include(FCPATH . "config.php");
        $this->load->model(array('general_model', 'quiz_model','user_model'));
        //$this->configs = $this->general_model->configs();
    }

    public function index()
    {
        if (isLoggedIn()) return redirect(url(''));
        if ($this->configs['installed'] == 1) return redirect(url(''));
        $this->layouts->set_title(lang('installation'));
        if (input('success')) {
            session_put('db_setup', 1);
            redirect(url('install/database'));
        }
        $c = $this->load->view('install/requirement', array('i' => 1), true);
        return $this->layouts->view('install/layout', array(), array('c' => $c), true, false, array());
    }

    public function database()
    {
        if (isLoggedIn()) return redirect(url(''));
        if ($this->configs['installed'] == 1) return redirect(url(''));
        if (!session_get('db_setup', 0)) redirect(url('install'));
        $this->layouts->set_title(lang('installation'));
        $message = null;
        if (input('db_hostname')) {

            $host = input('db_hostname');
            $password = input('db_password');
            $name = input('db_name');
            $username = input('db_username');

            $config['hostname'] = $host;
            $config['username'] = $username;
            $config['password'] = $password;
            $config['database'] = $name;
            $config['dbdriver'] = 'mysqli';
            $config['db_debug'] = false;
            $this->load->database($config);
            $error =  $this->db->error();
            if($error && is_array($error)){
                $message = $error['message'];
            }

            if(!$message){
                $configContent = file_get_contents(FCPATH . 'config.php');
                $configContent = str_replace(array(
                    '{db-host-name}', '{db-name}', '{db-user-name}', '{db-password}','{installed}'
                ), array($host, $name, $username, $password,'0'), $configContent);

                file_put_contents(FCPATH . 'config.php', $configContent);
                session_put('step_information', 1);
                run_database_install();
                return redirect(url('install/info'));
            }
        }
        $c = $this->load->view('install/database', array('i' => 2, 'message' => $message), true);
        return $this->layouts->view('install/layout', array(), array('c' => $c), true, false, array());
    }

    public function info(){
        if (!session_get('step_information', 0)) redirect(url('install'));
        $this->layouts->set_title(lang('installation'));
        $config['hostname'] = $this->configs['db-host-name'];
        $config['username'] = $this->configs['db-user-name'];
        $config['password'] = $this->configs['db-password'];
        $config['database'] = $this->configs['db-name'];
        $config['dbdriver'] = 'mysqli';
        $config['db_debug'] = false;
        $this->load->database($config);
        $message = null;
        $this->form_validation->set_rules('full_name',lang('full_name'),'required|trim');
        $this->form_validation->set_rules('username',lang('username'),'required|trim|alpha_numeric|min_length[3]');
        $this->form_validation->set_rules('email_address',lang('email_address'),'required|trim|valid_email');
        $this->form_validation->set_rules('password',lang('password'),'required|min_length[5]');

        if($this->form_validation->run()){
            //form success
            $data = array(
                'username'=>input('username'),
                'full_name'=>input('full_name'),
                'email_address'=>input('email_address'),
                'password'=>md5(input('password')),
                'role'=>1,
            );
            $this->register_user($data);
            return redirect(url('install/finish'));
        }else{
            $message = validation_errors() ;
        }
        $c = $this->load->view('install/information', array('i' => 3, 'message' => $message), true);
        return $this->layouts->view('install/layout', array(), array('c' => $c), true, false, array());
    }

    public function finish(){
        if (!session_get('step_information', 0)) redirect(url('install'));
        $this->layouts->set_title(lang('installation'));
        $c = $this->load->view('install/finish', array('i' => 4), true);
        return $this->layouts->view('install/layout', array(), array('c' => $c), true, false, array());
    }

    protected function register_user($data){
        $data['created_at'] = time();
        $id = $this->user_model->insert($data);
        $this->session->set_userdata('id',$id);
        $user = $this->user_model->find_user($id);
        $this->session->set_userdata('user',$user);
    }

    public function check_username($username) {
        $result = $this->general_model->username_exists($username);
        if($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_username', lang('username-already-exists'));
            $response = false;
        }
        return $response;
    }

    public function check_email($email){
        $result = $this->general_model->email_exists($email);
        if($result == 0){
            return true;
        }else{
            $this->form_validation->set_message('check_email',lang('email-already-exists'));
            return false;
        }
    }

}
