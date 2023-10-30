<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Login_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
        $vals = array(
			'word'          => rand(1,999999),
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url('assets').'/captcha/',
			'img_width'     => '130',
			'img_height'    => 30,
			'word_length'   => 8,
			'colors'        => array(
				'background'     => array(255, 255, 255),
				'border'         => array(255, 255, 255),
				'text'           => array(0, 0, 0),
				'grid'           => array(255, 75, 100)
			)
		);

		$data['captha_image'] = create_captcha($vals);
		$this->template->content( "captcha", $data );
		$this->template->show( THEMES_LOGIN . 'index' );
	}

	function auth(){
		$this->load->helper('security');
		$input = $this->input->post();
		if ( $this->verify_user( xss_clean( html_escape( $input['username'] ) ) ) && $this->verify_password( xss_clean( html_escape( $input['password'] ) ) ) ) {
			$session_arr = [
				'user_info' => [
					'user_username' => 'root',
					'user_name' => 'Root',
					'user_group_id' => '0',
					'user_group_name' => 'root',
					'user_last_login' => '-',
					'user_image' => '',
					'user_location' => '-',
					'user_is_login' => 1,
				]
			];
			$this->session->set_userdata( $session_arr );
			redirect( base_url( 'admin/dashboard' ) );
		} else {
			redirect( base_url( 'login' ) );
		}
	}
}
