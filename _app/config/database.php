<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	// 'hostname' => '103.82.242.150,1171',
	// 'username' => 'sa',
	// 'password' => '!@#4Ccfd310aa',
	// 'database' => 'BIMTEK',
	'hostname' => '192.168.181.166',
	'username' => 'mdtks',
	'password' => '2020@SejahTer4',
	'database' => 'MKDTKS_PROD',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['replication'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.102.166',
	'username' => 'mdtks',
	'password' => '2020@SejahTer4',
	'database' => 'MKDTKS_PROD',
	// 'hostname' => '103.82.242.150,1171',
	// 'username' => 'sa',
	// 'password' => '!@#4Ccfd310aa',
	// 'database' => 'BIMTEK',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
