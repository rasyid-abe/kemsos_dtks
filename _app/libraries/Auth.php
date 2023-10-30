<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Auth {

	var $CI = null;

	function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->library( array( 'session' ) );
	}

	function auth_user() {
		$user_info = $this->CI->session->user_info;
		if ( ! $user_info['user_is_login'] ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function privilege_user() {
		$user_info = $this->CI->session->user_info;
		$uri_string = rtrim( uri_string(), "/" );
		$arr_uri = explode( '/', $uri_string );
		$actor = $arr_uri[0];
		$controller = $arr_uri[1];

		$action = str_replace( $actor . '/' . $controller . '/', '', $uri_string );

		$arr_uri_string_true = array(
			'dashboard',
			'admin/systems/profile',
			'admin/systems/password',
			'admin/member/get_member_info/(.*)',
		);

		$is_true = FALSE;
		if ( in_array( 'root', $user_info['user_group'] ) ) {
			$is_true = TRUE;
		} else {
			foreach ( $arr_uri_string_true as $uri_string_true ) {
				if ( preg_match( '/' . str_replace( '/', '\/', rtrim( $uri_string_true, "/" ) ) . '$/', $uri_string ) ) {
					$is_true = TRUE;
				}
			}

			if ( ! $is_true ) {
				$jumlah = count( $user_info['user_group'] );
				$where = ( ( $jumlah > '1' ) ? 'user_role_user_group_id IN (' : 'user_role_user_group_id = ' );

				$no = 1;
				foreach ( $user_info['user_group'] as $user_group_id => $user_group ) {
					disp($user_group_id);
					if ( $jumlah > 1 ) $where .= $user_group_id . ( ( $no < $jumlah ) ? ',' : '' );
					else $where .= $user_group_id;
					$no++;
				}
				$where .= ( ( $jumlah > '1' ) ? ')' : null );

				$sql_user_role = "
					SELECT *
					FROM core_user_role
					LEFT JOIN core_menu ON menu_id = user_role_menu_id
					WHERE $where
				";
				$query_user_role = $this->CI->db->query( $sql_user_role );

				if ( $query_user_role->num_rows() > 0 ) {
					$arr_menu[0] = 'dashboard';
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

	function privilege(){
		$user_info = $this->CI->session->user_info;
		$is_true = false;
		$uri_string = rtrim( uri_string(), "/" );

		if ( in_array( 'root', $user_info['user_group'] ) ) {
			$is_true = true;
		} else {
			$arr_uri_string_true = array(
				'dashboard',
				'dashboard/eksekutif',
				'dashboard/status_proses',
				'dashboard/penyajian_data',
				'admin/maps',
				'verivali/detail_data/get_form_detail/(.*)',
				'verivali/detail_data/get_form_detail_art/(.*)',
				'verivali/detail_data/get_form_detail_kk/(.*)',
				'verivali/detail_data/get_form_detail_anak/(.*)',
				'verivali/detail_data/get_form_detail_usaha/(.*)',
				'verivali/province_published/act_assign/(.*)',
				'verivali/province_published/get_show_data_user/(.*)',
				'admin/systems/profile',
				'admin/systems/password',
				'admin/member/get_member_info/(.*)',
				'config/user/get_form_detail/(.*)',
			);
			foreach ( $arr_uri_string_true as $uri_string_true ) {
				if ( preg_match( '/' . str_replace( '/', '\/', rtrim( $uri_string_true, "/" ) ) . '$/', $uri_string ) ) {
					$is_true = TRUE;
				}
			}
			if ( ! $is_true ){

				$user_menu = $_SESSION['user_menu'];
				$search_funct = $this->CI->uri->segment(1) . '/' . $this->CI->uri->segment(2);
				$in_array = $this->search_array( $search_funct, $user_menu );
				$is_true = ( ( ! empty( $in_array ) ) ? true : false );

				if ( $is_true ) {
					$menu = $user_menu[$in_array[0]][$in_array[1]];
					$segment = $this->CI->uri->segment_array();
					$dir = $segment[1];
					$file = $segment[2];
					$func_full = ( ( isset( $segment[3] ) ) ? $segment[3] : 'show' );
					$func_name = explode( '_', $func_full );
					$func = ( ( count( $func_name ) > 1 ) ? $func_name[1] : $func_name[0] );
					$menu_action = ( ( ! empty( $menu['menu_action'] ) ) ? [$menu['menu_action']] : ['show'] );
					// echo "<pre>";
					// print_r( $user_menu );
					// die;

					$sql_all_action = "
						SELECT menu_action_name
						FROM core_menu_action
					";
					$query_all_act = $this->CI->db->query( $sql_all_action );
					$all_act = [];
					foreach ( $query_all_act->result() as $act ) {
						$all_act[] = $act->menu_action_name;
					}
					if ( in_array( $func, $all_act ) ) {
						if ( in_array( $func, $menu_action ) ) {
							$is_true = true;
						} else {
							$is_true = false;
						}
					} else {
						$is_true = false;
					}
				}
			}
		}
		return $is_true;
	}

	function search_array( $needle, $haystack ) {
		foreach( $haystack as $first_level_key => $value ) {
			if ( $needle === $value ) {
				return array( $first_level_key );
			} else if ( is_array( $value ) ) {
				$callback = $this->search_array( $needle, $value );
				if ( $callback ) {
					return array_merge( array( $first_level_key ), $callback );
				}
			}
		}
		return false;
	}
}

?>
