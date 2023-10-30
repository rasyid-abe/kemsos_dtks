<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $this->load->library( 'auth' );
        $this->user_info = $this->session->user_info;
        $this->info_menu = $this->info_menu();
        $this->breadcrumb = $this->get_breadcrumb();
        $this->url_page = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);

        define('THEMES_BACKEND', 'themes/admin/' . $this->get_theme( 'admin' ) . DIRECTORY_SEPARATOR );
        if ( ! $this->auth->auth_user() ) {
            $referer = rawurlencode('http://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
            $origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
            $redirect = 'login?redirect_url=' . $origin;
            redirect( $redirect );

        } else if ( ! $this->auth->privilege() ) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Anda tidak diotorisasi untuk halaman tersebut.</div>');
            //redirect( 'dashboard' );
            //$this->session->flashdata('confirmation');

        } else {
            return TRUE;
        }
    }

    function info_menu(){
        $explode_uri = explode('/', uri_string());
        if( count( $explode_uri ) >= 3 ){
           $str_uri = $explode_uri[0] . '/' . $explode_uri[1] . '/' . $explode_uri[2];
            $params = [
                'select' => 'child.menu_id, child.menu_name, child.menu_url, parent.menu_id parent_id, parent.menu_name parent_name, parent.menu_url parent_url',
                'table' => [
                    'core_menu child' => '',
                    'core_menu parent' => ['child.menu_parent_menu_id = parent.menu_id', 'left'],
                ],
                'where' => [
                    'child.menu_url' => $str_uri
                ]
            ];
            $query_menu = get_data( $params );
            if ( $query_menu->num_rows() > 0) {
                $result = $query_menu->row();
            } else {
                $result = '';
            }
            return $result;
        }else{
            return '';
        }
    }

    function get_breadcrumb(){
        $breadcrumb = [];
        if ( ! empty( $this->info_menu ) ) {
            if ( ! empty( $this->info_menu->parent_title ) ) {
                $breadcrumb = [
                    $this->info_menu->parent_name => $this->info_menu->parent_url,
                    $this->info_menu->menu_name => $this->info_menu->menu_url
                ];
            } else {
                $breadcrumb = [
                    $this->info_menu->menu_name => $this->info_menu->menu_url
                ];
            }
        }
        return $breadcrumb;
    }
}
