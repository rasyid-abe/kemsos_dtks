<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper( 'app' );
        $this->load->library( 'auth', 'session' );
    }

    public function createRespon( $code = 200, $msg = 'OK', $data ) {
        $pesan = array(
            'status_code' => $code,
            'message' => $msg
        );

        $pesan = array(
            'status_code' => $code,
            'message' => $msg,
            'data' => $data
        );
        return json_encode( $pesan );
    }

    public function get_theme( $type = null ) {
        $params = [
            'table' => 'core_configuration',
            'select' => 'configuration_value_is_json, configuration_value',
            'where' => [
                'configuration_type' => 'themes'
            ]
        ];
        $theme_conf = get_data( $params );
        if ( $theme_conf->row('configuration_value_is_json') ) {
            $theme_conf = json_decode( $theme_conf->row('configuration_value'), true );
            $theme_login = $theme_conf[$type];
        } else {
            $theme_login = $theme_conf->row('configuration_value');
        }
        return $theme_login;
    }
}
