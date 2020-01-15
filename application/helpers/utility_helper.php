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

