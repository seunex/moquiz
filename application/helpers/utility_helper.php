<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('asset_url()')) {
    function asset_url($str = null)
    {
        return base_url() . 'assets/'.$str;
    }
}

if (!function_exists('get_settings()')) {
    function get_settings($key)
    {
        return $key;
    }
}

if (!function_exists('active_template()')) {
    function active_template()
    {
        return get_settings('active_template');
    }
}

if (!function_exists('img_url()')) {
    function img_url($path)
    {
        return asset_url() . 'default/img/' . $path;
    }
}
if (!function_exists('url()')) {
    function url($path)
    {
        return base_url() . $path;
    }
}

if (!function_exists('url_by_key()')) {
    function key_to_url($key)
    {

        if (isset(get_instance()->router->routes[$key])) {
            return base_url() . get_instance()->router->routes[$key];
        }
        return base_url();
    }
}

if (!function_exists('file_isset()')) {
    function file_isset($fileName)
    {

        if (isset($_FILES[$fileName])) {
            return true;
        }
        return false;
    }
}

if (!function_exists('post_isset()')) {
    function post_isset($key)
    {

        if (isset($_POST[$key])) {
            return true;
        }
        return false;
    }
}
if (!function_exists('get_isset()')) {
    function get_isset($key)
    {

        if (isset($_GET[$key])) {
            return true;
        }
        return false;
    }
}

if (!function_exists('config()')) {
    function config($key, $default = null)
    {
        $CI = get_instance();
        $settings = $CI->configs;
        if (isset($settings[$key])) return $settings[$key];
        return $default;
    }
}

function is_admin(){
    if(!isLoggedIn()) return false;
    $user = get_user();
    if($user['role'] == 1) return true;
    return false;
}

function isLoggedIn()
{
    $CI = get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('id')) {
        return true;
    }
    return false;
}

function user_id()
{
    $CI = get_instance();
    $CI->load->library('session');
    $userid = $CI->session->userdata('id');
    if ($userid) return $userid;
    return false;
}

function get_user()
{
    $CI = get_instance();
    $CI->load->library('session');
    $user = $CI->session->userdata('user');
    if ($user) return $user;
    return false;
}

function find_user($id){
    $CI = get_instance();
    $CI->load->model('user_model');
    $user = $CI->user_model->find_user($id);
    return $user;
}

function login_with_user($user){
    $CI = get_instance();
    $CI->session->set_userdata('id',$user['id']);
    $CI->session->set_userdata('user',$user);
    return $user;
}

function get_session($key,$default = null)
{
    $CI = get_instance();
    $CI->load->library('session');
    $value = $CI->session->userdata($key);
    if(!$value) return $default;
    return false;
}

function get_user_name($user = array()){
    $u = ($user) ? $user : get_user();
    return $u['username'];
}

function get_user_full_name($user = array()){
    $u = ($user) ? $user : get_user();
    return $u['full_name'];
}

function get_avatar($user = array()){
    $u = ($user) ? $user : get_user();
    if($u['avatar']) return asset_url($u['avatar']);
    return asset_url('default/img/av.png');
}
