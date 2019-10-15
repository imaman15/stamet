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
        $this->set('sidebar', $this->CI->load->view('sidebar', $view_data, TRUE));
        $this->set('topbar', $this->CI->load->view('topbar', $view_data, TRUE));
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view('layout/template_utama', $this->template_data, $return);
    }

    function loadadmin($view, $view_data = array(), $return = FALSE)
    {
        $this->set('sidebar', $this->CI->load->view('admin/sidebar', $view_data, TRUE));
        $this->set('topbar', $this->CI->load->view('admin/topbar', $view_data, TRUE));
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view('layout/template_utama', $this->template_data, $return);
    }

    function auth($tpl_view, $view, $view_data = array(), $return = FALSE)
    {
        $this->set('content', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view('layout/' . $tpl_view, $this->template_data, $return);
    }
}
