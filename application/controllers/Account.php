<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'layouts', 'session'));
        $this->load->model(array('user_model', 'general_model','quiz_model'));
        $this->load->helper('language');
        $this->load->language('main');
        $this->load->database();
        $this->configs = $this->general_model->configs();
    }

    public function delete($uid){
        if(!isLoggedIn()) return redirect(site_url());
        if(md5(get_user_name()) == $uid){
            $uid = user_id();
            $quizzes = $this->quiz_model->get_quiz('mine',10000,0);
            if($quizzes){
                foreach ($quizzes as $q){
                    delete_quiz($q['id']);
                }
            }
            delete_user($uid);
            logout_user();
        }
    }

    public function index()
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('username', 'User Name', 'required|trim|alpha_numeric|min_length[3]|callback_check_username');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|trim|valid_email|callback_check_email');
        //$this->form_validation->set_rules('password','password','required|min_length[5]');

        if ($this->form_validation->run()) {
            //form success
            $msg = '';
            $user = get_user();
            $data = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'email_address' => $this->input->post('email_address'),
            );
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $new_password_c = $this->input->post('new_password_c');
            if ($new_password && $new_password_c && $old_password) {
                //we want to change the password
                if ($new_password_c !== $new_password) {
                    $msg = lang('password_does_not_match');
                }
                if (md5($old_password) !== $user['password']) {
                    $msg = lang('wrong_password');
                }
                if (!$msg) {
                    $data['password'] = md5($new_password);
                }
            }
            $file_name = 'avatar';
            if(file_isset($file_name)){
                $upload_arr = $this->upload_avatar($file_name);
                //print_r($upload_arr);die();
                if($upload_arr['status'] == 1){
                    $data['avatar'] = $upload_arr['path'];
                }else{
                    $msg = $upload_arr['msg'];
                }
            }
            if ($msg) {
                $this->layouts->view('templates/default/account/profile', array(), array('user' => $user, 'msg' => $msg), true, true, array('active' => 'profile'));
            } else {
                $this->user_model->update_user($data, user_id());
                $msg = lang('changes_saved_successfully');
                $user = find_user(user_id());
                //reload the user
                session_put('user',$user);
                $this->layouts->view('templates/default/account/profile', array(), array('user' => $user, 'msg' => $msg), true, true, array('active' => 'profile'));
            }
        } else {
            $this->layouts->set_title(lang('account'));
            $user = get_user();
            $msg = validation_errors();
            $this->layouts->view('templates/default/account/profile', array(), array('user' => $user, 'msg' => $msg), true, true, array('active' => 'profile'));
        }
    }

    protected function upload_avatar($file_name)
    {
        $q_image_file_name = md5(  uniqid().time() ); //new name
        $config['upload_path'] = './storage/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 10000;
        //$config['max_width'] = 1024;
        //$config['max_height'] = 768;


        $path0 = 'storage/uploads/avatar/';
        $path = './storage/uploads/avatar/';
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
            $file = @fopen($path . 'index.html', 'x+');
            fclose($file);
        }
        $config['upload_path'] = $path;
        $this->load->library('upload', $config);
        if (file_isset($file_name)) {
            if (!$this->upload->do_upload($file_name)) {
                $message = $this->upload->display_errors();
                $status = 0;
                return array('status'=>$status,'msg'=> $message);
            }else{
                $file_data = $this->upload->data();
                $qnn = $path . $q_image_file_name . $file_data['file_ext']; //question image new name
                if (rename($path . $file_data['file_name'], $qnn)) {
                    $uploaded_path = $path0 . $q_image_file_name . $file_data['file_ext'];
                } else {
                    //if we are unable to rename, use the preious
                    $uploaded_path = $path0 . $file_data['file_name'];
                }
                return array('status'=>1,'path'=>$uploaded_path);
            }
        }
    }

    public function check_username($username)
    {
        $result = $this->general_model->username_exists($username, user_id());
        if ($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_username', 'Username already exists');
            $response = false;
        }
        return $response;
    }

    public function check_email($email)
    {
        $result = $this->general_model->email_exists($email, user_id());
        if ($result == 0) {
            return true;
        } else {
            $this->form_validation->set_message('check_email', 'Email Address Already exists');
            return false;
        }
    }



}
