<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('asset_url()')) {
    function asset_url($str = null)
    {
        return base_url() . 'assets/'.$str;
    }
}

if (!function_exists('asset_url()')) {
    function storage_url($str = null)
    {
        return base_url() .$str;
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

function session_put($name,$value){
    $CI = get_instance();
    $CI->session->set_userdata($name,$value);
}

function session_get($name,$default= null){
    $CI = get_instance();
    $r = $CI->session->userdata($name);
    if(!$r) return $default;
    return $r;
}

function find_user($id){
    $CI = get_instance();
    $CI->load->model('user_model');
    $user = $CI->user_model->find_user($id);
    return $user;
}

function delete_user($uid){
    $CI = get_instance();
    $CI->load->model('user_model');
    $CI->user_model->delete_user($uid);
}

function login_with_user($user){
    $CI = get_instance();
    $CI->session->set_userdata('id',$user['id']);
    $CI->session->set_userdata('user',$user);
    return $user;
}

function logout_user(){
    $CI = get_instance();
    $CI->session->unset_userdata(array('id','user'));
    redirect(site_url());
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
    if($u['avatar']) return storage_url($u['avatar']);
    return asset_url('default/img/av.png');
}

function toAscii($str, $replace = array(), $delimiter = '-', $charset = 'ISO-8859-1') {
    $str = str_replace(array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)), array("'", "'", '"', '"', '-', '--', '...'), $str);
    $str = function_exists('iconv') ? iconv($charset, 'UTF-8', $str) : $str;
    $str = !empty($replace) ? str_replace((array) $replace, ' ', $str) : $str;
    //$str = preg_replace('/[^\x{0600}-\x{06FF}A-Za-z !@#$%^&*()]/u','', $str);
    $clean = function_exists('iconv') ? iconv('UTF-8', 'ASCII//IGNORE', $str) : $str;
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = strtolower(trim($clean, '-'));
    return $clean;
}

if(!function_exists('sanitizeText')) {
    function sanitizeText($string, $limit = false, $output = false) {
        if(!is_string($string)) return $string;
        $string = trim($string);
        //$string = htmlspecialchars($string, ENT_QUOTES);

        $string = str_replace('&amp;#', '&#', $string);
        $string = str_replace('&amp;', '&', $string);
        if($limit) {
            $string = substr($string, 0, $limit);
        }
        return $string;
    }

}

function page_url($page){
    return url('page/'.$page['slug']);
}

function get_pages(){
    $CI = get_instance();
    $CI->load->model('quiz_model');
    $pages = $CI->general_model->get_pages();
    return $pages;
}

function get_months(){
    $month = array();
    $month[] = lang('january');
    $month[] = lang('february');
    $month[] = lang('march');
    $month[] = lang('april');
    $month[] = lang('may');
    $month[] = lang('june');
    $month[] = lang('july');
    $month[] = lang('august');
    $month[] = lang('september');
    $month[] = lang('october');
    $month[] = lang('november');
    $month[] = lang('december');
    return $month;
}

function get_graph_data($type,$year = null){
    $CI = get_instance();
    $CI->load->model('general_model');
    $data = $CI->general_model->get_graph_data($type);
    return $data;
}

function get_statistics($type){
    $CI = get_instance();
    $CI->load->model('general_model');
    $data = $CI->general_model->get_stats($type);
    return $data;
}

function language_url($slug){
    return url('language/switchLang/'.$slug);
}

function get_active_lang(){
    return session_get('site_lang','english');
}
