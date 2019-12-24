<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Template
{

    public $template_data = array();
    protected $CI;


    public function __construct()
    {
        $this->CI = &get_instance();
    }


    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    function load($view, $view_data = array(), $return = FALSE)
    {
        $this->set('head', $this->CI->load->view('layout/head', $view_data, TRUE));
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('jsbody', $this->CI->load->view('layout/jsbody', $view_data, TRUE));
        return $this->CI->load->view('layout/template_utama', $this->template_data, $return);
    }

    function loadadmin($view, $view_data = array(), $return = FALSE)
    {
        $this->set('head', $this->CI->load->view('layout/head', $view_data, TRUE));
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('jsbody', $this->CI->load->view('layout/jsbody', $view_data, TRUE));
        return $this->CI->load->view('layout/template_admin', $this->template_data, $return);
    }

    function auth($tpl_view, $view, $view_data = array(), $return = FALSE)
    {
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view('layout/' . $tpl_view, $this->template_data, $return);
    }
}
