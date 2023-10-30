<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array( 'database','template','session', 'form_validation', 'JWT' );

$autoload['drivers'] = array();

$autoload['helper'] = array( 'common','template','url','crud','captcha', 'download','file' );

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array();
