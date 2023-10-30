<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_group extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->json = [];
		$this->dir = "user_group/";
	}

	function index()
	{
		$this->show();
	}

	function show()
	{
		if (_show_access()) {
			$data = array();
			$data['base_url'] = $this->dir;
			$data['title'] = 'User Group Management';
			$this->template->title($data['title']);
			$this->template->content("config/view_user_group", $data);
			$this->template->show(THEMES_BACKEND . 'index');
		} else {
			return redirect('config/err');
		}
	}

	function get_show_data()
	{
		if (_show_access()) {
			$draw = intval($this->input->post("draw"));
			$start = intval($this->input->post("start"));
			$length = intval($this->input->post("length"));
			$order = $this->input->post("order");
			$search = $this->input->post("search");
			$search = $search['value'];

			$col = 0;
			$where = $region = $dir = $order_by = '';
			$input = $this->input->post();

			$input['s_user_g'] != '' ? $where .= "user_group_name LIKE '%" . $input['s_user_g'] . "%' AND " : '';

			if (!empty($order)) {
				foreach ($order as $o) {
					$col = $o['column'];
					$dir = $o['dir'];
				}
			}

			if ($dir != "asc" && $dir != "desc") {
				$dir = "desc";
			}

			$valid_columns = array(
				0 => 'user_group_title',
				1 => 'user_group_id',
				2 => 'user_group_name',
				3 => 'user_group_description',
				4 => 'user_account_is_active'
			);

			if (!isset($valid_columns[$col])) {
				$order = null;
			} else {
				$order = $valid_columns[$col];
			}

			if ($order != null) {
				$order_by = $order . ' ' . $dir;
			}

			$sql = "
				SELECT user_group_id, user_group_name, user_group_title, user_group_description, user_group_is_active
				FROM core_user_group
				WHERE $where 1=1
				ORDER BY user_group_id OFFSET $start ROWS
				FETCH NEXT $length ROWS ONLY
			";

			$gen_data = $this->db->query($sql);
			$data = array();
			foreach ($gen_data->result() as $rows) {
				$is_active = '<i class=" ' . (($rows->user_group_is_active == '0') ? 'ft-user-x' : 'ft-user-check') . '" style=";font-size:16px;' . (($rows->user_group_is_active == '0') ? 'color:red;' : 'color:green;') . '"></i>';

				$edit = '<a href="#" class="btn btn-outline-info btn-sm md_edit" data-id="' . $rows->user_group_id . '" data-toggle="modal" data-target="#modal_group" name="button" data-backdrop="static" data-keyboard="false" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="#" class="btn btn-outline-secondary btn-sm config_role" data-id="' . $rows->user_group_id . '" title="Menu" data-toggle="modal" data-target="#modal_role_menu" name="button" data-backdrop="static" data-keyboard="false"><i class="fa fa-th-list"></i></a>';

				$data[] = array(
					$edit,
					$rows->user_group_id,
					$rows->user_group_title,
					$rows->user_group_name,
					$rows->user_group_description,
					$is_active,
				);
			}
			$sql_total = "SELECT COUNT(*) as num FROM core_user_group WHERE $where 1=1";
			$total_data = $this->totalData($sql_total);
			$output = array(
				"draw" => $draw,
				"recordsTotal" => $total_data,
				"recordsFiltered" => $total_data,
				"data" => $data
			);
			echo json_encode($output);
			exit();
		} else {
			return redirect('config/err');
		}
	}

	function totalData($sql_total)
	{
		$query = $this->db->query($sql_total);
		$result = $query->row();
		if (isset($result)) return $result->num;
		return 0;
	}

	function store_group()
	{
		if (_add_access()) {
			$input = $this->input->post();
			$data_save = [
				'user_group_title' => $input['name'],
				'user_group_name' => url_title($input['name'], 'dash', true),
				'user_group_description' => $input['deskripsi'],
				'user_group_is_active' => '1'
			];

			$pesan = '';
			if ($input['id'] != '') {
				$this->db->where('user_group_id', $input['id']);
				$act = $this->db->update('core_user_group', $data_save);
				$pesan = 'diubah!';
			} else {
				$act = $this->db->insert('core_user_group', $data_save);
				$pesan = 'ditambah!';
			}

			if ($act) {
				$result = [
					'status' => true,
					'pesan' => 'User grup berhasil di ' . $pesan,
				];
			} else {
				$result = [
					'status' => true,
					'pesan' => 'User grup gagal di ' . $pesan,
				];
			}

			echo json_encode($result);
		} else {
			return redirect('config/err');
		}
	}

	function act_save()
	{
		if (_add_access()) {
			$input = $this->input->post();

			$data_save = [
				'user_group_title' => $input['nama_group'],
				'user_group_name' => url_title($input['nama_group'], 'dash', true),
				'user_group_description' => $input['deskripsi'],
				'user_group_is_active' => '1'
			];
			$this->db->insert('core_user_group', $data_save);
			return redirect('config/user_group');
		} else {
			return redirect('config/err');
		}
	}

	function data_edit()
	{
		if (_update_access()) {
			$id = $this->input->post('id', true);
			$data = $this->db->get_where('core_user_group', ['user_group_id' => $id])->row_array();

			echo json_encode($data);
		} else {
			return redirect('config/err');
		}
	}

	function act_active()
	{
		if (_activate_access()) {
			$ids = $this->input->post('params', true)[0];
			$sts = $this->input->post('params', true)[1];
			$txt = $sts > 0 ? 'diaktifkan' : 'dinonaktifkan';

			$sukses = $gagal = 0;
			for ($i = 0; $i < count($ids); $i++) {
				$this->db->where('user_group_id', $ids[$i]);
				$update = $this->db->update('core_user_group', ['user_group_is_active' => $sts]);
				if ($update) {
					$sukses++;
				} else {
					$gagal++;
				}
			}

			$result = [
				'status' => 'sukses',
				'pesan' => $sukses . ' grup berhasil ' . $txt . '. ' . $gagal . ' grup gagal ' . $txt . '.',
			];

			echo json_encode($result);
		} else {
			return redirect('config/err');
		}
	}

	function act_delete()
	{
		$ids = $this->input->post('params', true)[0];

		$sukses = $gagal = 0;
		for ($i = 0; $i < count($ids); $i++) {
			$this->db->where('user_group_id', $ids[$i]);
			$delete = $this->db->delete('core_user_group');

			if ($delete) {
				$sukses++;
			} else {
				$gagal++;
			}
		}

		$result = [
			'status' => 'sukses',
			'pesan' => $sukses . ' menu berhasil dihapus. ' . $gagal . ' menu gagal dihapus.',
		];

		echo json_encode($result);
	}

	function data_config()
	{
		$role = $this->input->post('role', true);
		$parent = $this->input->post('parent', true);

		$this->db->where('menu_parent_menu_id', $parent != '' ? $parent : '0');
		$this->db->where('menu_is_active !=', '0');
		$this->db->order_by('menu_sort', 'asc');
		$menu = $this->db->get('core_menu')->result_array();
		$arr_role = $this->db->get_where('core_user_role', ['user_role_user_group_id' => $role])->result_array();

		$menu_id = $act_menu_id = $menu_has_child = [];
		foreach ($arr_role as $key => $value) {
			$menu_id[] = $value['user_role_menu_id'];
			$act_menu_id[] = $value['user_role_menu_id'] . $value['user_role_menu_action'];
		}

		for ($i = 0; $i < count($menu); $i++) {
			$cc = $menu[$i]['menu_id'];
			$child_s = $this->db->get_where('core_menu', ['menu_parent_menu_id' => $cc])->num_rows();
			$menu_has_child[] = $child_s > 0 ? 1 : 0;
		}

		$result = [
			'menu' => $menu,
			'has_child' => $menu_has_child,
			'menu_id' => $menu_id,
			'act_menu_id' => $act_menu_id,
		];

		echo json_encode($result);
	}

	// function data_config_child()
	// {
	// 	$role = $this->input->post('role', true);
	// 	$parent = $this->input->post('parent', true);

	// 	$this->db->where('menu_parent_menu_id', $parent);
	// 	$this->db->where('menu_is_active !=', '0');
	// 	$menu = $this->db->get('core_menu')->result_array();
	// 	$arr_role = $this->db->get_where('core_user_role', ['user_role_user_group_id' => $role])->result_array();

	// 	$menu_id = $act_menu_id = [];
	// 	foreach ($arr_role as $key => $value) {
	// 		$menu_id[] = $value['user_role_menu_id'];
	// 		$act_menu_id[] = $value['user_role_menu_id'] . $value['user_role_menu_action'];
	// 	}

	// 	$result = [
	// 		'menu' => $menu,
	// 		'menu_id' => $menu_id,
	// 		'act_menu_id' => $act_menu_id,
	// 	];

	// 	echo json_encode($result);
	// }

	function act_store_role()
	{
		$group = $this->input->post('group', true);
		$menu = $this->input->post('menu', true);
		$action = $this->input->post('action', true);

		$arr_wh = array();
		$arr_wh['user_role_user_group_id'] = (int)$group;
		$arr_wh['user_role_menu_id'] = (int)$menu;
		if ($action != '') {
			$arr_wh['user_role_menu_action'] = $action;
		}

		$row = $this->db->get_where('core_user_role', $arr_wh);

		if ($row->num_rows() > 0) {
			if ($action == 'show') {
				$this->db->where([
					'user_role_user_group_id' => (int)$group,
					'user_role_menu_id' => (int)$menu,
				]);
			} else {
				$this->db->where($arr_wh);
			}
			$db_act = $this->db->delete('core_user_role');
		} else {
			$db_act = $this->db->insert('core_user_role', $arr_wh);
		}

		if ($db_act) {
			$result = [
				'status' => true,
				'pesan' => 'Role grup management berhasil diperbarui!',
			];
		} else {
			$result = [
				'status' => false,
				'pesan' => 'Role grup management Gagal diperbarui!',
			];
		}

		echo json_encode($result);
	}
}
