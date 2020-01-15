<?php
/**
 * Created by Molieve.
 * User: user
 * Date: 2020-01-14
 * Time: 23:54
 */

class Layouts
{

    //hold CI instance
    private $CI;
    //holds layout title
    private $title;

    //holds layout description
    private $description;

    public function __construct()
    {
        $this->CI =  &get_instance();
    }

    //set the page title
    public function set_title($title)
    {
        $this->title = $title;
    }


    //set the page description
    public function set_description($description)
    {
        $this->description = $description;
    }


    public function view($view_name, $layouts = array(), $params = array(), $default = false)
    {
        if(is_array($layouts) and $layouts){
            foreach ($layouts as $layout_key=>$layout){
                $params[$layout_key] = $this->CI->load->view($layout);
            }
        }

        //approving us to load header and footer
        if($default){
            $header_param['title'] = $this->title;
            $header_param['desc'] = $this->description;
            $header_param['locale'] = $this->description;

            $this->CI->load->view('templates/default/layouts/header',$header_param);

            //load the actual content
            $this->CI->load->view($view_name);

            //load the footer
            $this->CI->load->view("templates/default/layouts/footer");
        }else{
            $this->CI->load->view($view_name);
        }

    }


}