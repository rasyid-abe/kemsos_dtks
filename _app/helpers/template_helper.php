<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function set_template($view_type = null, $view_content = '', $data = array()){
	$configuration 		= site_configuration();
	switch ($view_type) {
		case 'frontend':
			$template 		= $configuration['frontend_themes'];
			$template_file	= 'home';
			break;

		case 'backend':
			$template 		= $configuration['backend_themes'];
			$template_file	= 'admin';
			break;

		case 'login': 
			$template 		= $configuration['login_themes'];
			$template_file	= 'login';
			break;
		
		default:
			$template_file = 'home';
			break;
	}
	if ($view_content == '') {
		$CI->load->custom_view('template/' . $view_type . '/' . $template, $template_file, $data);
	} else {
		$CI->load->view($views, $data);
	}
}

function site_configuration() {
	$param 	= array(
		'table'		=> 'blog_configuration',
		'select'	=> 'configuration_name, configuration_value');
	$query 	= get_data($param);

	$site_configuration = array();
	if ($query->num_rows() > 0) {
		foreach ($query->result() as $row) {
			$site_configuration[$row->configuration_name] = $row->configuration_value;
		}
	}
	return $site_configuration;
}
