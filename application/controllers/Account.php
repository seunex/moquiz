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
        $this->load->database(get_db_config());
        $this->configs = $this->general_model->configs();
    }

    /**
     * @param $uid
     */
    public function delete($uid){
        if(!isLoggedIn()) return redirect(site_url());
        if(md5(get_user_name()) == $uid && !DEMO){
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
        if(!isLoggedIn()) return redirect(site_url());
        $this->form_validation->set_rules('full_name', lang('full_name'), 'required|trim');
        $this->form_validation->set_rules('username', lang('username'), 'required|trim|alpha_numeric|min_length[3]|callback_check_username');
        $this->form_validation->set_rules('email_address', lang('email_address'), 'required|trim|valid_email|callback_check_email');

        if ($this->form_validation->run() && !DEMO) {
            //form success
            $msg = '';
            $user = get_user();
            $data = array(
                'username' => input('username'),
                'full_name' => input('full_name'),
                'email_address' => input('email_address'),
            );
            $old_password = input('old_password');
            $new_password = input('new_password');
            $new_password_c = input('new_password_c');
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
            if(file_isset($file_name) && $_FILES[$file_name]['size'] > 0){
                //print_r($_FILES);die();
                $upload_arr = $this->upload_avatar($file_name);
                if($upload_arr['status'] == 1){
                    $data['avatar'] = $upload_arr['path'];
                }else{
                    $msg = $upload_arr['msg'];
                }
            }
            if ($msg) {
                $this->layouts->view('templates/default/account/profile', array(), array('user' => $user, 'msg' => $msg), true, true, array('active' => 'profile'));
            } else {
                $data['updated_at'] = time();
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
        //$config['max_size'] = 10000;
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
            $this->form_validation->set_message('check_username', lang('username-already-exists'));
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
            $this->form_validation->set_message('check_email', lang('email-already-exists'));
            return false;
        }
    }



}
