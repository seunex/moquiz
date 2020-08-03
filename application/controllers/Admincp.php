<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admincp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'layouts', 'session', 'pagination'));
        $this->load->model(array('user_model', 'general_model', 'quiz_model'));
        $this->load->helper(array('language', 'quiz'));
        $this->load->language('main');
        $this->load->database(get_db_config());
        $this->configs = $this->general_model->configs();
        if(!is_admin()) return redirect(url(''));
    }

    public function index()
    {
        if (!isLoggedIn()) return redirect(site_url());
        $this->layouts->set_title(lang('website-settings'));
        $content = $this->load->view('templates/default/admincp/index', array(), true);
        $this->layouts->view('templates/default/admincp/layout', array(), array('content' => $content, 'active' => 'dashboard'), true, true, array());
    }

    public function pages($action = null)
    {
        if (!isLoggedIn()) return redirect(site_url());
        $this->layouts->set_title(lang('website-settings'));
        $msg = null;
        $type = $this->input->get('type');
        $pid = $this->input->get('id');
        $title = lang('custom-pages');
        $p = array();
        $show_add_btn = true;
        if($type == 'delete'){
            $pid = $this->input->get('id');
            $this->general_model->delete_page($pid);
            return redirect(url('admincp/pages'));
        }
        if ($type == 'add') {
            $title = lang('add-page');
            $show_add_btn = false;
            $this->form_validation->set_rules('title', lang('page-title'), 'required|trim');
            $this->form_validation->set_rules('content', lang('page-content'), 'required|trim');
            if ($this->form_validation->run()) {
                $data = array(
                    'title' => input('title'),
                    'slug' => toAscii(input('title')),
                    'content' => purify_html($this->input->post('content'))
                );
                $this->general_model->add_page($data);
                return redirect(url('admincp/pages'));
            } else {
                $msg = validation_errors();
            }
        }
        if ($type == 'edit') {
            $title = lang('edit-page');
            $show_add_btn = false;
            //if(!$pid) redirect(url('admincp/pages'));
            //pid
            $p = $this->general_model->get_page($pid);
            $this->form_validation->set_rules('title', lang('page-title'), 'required|trim');
            $this->form_validation->set_rules('content', lang('page-content'), 'required|trim');
            if ($this->form_validation->run()) {
                $pid = input('pid');
                $data = array(
                    'title' => input('title'),
                    'slug' => toAscii(input('title')),
                    'content' => purify_html($this->input->post('content'))
                );
                //print_r($data);die();
                $this->general_model->save_page($data,$pid);
                return redirect(url('admincp/pages'));
            } else {
                $msg = validation_errors();
            }
        }
        $pages = $this->general_model->get_pages();
        $content = $this->load->view('templates/default/admincp/pages',
            array('pages' => $pages, 'msg' => $msg, 'type' => $type, 'title' => $title, 'show_add_btn' => $show_add_btn,'p'=>$p), true);
        $this->layouts->view('templates/default/admincp/layout', array(), array('content' => $content, 'active' => 'pages'), true, true, array());
    }

    public function settings()
    {
        if (!isLoggedIn()) return redirect(site_url());
        $this->layouts->set_title(lang('website-settings'));
        $settings = array();
        $msg = null;
        if (input('website-title')) {
            $val['website-title'] = input('website-title');
            $val['website-description'] = input('website-description');
            $val['website-keywords'] = input('website-keywords');

            //html purify
            //$clean_html = $purifier->purify($dirty_html);
            $val['website-google-analytics'] = input('website-google-analytics');
            $val['ads-code'] = purify_html($this->input->post('ads-code'));

            //appearance
            $val['background-color'] = input('background-color');
            $val['btn-action-color'] = input('btn-action-color');
            $val['side-bar-color'] = input('side-bar-color');

            //social
            $val['allow-facebook-signup'] = input('allow-facebook-signup');
            $val['facebook-key'] = input('facebook-key');
            $val['facebook-secret'] = input('facebook-secret');

            //twitter
            $val['allow-twitter-signup'] = input('allow-twitter-signup');
            $val['twitter-key'] = input('twitter-key');
            $val['twitter-secret'] = input('twitter-secret');

            //google
            $val['allow-google-signup'] = input('allow-google-signup');
            $val['google-key'] = input('google-key');
            $val['google-secret'] = input('google-secret');

            $this->general_model->save_configs($val);
            $msg = lang('changes-saved-successfully');
            $this->configs = $this->general_model->configs();
        }
        $content = $this->load->view('templates/default/admincp/settings', array('settings' => $settings, 'msg' => $msg), true);
        $this->layouts->view('templates/default/admincp/layout', array(), array('content' => $content, 'active' => 'settings'), true, true, array());
    }

    public function users($action = null, $uid = null)
    {
        if (!isLoggedIn()) return redirect(site_url());
        if ($action == 'delete') {
            //echo $action.$uid;die();
            delete_user($uid);
            redirect(site_url('admincp/users'));
        }
        $this->layouts->set_title(lang('manage-users'));
        $total = $this->quiz_model->quiz_num_rows('all');
        $config = array(
            'base_url' => base_url('admincp/users'),
            'per_page' => 4,
            'total_rows' => $total,
        );

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config); // model function
        $users = $this->user_model->get_users($config['per_page'], $this->uri->segment(3));
        $content = $this->load->view('templates/default/admincp/users', array('users' => $users, 'total' => $total), true);
        $this->layouts->view('templates/default/admincp/layout', array(), array('content' => $content, 'active' => 'users'), true, true, array('active' => 'admin-panel'));
    }

    public function quiz()
    {
        if (!isLoggedIn()) return redirect(site_url());
        $this->layouts->set_title(lang('manage-quiz'));
        $total = $this->quiz_model->quiz_num_rows('all');
        $config = array(
            'base_url' => base_url('admincp/quiz'),
            'per_page' => 4,
            'total_rows' => $total,
        );

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config); // model function
        $quiz = $this->quiz_model->get_quiz('all', $config['per_page'], $this->uri->segment(3));
        $content = $this->load->view('templates/default/admincp/quiz', array('quiz' => $quiz, 'total' => $total), true);
        $this->layouts->view('templates/default/admincp/layout', array(), array('content' => $content, 'active' => 'quiz'), true, true, array('active' => 'admin-panel'));
    }

}
