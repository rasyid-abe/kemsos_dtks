<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Tutorial Video' );
		$this->template->content( "admin/tutorial/video", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
