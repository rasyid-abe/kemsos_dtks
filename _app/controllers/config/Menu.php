<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'config/menu/' );
		$this->id = $this->session->userdata('user_info');
        $this->json = [];
	}

	function index($par = 0) {
		$this->show($par);
	}

	function show($par) {
		$data = array();

		$params_parent = [
			'select' => 'menu_name, menu_id',
			'table' => 'core_menu',
			'where' => ['menu_id' => $par],
		];
		$data['query_parent'] = get_data( $params_parent )->row();
		$params_action = [
			'table' => 'core_menu_action',
			'sort_by' => 'core_menu_id'
		];
		$data['query_action'] = get_data( $params_action )->result();

		$data['base_url'] = $this->dir;
		$data['title'] = 'Menu';
		$data['menu_parent'] = $par;
		$this->template->title( $data['title'] );
		$this->template->content( "config/view_menu", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_data(){
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search= $this->input->post("search");
		$search = $search['value'];

		$col = 0;
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		$input['s_par'] != '' ? $where .= "menu_parent_menu_id = '" . $input['s_par'] . "' AND " : '';
		$input['s_name'] != '' ? $where .= "menu_name LIKE '%" . $input['s_name'] . "%' AND " : '';
		$input['s_url'] != '' ? $where .= "menu_url LIKE '%" . $input['s_url'] . "%' AND " : '';
		$input['s_clas'] != '' ? $where .= "menu_class LIKE '%" . $input['s_clas'] . "%' AND " : '';

		if(!empty($order)) {
			foreach($order as $o) {
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}

		if($dir != "asc" && $dir != "desc") {$dir = "desc";}

		$valid_columns = array(
			0=>'menu_name',
			1=>'menu_slug',
			2=>'menu_sub',
			3=>'menu_url',
			4=>'menu_class',
			5=>'menu_description',
			6=>'menu_is_active',
		);

		if(!isset($valid_columns[$col])) {$order = null;}
		else {$order = $valid_columns[$col];}

		if($order !=null) {$order_by = $order .' '. $dir;}

		$sql = "
		SELECT * FROM core_menu
		WHERE $where 1=1
		ORDER BY $order_by OFFSET $start ROWS
		FETCH NEXT $length ROWS ONLY
		";

        $gen_data = $this->db->query($sql);
        $data = array();
        foreach($gen_data->result() as $rows)
        {
			$parent = '<a href="' . base_url('config/menu/index/'. $rows->menu_id) . '" class="btn btn-info btn-sm"><i class="fa fa-list"></i></a>';
			$active = $rows->menu_is_active != 1 ? '<h5 class="text-warning"><i class="fa fa-star-o"></i></h5>' : '<h5 class="text-warning"><i class="fa fa-star"></i></h5>';
			$edit = '<button data-toggle="modal" class="btn btn-warning btn-sm modal_em" data-id="'.$rows->menu_id.'" data-toggle="modal" data-target=".modal_form_menu" data-backdrop="static" data-keyboard="false"><i class="fa fa-pencil"></i></button>';

            $data[]= array(
				$edit,
				$rows->menu_name,
				$rows->menu_slug,
				$parent,
				$rows->menu_url,
				$rows->menu_class,
				$rows->menu_description,
				$active,
				$rows->menu_id,
			);
		}
		$sql_total = "SELECT COUNT(*) as num FROM core_menu WHERE $where 1=1";
		$total_data = $this->totalData($sql_total);
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $total_data,
			"recordsFiltered" => $total_data,
			"data" => $data
		);
		echo json_encode($output);
		exit();
    }

	function totalData($sql_total)
	{
		$query = $this->db->query($sql_total);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}

	function data_edit()
	{
		$id = $this->input->post('id', true);
		$data = $this->db->get_where('core_menu', ['menu_id' => $id])->row_array();

		$params_action = [
			'table' => 'core_menu_action',
			'sort_by' => 'core_menu_id'
		];
		$query_action = get_data( $params_action )->result();

		$result = [
			'data' => $data,
			'action' => $query_action,
		];

		echo json_encode($result);
	}

	function store_menu()
	{
		$input = $this->input->post();
		$sql = "
			SELECT max(menu_sort) max_sort
			FROM core_menu
			WHERE menu_parent_menu_id = '" . $input['parent_menu'] . "'
		";
		$query = data_query( $sql );
		$last_sort = $query->row( 'max_sort' );
        $menu_action = ( ( ! empty( $input['menu_action'] ) ) ? $input['menu_action'] : [] );

		if ($input['menu_id'] == '') {
			$data_save = [
				'menu_parent_menu_id' => $input['parent_menu'],
				'menu_name' => $input['menu_name'],
				'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
				'menu_url' => $input['menu_url'],
				'menu_description' => $input['menu_description'],
				'menu_class' => $input['menu_class'],
				'menu_action' => json_encode( array_merge( ['show'], $menu_action ) ),
				'menu_sort' => $last_sort + 1,
				'menu_is_active' => '1',
			];

			$input = $this->db->insert('core_menu', $data_save);
			if ( $input ){
				$result = [
					'status' => 200,
					'pesan' => 'Menu Berhasil Disimpan !',
				];
			} else {
				$result = [
					'status' => 500,
					'pesan' => 'Menu Gagal Disimpan !',
				];
			}
		} else {
			$data_upd = [
				'menu_name' => $input['menu_name'],
				'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
				'menu_url' => $input['menu_url'],
				'menu_description' => $input['menu_description'],
				'menu_class' => $input['menu_class'],
				'menu_action' => json_encode( array_merge( ['show'], $menu_action ) ),
			];

			$this->db->where('menu_id', $input['menu_id']);
			$input = $this->db->update('core_menu', $data_upd);
			if ( $input ){
				$result = [
					'status' => 200,
					'pesan' => 'Menu Berhasil Diubah !',
				];
			} else {
				$result = [
					'status' => 500,
					'pesan' => 'Menu Gagal Diubah !',
				];
			}
		}

		echo json_encode( $result );

	}

	function act_active()
	{
		$ids = $this->input->post('params', true)[0];
		$sts = $this->input->post('params', true)[1];
		$txt = $sts > 0 ? 'diaktifkan' : 'dinonaktifkan';

		$sukses = $gagal = 0;
		for ($i=0; $i < count($ids); $i++) {
			$this->db->where('menu_id', $ids[$i]);
			$update = $this->db->update('core_menu', ['menu_is_active' => $sts]);
			if ($update) {
				$sukses++;
			} else {
				$gagal++;
			}
		}

		$result = [
			'status' => 'sukses',
			'pesan' => $sukses . ' menu berhasil '.$txt.'. ' . $gagal .' menu gagal '.$txt.'.',
		];

		echo json_encode($result);
	}

	function act_delete()
	{
		$ids = $this->input->post('params', true)[0];

		$sukses = $gagal = 0;
		for ($i=0; $i < count($ids); $i++) {
			$this->db->where('menu_id', $ids[$i]);
			$delete = $this->db->delete('core_menu');

			if ($delete) {
				$sukses++;
			} else {
				$gagal++;
			}
		}

		$result = [
			'status' => 'sukses',
			'pesan' => $sukses . ' menu berhasil dihapus. ' . $gagal .' menu gagal dihapus.',
		];

		echo json_encode($result);
	}

    function get_form(){
		$par = isset( $_GET['par'] ) ? dec( $_GET['par'] ) : null;
        $data = [];
		if ( ( isset( $par['menu_id'] ) ) && ! empty( $par['menu_id'] ) ) {
			$data['form_title'] = "Edit Menu";
			$data['form_action'] = base_url( 'config/menu' . '/act_edit' );
			$params_detail = [
				'select' => 'menu_name, menu_url, menu_class, menu_action, menu_description',
				'table' => 'core_menu',
				'where' => [
					'menu_id' => $par['menu_id'],
				],
			];
			$query = get_data( $params_detail );
			$row = $query->row();
		} else {
			$data['form_title'] = "Tambah Menu";
			$data['form_action'] = base_url( 'config/menu' . '/act_save' );
			$row = [];
		}
		$params_parent = [
			'select' => 'menu_name',
			'table' => 'core_menu',
			'where' => ['menu_id' => $par['parent_id']],
		];
		$query_parent = get_data( $params_parent );
		$params_action = [
			'table' => 'core_menu_action',
			'sort_by' => 'core_menu_id'
		];
		$query_action = get_data( $params_action );
		$disp_menu_action = '';
		$jumlah_action = $query_action->num_rows();
		$jumlah_per_row = ceil( $jumlah_action / 3 );
		foreach ( $query_action->result() as $key => $value ) {
			$disp_menu_action .= '
			<div class="col-4">
				<div class="custom-control custom-checkbox">
					<input name="menu_action[]" class="custom-control-input" type="checkbox" id="customCheckbox_' . ( $value->menu_action_id ) . '" value="' . $value->menu_action_name . '"  ' . ( ( $value->menu_action_name == 'show' ) ? 'checked disabled' : '' ) . '>
					<label for="customCheckbox_' . ( $value->menu_action_id ) . '" class="custom-control-label">' . $value->menu_action_title . '</label>
				</div>
			</div>';
		}
        $data['form_data'] = '
            <div class="row col-12">
				<div class="col-12">
					<label class="col-6">Menu Parent</label>
					<div class="col-6 form-group">
						<input type="text" class="form-control" value="' . $query_parent->row('menu_name') . '" readonly>
					</div>
				</div>
                <div class="col-md-6">
                    <label class="col-12">Menu Name</label>
                    <div class="col-12 form-group">
						<input type="hidden" name="parent_menu" value="' . ( ( ( isset( $par['parent_id'] ) ) && ! empty( $par['parent_id'] ) ) ? $par['parent_id'] : "0" ) . '">
						<input type="hidden" name="menu_id" value="' . ( ( ( isset( $par['menu_id'] ) ) && ! empty( $par['menu_id'] ) ) ? $par['menu_id'] : "0" ) . '">
                        <input class="form-control" name="menu_name" value="' . ( ( empty( $row ) ) ? '' : $row->menu_name ) . '" required >
                    </div>
                    <label class="col-12">Menu Class Icon</label>
                    <div class="col-12 form-group">
                        <input class="form-control" name="menu_class" value="' . ( ( empty( $row ) ) ? '' : $row->menu_class ) . '" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="col-12">Menu url</label>
                    <div class="col-12 form-group">
                        <input class="form-control" name="menu_url" value="' . ( ( empty( $row ) ) ? '' : $row->menu_url ) . '" required>
                    </div>
                    <label class="col-12">Menu Description</label>
                    <div class="col-12 form-group">
                        <textarea class="form-control" name="menu_description">' . ( ( empty( $row ) ) ? '' : $row->menu_description ) . '</textarea>
                    </div>
                </div>
				<div class="col-12">
					<label class="col-6">Action :</label>
					<div class="row col-12">' .
						$disp_menu_action . '
					</div>
				</div>
            </div>
        ';
		$this->load->view("general/Form_view", $data);
    }

	function act_edit(){
		$input = $this->input->post();
		$arr_input_menu_action = ( ( isset( $input['menu_action'] ) ) ? $input['menu_action'] : [] );
		$data_save = [
			'menu_parent_menu_id' => $input['parent_menu'],
			'menu_name' => $input['menu_name'],
			'menu_slug' => url_title( $input['menu_name'], 'dash', true ),
			'menu_url' => $input['menu_url'],
			'menu_description' => $input['menu_description'],
			'menu_class' => $input['menu_class'],
			'menu_action' => json_encode( array_merge( ['show'], $arr_input_menu_action ) ),
		];
		$menu_id = save_data( 'core_menu', $data_save, [ 'menu_id' => $input['menu_id'] ] );
		if ( $menu_id ){
			$result = [
				'status' => 200,
				'msg' => 'Data Berhasil Disimpan !',
			];
		} else {
			$result = [
				'status' => 500,
				'msg' => 'Data Gagal Disimpan !',
			];
		}
		echo json_encode( $result );
	}
}
