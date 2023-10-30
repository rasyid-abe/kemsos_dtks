<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebook extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$this->template->title( 'Tutorial E-Book' );
		$this->template->content( "admin/tutorial/ebook", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}


}
