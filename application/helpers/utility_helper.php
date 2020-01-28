<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('asset_url()'))
{
    function asset_url()
    {
        return base_url().'assets/';
    }
}

if ( ! function_exists('get_settings()'))
{
    function get_settings($key)
    {
        return $key;
    }
}

if ( ! function_exists('active_template()'))
{
    function active_template()
    {
        return get_settings('active_template');
    }
}

if ( ! function_exists('img_url()'))
{
    function img_url($path)
    {
        return asset_url().'default/img/'.$path;
    }
}
if ( ! function_exists('url()'))
{
    function url($path)
    {
        return base_url().$path;
    }
}

if ( ! function_exists('url_by_key()'))
{
    function key_to_url($key)
    {

        if(isset( get_instance()->router->routes[$key])){
            return base_url(). get_instance()->router->routes[$key];
        }
        return base_url();
    }
}

if ( ! function_exists('isLoggedIn()'))
{
    function isLoggedIn()
    {
        $CI = get_instance();
        $CI->load->library('session');
        if($CI->session->userdata('id')){
            return true;
        }
        return false;
    }
}

if ( ! function_exists('config()'))
{
    function config($key, $default= null)
    {
        $CI = get_instance();
       $settings = $CI->configs;
        if(isset($settings[$key])) return $settings[$key];
        return $default;
    }
}

