<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Err extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->show();
	}

	function show()
	{
		$this->load->view('page-error');
	}
}
