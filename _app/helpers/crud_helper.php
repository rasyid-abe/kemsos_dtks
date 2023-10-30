<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

	// CREATE, EDIT
if ( ! function_exists( 'save_data' ) ) {
	function save_data( $tabel, $data = null, $where = null ) {
		$CI = & get_instance();
		if ( is_array( $tabel ) ) {
			if ( ! empty( $tabel['where'] ) ) {
				$CI->db->where( $tabel['where'] );
				$id_save = $CI->db->update( $tabel['table'], $tabel['data'] );
			} else {
				$CI->db->insert( $tabel['table'], $tabel['data'] );
				$id_save = $CI->db->insert_id();
			}
		} else {
			if ( ! empty( $where ) ) {
				if ( is_array( $where ) ) {
					if ( count( $where ) > 1 ) {
						foreach ( $variable as $col => $val ) {
							$CI->db->where( $col, $val );
						}
					} else {
						$CI->db->where( $where );
					}
				} else {
					$CI->db->where( $where );
				}
				$CI->db->update( $tabel, $data );
				$id_save = $CI->db->affected_rows();
			} else {
				$CI->db->insert( $tabel, $data );
				$id_save = $CI->db->insert_id();
			}
		}

		return $id_save;
	}
}

	// DELETE
if ( ! function_exists( 'delete_data' ) ) {
	function delete_data( $tabel, $column = null, $id = null) {
		$CI = & get_instance();
		if ( is_array( $tabel ) ) {
			foreach( $tabel['where'] as $w => $an ) {
				if ( is_null( $an ) ) $CI->db->where( $w, null, false );
				else $CI->db->where( $w, $an );
			}
			return $CI->db->delete( $tabel['table'] );
		} else {
			if ( ! empty( $column ) ) {
				if ( is_array( $column ) ) $CI->db->where( $column );
				else $CI->db->where( $column, $id );
			}
			return $CI->db->delete( $tabel );
		}
	}
}

	// READ
if ( ! function_exists( 'get_data' ) ) {
	function get_data( $param, $is_array = 0 ) {
		/*
			$param['table'] 		-> string or array
			$param['select']		-> string
			$param['where']			-> array
			$param['group_by']		-> string
			$param['order_by']		-> string
			$param['not_in']		-> array
			$param['limit']			-> int
			$param['offset']		-> int
		*/
		// SELECT
		$CI = & get_instance();
		if ( ! empty( $param['select'] ) ) {
			$CI->db->select( $param['select'], false );
		}

		// FROM
		if ( is_array( $param['table'] ) ) {
			$n = 1;
			foreach( $param['table'] as $tab => $on ) {
				if ( $n > 1 ) {
					if ( is_array( $on ) ) {
						$CI->db->join( $tab, $on[0], $on[1] );
					} else {
						$CI->db->join( $tab, $on );
					}
				} else {
					$CI->db->from( $tab );
				}
				$n++;
			}
		} else {
			$CI->db->from( $param['table'] );
		}

		// WHERE
		if ( ! empty( $param['where'] ) ) {
			foreach( $param['where'] as $w => $an ) {
				if ( is_null( $an ) ){
					$CI->db->where( $w, null, false );
				}else {
					$CI->db->where( $w, $an );
				}
			}
		}

		// WHERE IN
		if ( ! empty( $param['where_in'] ) ) {
			foreach( $param['where_in'] as $w => $an ) {
				$CI->db->where_in( $w, $an );
				// if ( is_null( $an ) ){
				// 	$CI->db->where_in( $w, null, false );
				// }else {
				// }
			}
		}

		// NOT IN
		if ( ! empty( $param['not_in'] ) ) {
			if ( is_array( $param['not_in'] ) ) {
				foreach( $param['not_in'] as $w => $an ) {
					if ( is_null( $an ) ) {
						$CI->db->where_not_in( $w, null, false );
					}else {
						$CI->db->where_not_in( $w, $an );
					}
				}
			} else {
				$CI->db->where_not_in($param['not_in'],$param['not_in_isi']);
			}
		}

		// LIMIT, OFFSET
		if ( ! empty( $param['limit'] ) && ! empty( $param['offset'] ) ) {
			$CI->db->limit( $param['limit'], $param['offset'] );
		} else if ( ! empty( $param['limit'] ) && empty( $param['offset'] ) ) {
			$CI->db->limit( $param['limit'] );
		}

		// LIKE
		if ( ! empty( $param['like'] ) ) {
			$srch = [];
			foreach( $param['like'] as $sc => $vl ) {
				if ( $vl != NULL ) $srch[] = $sc . " LIKE '%" . $vl . "%'";
			}

			if ( count( $srch ) > 0 ) $CI->db->where( '(' . implode(' OR ', $srch ) . ')', null, false );

		}

		// ORDER_BY
		if ( ! empty( $param['order_by'] ) ) {
			$CI->db->order_by( $param['order_by'] );
		}

		// GROUP_BY
		if ( ! empty( $param['group_by'] ) ) {
			$CI->db->group_by( $param['group_by'] );
		}
		$query = $CI->db->get();

		return ( ( $is_array ) ? $query->result_array() : $query ) ;
	}
}

if ( ! function_exists( 'combo_box' ) ) {
	function combo_box($param = array()) {
		$combo 		= false;

		if(!empty($param['pilih'])) {
			$combo 		= array(
				'' 			=> !empty($param['pilih']) ? $param['pilih']:'-- Pilih --');
		}
		foreach($param['data_combo'] as $row) {
			$valueb 	= array();

			if (is_array($param['val'])) {
				foreach($param['val'] as $v) {
					if (is_array($v)) {
						if ($v[0] == "(") $valueb[] = "(".$row->$v[1].")";
					} else {
						$valueb[] = $row->$v;
					}
				}
			} else {
				$valueb[] = $row->$param['val'];
			}
			$keyb = array();
			if (is_array($param['key'])) {
				foreach($param['key'] as $k) { $keyb[] = (strlen($row->$k) > 100)?substr($row->$k,0,100).' ...':$row->$k; }
			}
			$keyv = is_array($param['key']) ? implode("|",$keyb) : $row->$param['key'];

			$combo[$keyv] = implode(" ",$valueb);
		} return $combo;
	}
}

if ( ! function_exists( 'data_query' ) ) {
	function data_query( $sql = null ){
		$CI 	= & get_instance();
		return $CI->db->query( $sql );
	}
}
