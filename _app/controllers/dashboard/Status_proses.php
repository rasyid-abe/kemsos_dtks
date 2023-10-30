<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status_Proses extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->dir = base_url('dashboard/status_proses/');
		$this->load->model('auth_model');
		$this->load->model('dashboard_model');
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
		$data['role'] = implode($this->user_info['user_group']);

		$this->template->title('Dashboard Status Proses');
		$this->template->content("admin/dashboard/view_status_proses", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function get_status_ruta()
	{
		$area = $this->input->post('area', true);

		$status_art = $this->dashboard_model->get_status_art($area);
		$status_md = $this->dashboard_model->get_status_query_md_new($area);
		$status_mdd = $this->dashboard_model->get_status_query_mdd_new($area);
		$result = [
			'p0' => $status_md['P0'],
			'p1' => $status_md['P1'],
			'p2' => $status_md['P2'],
			'p3' => $status_md['P3'],
			'm1' => $status_md['M1'],
			'm2' => $status_md['M2'],
			'm4' => $status_md['M4'],
			'm4a' => $status_md['M4a'],
			'mk' => $status_mdd['MK'],
			'mka' => $status_mdd['MKa'],
			'mkb' => $status_mdd['MKb'],
			'q1' => $status_mdd['Q1'],
			'q1a' => $status_mdd['Q1a'],
			'q1b' => $status_mdd['Q1b'],
			'q2' => $status_mdd['Q2'],
			'q2a' => $status_mdd['Q2a'],
			'q2b' => $status_mdd['Q2b'],
			'status_art' => $status_art,
		];

		echo json_encode($result);
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
		];
		$query_propinsi = get_data($params_propinsi);
		foreach ($query_propinsi->result() as $key => $value) {
			if ($jml_propinsi == '1' && !empty($user_location['province_id'])) {
				$option_propinsi = '<option value="' . $value->kode_propinsi . '" selected>' . $value->propinsi . '</option>';
			} else {
				$option_propinsi .= '<option value="' . $value->kode_propinsi . '">' . $value->propinsi . '</option>';
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
					<select id="select-propinsi" name="propinsi" class="select2 js-example-basic-single form-control" ' . ((($jml_propinsi == '1') && (!empty($user_location['province_id']))) ? 'disabled ' : '') . '>
						' . $option_propinsi . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kabupaten" name="kabupaten" class="select2 js-example-basic-single form-control" ' . ((($jml_kota == '1') && (!empty($user_location['regency_id']))) ? 'disabled ' : '') . '>
						' . $option_kota . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="select-kecamatan" name="kecamatan" class="select2 js-example-basic-single form-control" ' . ((($jml_kecamatan == '1') && (!empty($user_location['district_id']))) ? 'disabled ' : '') . '>
						' . $option_kecamatan . '
					</select>
				</div>
				<div class="form-group col-md-3">
					<button class="btn btn-info btn-block" id="filter_btn">Filter</button>
				</div>
			</div>


		';
		return $form_cari;
	}

	function get_user_location()
	{
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '';
		$regency_id = '';
		$district_id = '';
		$village_id = '';
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

				$province_id = $query->row('province_id') != '' ? ($no < $count ? $province_id . $query->row('province_id') . ',' : $province_id . $query->row('province_id')) : '';

				$regency_id = $query->row('regency_id') != '' ? ($no < $count ? $regency_id . $query->row('regency_id') . ',' : $regency_id . $query->row('regency_id')) : '';

				$district_id = $query->row('district_id') != '' ? ($no < $count ? $district_id . $query->row('district_id') . ',' : $district_id . $query->row('district_id')) : '';

				$village_id = $query->row('village_id') != '' ? ($no < $count ? $village_id . $query->row('village_id') . ',' : $village_id . $query->row('village_id')) : '';

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
				'select' => $select . ', regency_name',
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
				'select' => $select . ', district_name',
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
				'select' => $select . ', village_name',
			];
		}

		$query = get_data($params);
		$data = [];
		foreach ($query->result_array() as $key => $value) {
			if ($_GET['title'] == "Kabupaten") {
				$data[$value[$select]] = $value['regency_name'];
			}
			if ($_GET['title'] == "Kecamatan") {
				$data[$value[$select]] = $value['district_name'];
			}
			if ($_GET['title'] == "Kelurahan") {
				$data[$value[$select]] = $value['village_name'];
			}
		}
		echo json_encode($data);
	}
}
