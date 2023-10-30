<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $this->load->library('authentication');
        define('THEMES_USER', site_url( 'themes/member/default/' ) );
        if( ! $this->auth->auth_member() ) {
            $referer = rawurlencode('http://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
            $origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
            redirect('voffice/login?redirect_url=' . $origin);
        } else {
            return TRUE;
        }
    }

}
