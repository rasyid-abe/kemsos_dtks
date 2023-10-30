<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = "auth/login";
$route['login/(:any)'] = "auth/login/$1";
$route['logout'] = "auth/logout";


$route['dashboard'] = "dashboard/dashboard";
