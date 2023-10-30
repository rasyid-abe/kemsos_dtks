<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {
	function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
	}

	function index() {
		$this->session->sess_destroy();
		redirect( base_url( 'login' ) );
	}
}
