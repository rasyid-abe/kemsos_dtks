<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checkEmail')) {
	function checkEmail($email)
	{
		if (strpos($email, '@') !== false) {
			$split = explode('@', $email);
			return (strpos($split['1'], '.') !== false ? true : false);
		} else {
			return false;
		}
	}
}

if (!function_exists('randStrGen')) {
	function randStrGen($len)
	{
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789$11";
		$charArray = str_split($chars);
		for ($i = 0; $i < $len; $i++) {
			$randItem = array_rand($charArray);
			$result .= "" . $charArray[$randItem];
		}
		return $result;
	}
}


if (!function_exists('getrolename')) {
	function getrolename($id)
	{
		$ci = &get_instance();
		$rs = (object) $ci->db
			->select('role.name as rolename,user.iduser')
			->join('roleuser', 'user.iduser = roleuser.iduser', 'left')
			->join('role', 'role.idrole = roleuser.idrole', 'left')
			->where('user.iduser', $id)->get('user')->row_array();
		return ($rs->rolename <> null) ? ucwords(strtolower($rs->rolename)) : 'N/A';
	}
}

/* tool */
if (!function_exists('disp')) {
	function disp($data, $title = '')
	{
		echo '<pre>';
		if (!empty($title)) {
			echo "<h3>$title</h3>";
		}
		print_r($data);
		echo '</pre>';
	}
}

/* general */

if (!function_exists('enc')) {
	function enc($data)
	{
		$data_on = base64_encode(serialize($data));
		return preg_replace('/\=+/', '-', $data_on);
	}
}

if (!function_exists('dec')) {
	function dec($data)
	{
		$on_data = preg_replace('/\-+/', '=', $data);
		return unserialize(base64_decode($on_data));
	}
}

if (!function_exists('filter_json')) {
	function filter_json($json)
	{
		$arr_where = [];
		$arr_filter = json_decode($json, true);
		foreach ($arr_filter as $value) {
			if (in_array('op', $value)) {
				if ($value['op'] == 'contains') {
					$arr_where['like'] = [$value['field'] => $value['value']];
				}
			} else {
				$arr_where['like'] = [$value['filter_field'] => $value['filter_value']];
			}
		}
		return $arr_where;
	}
}

if (!function_exists('client_ip')) {
	function client_ip()
	{
		$is_proxy = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//whether ip is from proxy
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$is_proxy = true;
		} else {
			//whether ip is from remote address
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return [
			'ip_address' => $ip_address,
			'is_proxy' => $is_proxy,
		];
	}
}

if (!function_exists('_upload_file')) {
	function _upload_file($data)
	{
		$is_proxy = false;
		$ci = &get_instance();


		$config['upload_path']   = $data['path'];
		$config['allowed_types'] = $data['allow'];
		$config['file_name']     = $data['name'];
		$config['max_size']      = $data['size'];
		$config['overwrite']	 = true;

		$ci->load->library('upload');
		$ci->upload->initialize($config);

		$ext = '.' . explode(".", $data['file']['name'])[1];
		if ($ci->upload->do_upload($data['input'])) {
			$arr_w = [
				'owner_id' => $data['usid'],
				'file_type' => $data['type'],
			];

			$old = $ci->db->get_where('files', $arr_w);

			$save_file = array();
			$save_file['owner_id'] = $data['usid'];
			$save_file['file_name'] = $data['name'] . $ext;
			$save_file['file_size'] = $data['file']['size'];
			$save_file['file_type'] = $data['type'];
			$save_file['internal_filename'] = $data['path'] . $data['name'] . $ext;
			$save_file['description'] = $data['type'] . '-' . $data['usid'];

			if ($old->num_rows() > 0) {
				unlink(FCPATH . $old->row('internal_filename'));
				$save_file['lastupdate_by'] = $data['inby'];
				$save_file['lastupdate_on'] = date('Y-m-d H:i:s');
				$ins = $ci->db->update('files', $save_file, $arr_w);
			} else {
				$save_file['created_by'] = $data['inby'];
				$save_file['created_on'] = date('Y-m-d H:i:s');
				$ins = $ci->db->insert('files', $save_file);
			}


			if ($ins) {
				return $data['name'] . $ext;
			} else {
				echo "insert error!";
				die;
			}
		} else {
			echo $ci->upload->display_errors();
			die;
		}
	}
}

if (!function_exists('_add_access')) {
	function _add_access()
	{
		return _check_access('add');
	}
}

if (!function_exists('_update_access')) {
	function _update_access()
	{
		return _check_access('update');
	}
}

if (!function_exists('_delete_access')) {
	function _delete_access()
	{
		return _check_access('delete');
	}
}

if (!function_exists('_export_access')) {
	function _export_access()
	{
		return _check_access('export');
	}
}

if (!function_exists('_activate_access')) {
	function _activate_access()
	{
		return _check_access('activate');
	}
}

if (!function_exists('_deactivate_access')) {
	function _deactivate_access()
	{
		return _check_access('deactivate');
	}
}

if (!function_exists('_import_access')) {
	function _import_access()
	{
		return _check_access('import');
	}
}

if (!function_exists('_download_access')) {
	function _download_access()
	{
		return _check_access('download');
	}
}

if (!function_exists('_update_password_access')) {
	function _update_password_access()
	{
		return _check_access('update_password');
	}
}

if (!function_exists('_approve_access')) {
	function _approve_access()
	{
		return _check_access('approve');
	}
}

if (!function_exists('_reject_access')) {
	function _reject_access()
	{
		return _check_access('reject');
	}
}

if (!function_exists('_cancel_access')) {
	function _cancel_access()
	{
		return _check_access('cancel');
	}
}

if (!function_exists('_closed_access')) {
	function _closed_access()
	{
		return _check_access('closed');
	}
}

if (!function_exists('_receive_access')) {
	function _receive_access()
	{
		return _check_access('receive');
	}
}

if (!function_exists('_show_access')) {
	function _show_access()
	{
		return _check_access('show');
	}
}

if (!function_exists('_print_access')) {
	function _print_access()
	{
		return _check_access('print');
	}
}

if (!function_exists('_review_access')) {
	function _review_access()
	{
		return _check_access('review');
	}
}

if (!function_exists('_check_access')) {
	function _check_access($action)
	{
		$ci = &get_instance();
		$access = false;
		$url = $ci->uri->slash_segment(1) . $ci->uri->segment(2);
		$arr_menu = $ci->session->userdata('user_menu');

		$menu_id = '';
		foreach ($arr_menu as $v1) {
			foreach ($v1 as $v2) {
				if ($url == $v2['menu_url']) {
					$menu_id = $v2['menu_id'];
					break;
				}
			}
		}

		$ci->db->where(['user_role_menu_action <>' => null, 'user_role_menu_id' => $menu_id]);
		$menu_act = $ci->db->get('core_user_role')->result_array();

		foreach ($menu_act as $val) {
			if ($action == 'show') {
				$access = true;
				break;
			} else if ($action == $val['user_role_menu_action']) {
				$access = true;
				break;
			}
		}

		return $access;
	}
}
