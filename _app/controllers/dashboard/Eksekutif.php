<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eksekutif extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->dir = base_url('dashboard/eksekutif/');
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

		$this->template->title('Dashboard Eksekutif');
		$this->template->content("admin/dashboard/view_eksekutif", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function header_count()
	{
		$area = $this->input->post('area', true);
		$prog_head = $this->dashboard_model->get_prog_today_head($area);
		$get_prog_ruta_head = $prog_head['total_ruta'];
		$get_prog_art_head = $prog_head['total_art'];
		$sum = $prog_head['sum_art'];
		$percent = $get_prog_art_head / $sum * 100;
		$result = [
			'ruta' => $get_prog_ruta_head,
			'art' => $get_prog_art_head,
			'art_today' => $prog_head['target_art'],
			'precent' => round($percent, 2),
		];

		echo json_encode($result);
	}

	function get_art_percent($area)
	{
		$sum = $this->dashboard_model->get_get_sum_target_art($area);
		$art = $this->dashboard_model->get_prog_art_head($area);
		return $art / $sum * 100;
	}

	function get_data_chart()
	{
		$area = $this->input->post('area', true);

		$query  =  $this->dashboard_model->get_chart_art_perday($area);
		$t = '';
		$tgl = $real = $target = [];
		$date_now = date("Y-m-d");
		for ($i = 1; $i <= 55; $i++) {
			if ($i > 31) {
				if (($i - 31) < 10) {
					$t = '2020-11-0' . ($i - 31);
				} else {
					$t = '2020-11-' . ($i - 31);
				}
			} else {
				if ($i < 10) {
					$t = '2020-10-0' . $i;
				} else {
					$t = '2020-10-' . $i;
				}
			}
			$tgl[] = $this->tgl_indo($t);
			$cek = 0;
			// if ($i < 10)
			// 	$t = '2020-10-0' . $i;
			foreach ($query as $row) {
				if ($row['tgl'] == $t) {
					$cek =  $row['total'];
					break;
				}
			}
			if (isset($cek) && $t <= $date_now)
				$real[] = $cek;


			// if (strtotime(date('Y-m-d')) >= strtotime($chk[$i - 1]['Dates'])) {
			// 	$real[] =  $this->dashboard_model->get_chart_art_perday($t, $area);
			// }
			//$target[] = $this->dashboard_model->get_target_chart($area, $i);
		}
		$query2  =  $this->dashboard_model->get_target_chart($area);
		foreach ($query2 as $row) {
			for ($i = 1; $i <= 55; $i++) {
				if ($i > 46) {
					$target[] = 0;
				} else {
					$target[] =  $row['t' . $i];
				}
			}
		}
		$result = [
			'tgl' => $tgl,
			'target' => $target,
			'real' => $real,
		];

		echo json_encode($result);
	}

	function get_table_data()
	{
		$area = $this->input->post('area', true);
		$arr_data = $this->dashboard_model->get_arr_data_table_new($area);

		$data = [];
		foreach ($arr_data as $k => $v) {

			// $kode = $this->dashboard_model->get_code_table($v['wilayah'], $area);

			// $tot_desa_kl = $this->dashboard_model->get_desa_foto($kode, 'F-KL');

			// $padan = $this->dashboard_model->get_art_pemadanan(1, $kode);
			// $tdk_padan = $this->dashboard_model->get_art_pemadanan(2, $kode);

			// $terkonfirmasi = $this->dashboard_model->get_art_konfirmasi(1, $kode);
			// $tdk_terkonfirmasi = $this->dashboard_model->get_art_konfirmasi(2, $kode);

			$data[] = [
				'bps_code' => $v['kode'] . ' - ',
				'wilayah' => $v['wilayah'],
				'tar_desa' => $v['tar_desa'],
				'tot_desa_kl' => $v['total'],
				'percent_desa_kl' => $v['total'] / $v['tar_desa'] * 100,
				'tar_art' => $v['tar_art'],
				'art_padan' => $v['tot_art_padan'],
				'art_tdk_padan' => $v['tot_art_tidak_padan'],
				'art_terkonfirmasi' => $v['tot_art_konfirmasi'],
				'art_tdk_terkonfirmasi' => $v['tot_art_tidak_konfirmasi'],
				'percent_art_padan' => $v['tot_art_padan'] / $v['tar_art'] * 100,
				'percent_art_tdk_padan' => $v['tot_art_tidak_padan'] / $v['tar_art'] * 100,
				'percent_art_terkonfirmasi' => $v['tot_art_konfirmasi'] / $v['tar_art'] * 100,
				'percent_art_tdk_terkonfirmasi' => $v['tot_art_tidak_konfirmasi'] / $v['tar_art'] * 100,
			];
		}

		echo json_encode($data);
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

	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Jan',
			'Feb',
			'Mar',
			'Apr',
			'Mei',
			'Jun',
			'Jul',
			'Agu',
			'Sep',
			'Okt',
			'Nov',
			'Des'
		);
		$pecahkan = explode('-', $tanggal);

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}
}
