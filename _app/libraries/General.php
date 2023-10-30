<?php

if ( ! defined( 'BASEPATH' ) )
    exit('No direct script access allowed');

class General {

    var $CI = null;

    function __construct() {
        $this->CI = & get_instance();
        // $this->CI->load->library( array( 'session' ) );
    }

    function available_data( $par ) {
        $params = [
            'table' => $par['table']
        ];
    }

    function privilege_user() {
        $user_info = $this->CI->session->user_info;
        $uri_string = rtrim( uri_string(), "/" );
        $arr_uri = explode( '/', $uri_string );
        $actor = $arr_uri[0];
        $controller = $arr_uri[1];

        $action = str_replace( $actor . '/' . $controller . '/', '', $uri_string );

        $arr_uri_string_true = array(
            'backend/systems/profile',
            'backend/systems/password',
            'backend/member/get_member_info/(.*)',
        );

        $is_true = FALSE;
        if ( $user_info['user_group_name'] == 'root' ) {
            $is_true = TRUE;
        } else {
            foreach ( $arr_uri_string_true as $uri_string_true ) {
                if ( preg_match( '/' . str_replace( '/', '\/', rtrim( $uri_string_true, "/" ) ) . '$/', $uri_string ) ) {
                    $is_true = TRUE;
                }
            }

            if ( ! $is_true ) {
                $sql_user_role = "
                    SELECT *
                    FROM core_user_role
                    LEFT JOIN core_menu ON menu_id = user_role_menu_id
                    WHERE user_role_user_group_id = '" . $this->CI->session->userdata('user_group_id') . "'
                ";
                $query_user_role = $this->CI->db->query( $sql_user_role );
                if ( $query_user_role->num_rows() > 0 ) {
                    $arr_menu[0] = 'admin/dashboard/show';
                    foreach ( $query_user_role->result() as $row_user_role ) {
                        $arr_menu[$row_user_role->menu_id] = $row_user_role->menu_url;
                        if ( $row_user_role->menu_url != '#' ) {
                            $explode_link = explode('/', $row_user_role->menu_url);
                            $arr_menu['service_' . $row_user_role->menu_id] = $explode_link[0] . '/service/' . $explode_link[1] . '_service';
                        }
                    }
                }

                foreach ( $arr_menu as $menu_id => $menu_link ) {
                    if (preg_match('/' . $actor . '\/' . $controller . '\//i', $menu_link) || preg_match('/' . $actor . '\/service\/' . $controller . '_service\//i', $menu_link)) {
                        $is_true = TRUE;
                        break;
                    }
                }
            }
        }
        return $is_true;
    }
}

?>
