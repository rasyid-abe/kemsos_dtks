<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_terkonfirmasi_tidak_padan extends Login_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->dir = base_url('rekap_terkonfirmasi_tidak_padan/');
		$this->load->model('auth_model');
	}

	function index()
	{
		$this->show();
	}

	function show()
	{
		$data = array();
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
		$data['title'] = 'Publish Data Pusat (P0)';
		$this->load->view('view_rekap', $data);
		// $this->template->title($data['title']);
		// $this->template->content("view_rekap", $data);
		// $this->template->show('themes/admin/able/index');
	}

	function get_show_data()
	{
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search = $this->input->post("search");
		$search = $search['value'];

		$col = 0;
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		$input['s_sumber'] != '' ? $where .= "sumber_data = " . $input['s_sumber'] . " AND " : '';
		$input['s_pengecekan'] != '' ? $where .= "status_pengecekan = " . $input['s_pengecekan'] . " AND " : '';
		$input['s_stereotype'] != '' ? $where .= "stereotype_art = '" . $input['s_stereotype'] . "' AND " : '';
		$input['s_art'] != '' ? $where .= "nama_art LIKE '%" . $input['s_art'] . "%' AND " : '';

		if ($input['s_prov'] != 0) {
			if ($input['s_prov'] != 0 && $input['s_regi'] == 0 && $input['s_dist'] == 0 && $input['s_vill'] == 0) {
				$region = $input['s_prov'];
			} elseif ($input['s_regi'] != 0 && $input['s_dist'] == 0 && $input['s_vill'] == 0) {
				$region = $input['s_prov'] . $input['s_regi'];
			} elseif ($input['s_dist'] != 0 && $input['s_vill'] == 0) {
				$region = $input['s_prov'] . $input['s_regi'] . $input['s_dist'];
			} elseif ($input['s_vill'] != 0) {
				$region = $input['s_prov'] . $input['s_regi'] . $input['s_dist'] . $input['s_vill'];
			}

			$where .= "bps_full_code like '" . $region . "%' AND ";
		}

		$where_in = '';
		if ($input['s_isin'] != '') {
			$temp = explode(" ", $input['s_isin']);
			$data_in = "'" . implode("','", $temp) . "'";
			$where_in = 'AND id_prelist IN' . ' (' . $data_in . ')';
		}
		if ($input['s_notin'] != '') {
			$temp = explode(" ", $input['s_notin']);
			$data_in = "'" . implode("','", $temp) . "'";
			$where_in = 'AND id_prelist NOT IN' . ' (' . $data_in . ')';
		}

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
			0 => 'stereotype',
			1 => 'id_prelist',
			2 => 'nama_krt',
			3 => 'province_name',
			4 => 'regency_name',
			5 => 'district_name',
			6 => 'village_name',
			7 => 'alamat',
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
			SELECT * FROM _rekap_terkonfirmasi_tidak_padan_28Nov
			WHERE $where 1=1 $where_in
			ORDER BY $order_by OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
		";

		$gen_data = $this->db->query($sql);
		// print_r($gen_data->result());
		// die;
		$data = array();
		$no = 1;
		foreach ($gen_data->result() as $rows) {
			$action = '<button type="button" data-backdrop="static" data-keyboard="false" data-id="' . $rows->id . '" data-proses_id="' . $rows->proses_id . '" class="btn btn-sm btn-info edit_rekap" data-toggle="modal" data-target="#exampleModalLong"><i class="fa fa-pencil"></i></button>';
			$status = '<span class="badge badge-pill ' . $rows->stereotype_art . '">' . $rows->stereotype_art . '</span>';
			$data[] = array(
				$action,
				$status,
				$rows->id_prelist,
				$rows->nama_art,
				$rows->nik,
				$rows->sumber_data,
				$rows->status_pengecekan,
				$rows->province_name,
				$rows->regency_name,
				$rows->district_name,
				$rows->village_name,
			);
		}
		$sql_total = "SELECT COUNT(*) as num FROM _rekap_terkonfirmasi_tidak_padan_28Nov WHERE $where 1=1 $where_in";
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
		if (isset($result)) return $result->num;
		return 0;
	}

	function get_edit_rekap()
	{
		$proses_id = $this->input->post('proses_id', true);
		$id = $this->input->post('id', true);

		$data_rekap = $this->db->get_where('_rekap_terkonfirmasi_tidak_padan_28Nov', ['proses_id' => $proses_id, 'id' => $id])->row_array();
		$sql = "
		SELECT kk.nokk, kk.nuk, fl.internal_filename
		FROM master_kartu_keluarga kk
		LEFT JOIN files fl ON kk.id = fl.owner_id
		WHERE kk.proses_id = $proses_id AND fl.stereotype = 'F-KK' AND kk.row_status != 'DELETED'
		ORDER BY fl.created_on DESC
		";
		$data_foto = $this->db->query($sql)->result_array();

		$url = 'https://api-mkdtks.kemensos.go.id/';
		$data = [];
		for ($i = 0; $i < count($data_foto); $i++) {
			$data[] = [
				'proses_id' => $data_rekap['proses_id'],
				'nama_art' => $data_rekap['nama_art'],
				'nik' => $data_rekap['nik'],
				'nuk' => $data_foto[$i]['nuk'],
				'nokk' => $data_foto[$i]['nokk'],
				'sumber_data' => $data_rekap['sumber_data'],
				'status_pengecekan' => $data_rekap['status_pengecekan'],
				'internal_filename' => '<a href="' . $url . substr($data_foto[$i]['internal_filename'], 2) . '" target="_blank">
				<img src="' . $url . substr($data_foto[$i]['internal_filename'], 2) . '" style="height:150px;width:150px">
			</a>',
			];
		}
		echo json_encode($data);
	}

	function act_edit_rekap()
	{
		$input = $this->input->post();
		$data = [
			'nama_art' => $input['nama_art'],
			'nik' => $input['nik'],
			'sumber_data' => $input['sumber_data'],
			'status_pengecekan' => $input['status_pengecekan'],
			'stereotype_art' => 'Q1q',
			'lastupdate_on' => date('Y-m-d H:i:s'),
		];

		$this->db->where('proses_id', $input['proses_id']);
		$this->db->where('id', $input['id']);
		$upd = $this->db->update('_rekap_terkonfirmasi_tidak_padan_28Nov', $data);
		// $upd = false;
		if ($upd) {
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	function form_cari()
	{
		$user_location = $this->get_user_location();
		$jml_negara = count(explode(',', $user_location['country_id']));
		$jml_propinsi = count(explode(',', $user_location['province_id']));
		$jml_kota = count(explode(',', $user_location['regency_id']));
		$jml_kecamatan = count(explode(',', $user_location['district_id']));
		$jml_kelurahan = count(explode(',', $user_location['village_id']));

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_status = '<option value="0">Semua Status</option>';
		$option_hasil_musdes = '<option value="0">Semua Hasil Musdes</option>';
		$option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

		$where_propinsi = [];

		if (!empty($user_location['province_id'])) {
			if ($jml_propinsi > '0') $where_propinsi['province_id ' . (($jml_propinsi >= '2') ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}")] = null;
		}

		$params_propinsi = [
			'table' => 'dbo.vw_administration_regions',
			'select' => 'DISTINCT kode_propinsi, propinsi',
			'where' => $where_propinsi,
			'order_by' => 'propinsi',
		];
		$query_propinsi = get_data($params_propinsi);
		foreach ($query_propinsi->result() as $key => $value) {
			if ($value->propinsi != '') {
				if ($jml_propinsi == '1' && !empty($user_location['province_id'])) {
					$option_propinsi = '<option value="' . $value->kode_propinsi . '" selected>' . $value->propinsi . '</option>';
				} else {
					$option_propinsi .= '<option value="' . $value->kode_propinsi . '">' . $value->propinsi . '</option>';
				}
			}
		}


		if ($jml_propinsi == '1') {
			$where_kota = [];
			if (!empty($user_location['regency_id'])) {
				if ($jml_kota > '0') $where_kota['regency_id ' . (($jml_kota >= '2') ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}")] = null;
			} else {
				$where_kota['province_id'] = $user_location['province_id'];
			}
			$params_kota = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT kode_kabupaten, kabupaten',
				'where' => $where_kota,
				'order_by' => 'kabupaten',
			];
			$query_kota = get_data($params_kota);
			foreach ($query_kota->result() as $key => $value) {
				if ($jml_kota == '1' && !empty($user_location['regency_id'])) {
					$option_kota = '<option value="' . $value->kode_kabupaten . '" selected>' . $value->kabupaten . '</option>';
				} else {
					$option_kota .= '<option value="' . $value->kode_kabupaten . '">' . $value->kabupaten . '</option>';
				}
			}
		}

		if ($jml_kota == '1') {
			$where_kecamatan = [];
			if (!empty($user_location['district_id'])) {
				if ($jml_kecamatan > '0') $where_kecamatan['district_id ' . (($jml_kecamatan >= '2') ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}")] = null;
			} else {
				$where_kecamatan['regency_id'] = $user_location['regency_id'];
			}
			$params_kecamatan = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT kode_kecamatan, kecamatan',
				'where' => $where_kecamatan,
				'order_by' => 'kecamatan',
			];
			$query_kecamatan = get_data($params_kecamatan);
			foreach ($query_kecamatan->result() as $key => $value) {
				if ($jml_kecamatan == '1' && !empty($user_location['district_id'])) {
					$option_kecamatan = '<option value="' . $value->kode_kecamatan . '" selected>' . $value->kecamatan . '</option>';
				} else {
					$option_kecamatan .= '<option value="' . $value->kode_kecamatan . '">' . $value->kecamatan . '</option>';
				}
			}
		}

		if ($jml_kecamatan == '1') {
			$where_kelurahan = [];
			if (!empty($user_location['village_id'])) {
				if ($jml_kelurahan > '0') $where_kelurahan['village_id ' . (($jml_kelurahan >= '2') ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}")] = null;
			} else {
				$where_kelurahan['district_id'] = $user_location['district_id'];
			}
			$params_kelurahan = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT village_id, kelurahan',
				'where' => $where_kelurahan,
				'order_by' => 'kelurahan',
			];
			$query_kelurahan = get_data($params_kelurahan);
			foreach ($query_kelurahan->result() as $key => $value) {
				if ($jml_kelurahan == '1' && !empty($user_location['village_id'])) {
					$option_kelurahan = '<option value="' . $value->village_id . '" selected>' . $value->kelurahan . '</option>';
				} else {
					$option_kelurahan .= '<option value="' . $value->village_id . '">' . $value->kelurahan . '</option>';
				}
			}
		}

		$form_cari = '
			<div class="row"">
				<div class="form-group col-md-3">
					<select id="select-propinsi" name="propinsi" style="width:100%" class="select2 form-control" ' . ((($jml_propinsi == '1') && (!empty($user_location['province_id']))) ? 'disabled ' : '') . '>
						' . $option_propinsi . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kabupaten" name="kabupaten" style="width:100%" class="select2 form-control" ' . ((($jml_kota == '1') && (!empty($user_location['regency_id']))) ? 'disabled ' : '') . '>
						' . $option_kota . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kecamatan" name="kecamatan" style="width:100%" class="select2 form-control" ' . ((($jml_kecamatan == '1') && (!empty($user_location['district_id']))) ? 'disabled ' : '') . '>
						' . $option_kecamatan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kelurahan" name="kelurahan" style="width:100%" class="select2 form-control" >
						' . $option_kelurahan . '
					</select>
				</div>
			</div>


		';
		return $form_cari;
	}

	function get_user_location()
	{
		$user_location = ['100000'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '0';
		$regency_id = '0';
		$district_id = '0';
		$village_id = '0';
		if (!empty($user_location)) {
			$count = count($user_location);
			$no = 1;
			foreach ($user_location as $loc) {
				$params_location = [
					'table' => 'dbo.ref_locations',
					'where' => [
						'location_id' => $loc
					]
				];
				$query = get_data($params_location);
				$country_id = $query->row('country_id') . (($no < $count) ? ',' : '');
				$province_id = $query->row('province_id') . (($no < $count) ? ',' : '');
				$regency_id = $query->row('regency_id') . (($no < $count) ? ',' : '');
				$district_id = $query->row('district_id') . (($no < $count) ? ',' : '');
				$village_id = $query->row('village_id') . (($no < $count) ? ',' : '');
				$no++;
			}
		}
		$res_loc = [
			'country_id' => $country_id,
			'province_id' => $province_id,
			'regency_id' => $regency_id,
			'district_id' => $district_id,
			'village_id' => $village_id,
		];
		return $res_loc;
	}

	function get_show_location()
	{
		if ($_GET['title'] == "Kabupaten") {
			$select = 'bps_regency_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		} elseif ($_GET['title'] == "Kecamatan") {
			$select = 'bps_district_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'bps_regency_code' => $_GET['bps_regency_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		} elseif ($_GET['title'] == "Kelurahan") {
			$select = 'bps_village_code';
			$params = [
				'table' => 'ref_locations',
				'where' => [
					'bps_province_code' => $_GET['bps_province_code'],
					'bps_regency_code' => $_GET['bps_regency_code'],
					'bps_district_code' => $_GET['bps_district_code'],
					'stereotype' => $_GET['stereotype']
				],
				'select' => $select . ', full_name',
			];
		}

		$query = get_data($params);
		$data = [];
		foreach ($query->result_array() as $key => $value) {
			$data[$value[$select]] = $value['full_name'];
		}
		echo json_encode($data);
	}
}
