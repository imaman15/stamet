<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function template($title, $content, $data)
{
    $CI = &get_instance();

    $data['bgcolor'] = 'primary';
    $data['title'] = $title;
    $data['content'] = $content;
    $data['sidebar'] = 'sidebar';
    $data['topbar'] = 'topbar';
    return $CI->load->view('layout/wrapper', $data, FALSE);
}
function admintemplate($title, $content, $data)
{
    $CI = &get_instance();

    $data['bgcolor'] = 'info';
    $data['title'] = $title;
    $data['content'] = $content;
    $data['sidebar'] = 'admin/sidebar';
    $data['topbar'] = 'admin/topbar';
    return $CI->load->view('layout/wrapper', $data, FALSE);
}
