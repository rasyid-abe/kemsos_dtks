<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    private $CI;
    private $template_params;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library( 'session' );
        $this->template_params = array();
        $this->user_info = $this->CI->session->user_info;
        $this->user_menu = $this->CI->session->user_menu;
    }

    public function set( $position, $data, $append = true) {
        if ( ! isset( $this->template_params[$position] ) || $append === false ) {
            $this->template_params[$position] = $data;
        } else {
            $this->template_params[$position] .= $data;
        }
    }

    public function get($position) {
        if (isset($this->template_params[$position])) {
            return $this->template_params[$position];
        } else {
            return '';
        }
    }

    public function title( $title = '' ) {
        $this->template_params['title'] = $title;
    }

    public function breadcrumb( $breadcrumb = '' ) {
        $this->template_params['breadcrumb'] = $breadcrumb;
    }

    public function header_script( $header_script = '' ) {
        $this->template_params['header_script'] = $header_script;
    }

    public function footer_script( $footer_script = '' ) {
        $this->template_params['footer_script'] = $footer_script;
    }

    public function content( $view, $params = array(), $position = 'content', $append = true ) {
        $data = $this->CI->load->view( $view, $params, true );
        $this->set( $position, $data, $append );
    }

    public function show( $template_view = 'template', $return_string = true ) {
        // if ( empty( $this->user_menu ) ) {
        //     if ( $this->user_info[ 'user_group_name' ] == 'root' ) {
        //         $params = [
        //             'table' => 'core_menu',
        //             'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_image, menu_class, menu_sort',
        //             'where' => [ 'menu_is_active' => '1' ]
        //         ];
        //         $query_menu = get_data( $params );
        //     } else {
        //         $params = [
        //             'table' => [
        //                 'core_user_role' => '',
        //                 'core_menu' => 'user_role_menu_id = menu_id'
        //             ],
        //             'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_image, menu_class, menu_sort',
        //             'where' => [
        //                 'menu_is_active' => '1',
        //                 'user_role_user_group_id' => $this->user_info['user_group_id']
        //              ]
        //         ];
        //         $query_menu = get_data( $params );
        //     }
        //     $arr_menu = array();
        //     if ( $query_menu->num_rows() > 0 ) {
        //         foreach ( $query_menu->result() as $row_menu ) {
        //             $arr_menu[$row_menu->menu_parent_menu_id][$row_menu->menu_sort] = $row_menu;
        //         }
        //     }
        //     $array_menu = array(
        //         'user_menu' => $arr_menu
        //     );
        //     $this->CI->session->set_userdata( $array_menu );
        // } else {
        //     $query_menu = $this->CI->session->userdata( 'user_menu' );
        // }

        $this->template_params['addons'] = base_url( 'assets/addons/' );
        $this->template_params['style'] = base_url( 'assets/style/' );
        $data = $this->template_params;

        $complete_page = $this->CI->load->ext_view( $template_view, $data, true );

        if ( $return_string == true ) {
            echo $complete_page;
        } else {
            return $complete_page;
        }
    }

    public function blank( $view, $params = array() ){
        $this->CI->load->view( $view, $params );
    }
}
