<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table_progres extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->db2 = $this->load->database('replication', TRUE);
		$this->dir = base_url('dashboard/table_progres/');
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
		$this->template->content("admin/dashboard/view_table_progres", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function get_table_data()
	{
		$area = $this->input->post('area', true);
		$arr_data = $this->dashboard_model->get_arr_data_table_progres($area);
		$data = [];
		foreach ($arr_data as $k => $v) {
			// $kode = $this->dashboard_model->get_code_table($v['wilayah'], $area);
			// $padan = $this->dashboard_model->get_art_pemadanan(1, $kode);
			// $tdk_padan = $this->dashboard_model->get_art_pemadanan(2, $kode);
			// $pemadanan = $padan + $tdk_padan;

			// $terkonfirmasi = $this->dashboard_model->get_keberadaan_art(1, $kode);
			// $tdk_terkonfirmasi = $this->dashboard_model->get_keberadaan_art(2, $kode);
			// $ganda = $this->dashboard_model->get_keberadaan_art(3, $kode);
			// $meninggal = $this->dashboard_model->get_keberadaan_art(4, $kode);
			// $no_doc = $this->dashboard_model->get_keberadaan_art(5, $kode);
			// $konfirmasi = $terkonfirmasi + $tdk_terkonfirmasi + $ganda + $meninggal + $no_doc;

			// $desa_kl = $this->dashboard_model->get_desa_foto($kode, 'F-KL');
			// $desa_ba = $this->dashboard_model->get_desa_foto($kode, 'F-BA');
			// $desa_art = $this->dashboard_model->get_real_desa($kode);

			$padan = $v['tot_art_padan'];
			$tdk_padan = $v['tot_art_tidak_padan'];
			$pemadanan = $padan + $tdk_padan;

			$terkonfirmasi = $v['terkonfirmasi'];
			$tdk_terkonfirmasi = $v['tdk_terkonfirmasi'];
			$ganda = $v['ganda'];
			$meninggal = $v['meninggal'];
			$no_doc = $v['no_doc'];
			$konfirmasi = $terkonfirmasi + $tdk_terkonfirmasi + $ganda + $meninggal + $no_doc;

			$desa_kl = $v['desa_kl'];
			$desa_ba = $v['desa_ba'];
			$desa_art = $v['desa_art'];

			$data[] = [
				'wilayah' => $v['wilayah'],
				'tar_desa' => $v['tar_desa'],
				'desa_art' => $desa_art,
				'desa_ba' => $desa_ba,
				'desa_kl' => $desa_kl,
				'percent_desa_art' => $desa_art / $v['tar_desa'] * 100,
				'percent_desa_ba' => $desa_ba / $v['tar_desa'] * 100,
				'percent_desa_kl' => $desa_kl / $v['tar_desa'] * 100,
				'tar_art' => $v['tar_art'],
				'art_padan' => $padan,
				'percent_art_padan' => $padan / $v['tar_art'] * 100,
				'art_tdk_padan' => $tdk_padan,
				'percent_art_tdk_padan' => $tdk_padan / $v['tar_art'] * 100,
				'pemadanan' => $pemadanan,
				'percent_pemadanan' => $pemadanan  / $v['tar_art'] * 100,
				'terkonfirmasi' => $terkonfirmasi,
				'percent_art_terkonfirmasi' => $terkonfirmasi / $v['tar_art'] * 100,
				'tdk_terkonfirmasi' => $tdk_terkonfirmasi,
				'percent_art_tdk_terkonfirmasi' => $tdk_terkonfirmasi / $v['tar_art'] * 100,
				'ganda' => $ganda,
				'percent_art_ganda' => $ganda / $v['tar_art'] * 100,
				'meninggal' => $meninggal,
				'percent_art_meninggal' => $meninggal / $v['tar_art'] * 100,
				'no_doc' => $no_doc,
				'percent_art_no_doc' => $no_doc / $v['tar_art'] * 100,
				'konfirmasi' => $konfirmasi,
				'precent_konfirmasi' => $konfirmasi / $v['tar_art'] * 100,
			];
		}

		echo json_encode($data);
	}

	// function import_excel()
	// {
	// 	$this->load->library('excel');
	// 	$result = $baris_err = [];
	// 	$success = $failed = $baris = 0;
	// 	if (isset($_FILES["ImportExcel"]["tmp_name"])) {
	// 		$path = $_FILES["ImportExcel"]["tmp_name"];
	// 		$object = PHPExcel_IOFactory::load($path);

	// 		foreach ($object->getWorksheetIterator() as $w) {
	// 			$highestRow = $w->getHighestRow();
	// 			$highestColumn = $w->getHighestColumn();
	// 			$result['total_data'] = $highestRow - 1;

	// 			for ($row = 2; $row <= $highestRow; $row++) {
	// 				$excel_row = [
	// 					'bps_code' => $w->getCellByColumnAndRow(0, $row)->getValue(),
	// 					'nama_provinsi' => $w->getCellByColumnAndRow(1, $row)->getValue(),
	// 					'nama_kabupaten' => $w->getCellByColumnAndRow(2, $row)->getValue(),
	// 					'nama_kecamatan' => $w->getCellByColumnAndRow(3, $row)->getValue(),
	// 					'sum_desa' => $w->getCellByColumnAndRow(4, $row)->getValue(),
	// 					'sum_art' => $w->getCellByColumnAndRow(5, $row)->getValue(),
	// 					'tgl1' => $w->getCellByColumnAndRow(6, $row)->getValue(),
	// 					'tgl2' => $w->getCellByColumnAndRow(7, $row)->getValue(),
	// 					'tgl3' => $w->getCellByColumnAndRow(8, $row)->getValue(),
	// 					'tgl4' => $w->getCellByColumnAndRow(9, $row)->getValue(),
	// 					'tgl5' => $w->getCellByColumnAndRow(10, $row)->getValue(),
	// 					'tgl6' => $w->getCellByColumnAndRow(11, $row)->getValue(),
	// 					'tgl7' => $w->getCellByColumnAndRow(12, $row)->getValue(),
	// 					'tgl8' => $w->getCellByColumnAndRow(13, $row)->getValue(),
	// 					'tgl9' => $w->getCellByColumnAndRow(14, $row)->getValue(),
	// 					'tgl10' => $w->getCellByColumnAndRow(15, $row)->getValue(),
	// 					'tgl11' => $w->getCellByColumnAndRow(16, $row)->getValue(),
	// 					'tgl12' => $w->getCellByColumnAndRow(17, $row)->getValue(),
	// 					'tgl13' => $w->getCellByColumnAndRow(18, $row)->getValue(),
	// 					'tgl14' => $w->getCellByColumnAndRow(19, $row)->getValue(),
	// 					'tgl15' => $w->getCellByColumnAndRow(20, $row)->getValue(),
	// 					'tgl16' => $w->getCellByColumnAndRow(21, $row)->getValue(),
	// 					'tgl17' => $w->getCellByColumnAndRow(22, $row)->getValue(),
	// 					'tgl18' => $w->getCellByColumnAndRow(23, $row)->getValue(),
	// 					'tgl19' => $w->getCellByColumnAndRow(24, $row)->getValue(),
	// 					'tgl20' => $w->getCellByColumnAndRow(25, $row)->getValue(),
	// 					'tgl21' => $w->getCellByColumnAndRow(26, $row)->getValue(),
	// 					'tgl22' => $w->getCellByColumnAndRow(27, $row)->getValue(),
	// 					'tgl23' => $w->getCellByColumnAndRow(28, $row)->getValue(),
	// 					'tgl24' => $w->getCellByColumnAndRow(29, $row)->getValue(),
	// 					'tgl25' => $w->getCellByColumnAndRow(30, $row)->getValue(),
	// 					'tgl26' => $w->getCellByColumnAndRow(31, $row)->getValue(),
	// 					'tgl27' => $w->getCellByColumnAndRow(32, $row)->getValue(),
	// 					'tgl28' => $w->getCellByColumnAndRow(33, $row)->getValue(),
	// 					'tgl29' => $w->getCellByColumnAndRow(34, $row)->getValue(),
	// 					'tgl30' => $w->getCellByColumnAndRow(35, $row)->getValue(),
	// 					'tgl31' => $w->getCellByColumnAndRow(36, $row)->getValue(),
	// 					'tgln1' => $w->getCellByColumnAndRow(37, $row)->getValue(),
	// 					'tgln2' => $w->getCellByColumnAndRow(38, $row)->getValue(),
	// 					'tgln3' => $w->getCellByColumnAndRow(39, $row)->getValue(),
	// 					'tgln4' => $w->getCellByColumnAndRow(40, $row)->getValue(),
	// 					'tgln5' => $w->getCellByColumnAndRow(41, $row)->getValue(),
	// 					'tgln6' => $w->getCellByColumnAndRow(42, $row)->getValue(),
	// 					'tgln7' => $w->getCellByColumnAndRow(43, $row)->getValue(),
	// 					'tgln8' => $w->getCellByColumnAndRow(44, $row)->getValue(),
	// 					'tgln9' => $w->getCellByColumnAndRow(45, $row)->getValue(),
	// 					'tgln10' => $w->getCellByColumnAndRow(46, $row)->getValue(),
	// 					'tgln11' => $w->getCellByColumnAndRow(47, $row)->getValue(),
	// 					'tgln12' => $w->getCellByColumnAndRow(48, $row)->getValue(),
	// 					'tgln13' => $w->getCellByColumnAndRow(49, $row)->getValue(),
	// 					'tgln14' => $w->getCellByColumnAndRow(50, $row)->getValue(),
	// 					'tgln15' => $w->getCellByColumnAndRow(51, $row)->getValue()
	// 				];

	// 				$insert = $this->db->insert('_target', $excel_row);
	// 				if ($insert) {
	// 					$success++;
	// 				} else {
	// 					$failed++;
	// 				}
	// 			}
	// 		}
	// 	}

	// 	echo "<pre>";
	// 	print_r($success . " Berhasil Disimpan, " . $failed . " Gagal Disimpan");
	// 	die;
	// }

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

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}
}
