<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Per_enumerator extends Backend_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->dir = base_url( 'dashboard/per_enumerator/' );
		$this->load->model('auth_model');
		$this->id = $this->session->userdata('user_info');
		$this->db2 = $this->load->database('replication', TRUE);
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$is_pic = $this->user_info['user_group'];
		$data['pic'] = in_array('p-i-c', $is_pic) ? 1 : 0;
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
		$data['title'] = 'Rekapitulasi Per Enumerator';
		$this->template->title( $data['title'] );
		$this->template->content( "admin/rekap/per_enum", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data_art() {
		$is_pic = $this->user_info['user_group'];

		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search= $this->input->post("search");
        $search = $search['value'];

		$col = 0;
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		if (!in_array('p-i-c', $is_pic) || $input['s_fill'] != 0) {
			$input['s_ph'] != '' ? $where .= "enum_phone LIKE '%" . $input['s_ph'] . "%' AND " : '';
			$input['s_enum'] != '' ? $where .= "enum_name LIKE '%" . $input['s_enum'] . "%' AND " : '';

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

			if(!empty($order)) {
				foreach($order as $o) {
					$col = $o['column'];
					$dir= $o['dir'];
				}
			}

			if($dir != "asc" && $dir != "desc") {$dir = "desc";}

			$valid_columns = array(
				0=>'propinsi',
				1=>'kabupaten',
				2=>'kecamatan',
				3=>'kelurahan',
				4=>'enum_name',
				5=>'enum_phone',
				6=>'terkonfirmasi',
				7=>'tidak_terkonfirmasi',
				8=>'ganda',
				9=>'meninggal',
				10=>'no_doc',
				11=>'total'
			);

			if(!isset($valid_columns[$col])) {$order = null;}
			else {$order = $valid_columns[$col];}

			if($order !=null) {$order_by = $order .' '. $dir;}

			$sql = "
			EXEC dbo.stp_rekap_per_enum '". $region."', '".$input['s_enum']."', '".$input['s_ph']."', '".$start."', '".$length."'
			";

			$gen_data = $this->db2->query($sql);
			$data = array();
			foreach($gen_data->result() as $rows)
			{
				$data[]= array(
				$rows->propinsi,
				$rows->kabupaten,
				$rows->kecamatan,
				$rows->kelurahan,
				$rows->enum_name,
				$rows->enum_phone,
				$rows->terkonfirmasi,
				$rows->tidak_terkonfirmasi,
				$rows->ganda,
				$rows->meninggal,
				$rows->no_doc,
				$rows->total_selesai
				);
			}
			$sql_total = "SELECT COUNT(*) as num FROM vw_rekap_per_enum WHERE $where 1=1 $where_in";
			$total_data = $this->totalData($sql_total);
			$output = array(
				"draw" => $draw,
				"recordsTotal" => $total_data,
				"recordsFiltered" => $total_data,
				"data" => $data
			);
		} else {
			$output = array(
				"draw" => "",
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => ""
			);
		}

        echo json_encode($output);
        exit();
    }

	function totalData($sql_total) {
		$query = $this->db2->query($sql_total);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}

	function form_cari() {
		$user_location = $this->get_user_location();
		$jml_negara = count( explode( ',', $user_location['country_id'] ) );
		$jml_propinsi = count( explode( ',', $user_location['province_id'] ) );
		$jml_kota = count( explode( ',', $user_location['regency_id'] ) );
		$jml_kecamatan = count( explode( ',', $user_location['district_id'] ) );
		$jml_kelurahan = count( explode( ',', $user_location['village_id'] ) );

		$option_propinsi = '<option value="0">Semua Provinsi</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_kota = '<option value="0">Semua Kota/Kabupaten</option>';
		$option_kecamatan = '<option value="0">Semua Kecamatan</option>';
		$option_kelurahan = '<option value="0">Semua Kelurahan</option>';
		$option_status = '<option value="0">Semua Status</option>';
		$option_hasil_musdes = '<option value="0">Semua Hasil Musdes</option>';
		$option_hasil_verivali = '<option value="0">Semua Hasil Verivali</option>';

		$where_propinsi = [];

		if ( ! empty( $user_location['province_id'] ) ) {
			if ( $jml_propinsi > '0' ) $where_propinsi['province_id ' . ( ( $jml_propinsi >= '2' ) ? "IN ({$user_location['province_id']}) " : " = {$user_location['province_id']}" )] = null;
		}

		$params_propinsi = [
			'table' => 'dbo.vw_administration_regions',
			'select' => 'DISTINCT kode_propinsi, propinsi',
			'where' => $where_propinsi,
			'order_by' => 'propinsi',
		];
		$query_propinsi = get_data( $params_propinsi );
		foreach ( $query_propinsi->result() as $key => $value ) {
			if ($value->propinsi != '') {
				if ( $jml_propinsi == '1' && ! empty( $user_location['province_id'] ) ) {
					$option_propinsi = '<option value="' . $value->kode_propinsi . '" selected>' . $value->propinsi . '</option>';
				} else {
					$option_propinsi .= '<option value="' . $value->kode_propinsi . '">' . $value->propinsi . '</option>';
				}
			}
		}


		if ( $jml_propinsi == '1' ) {
			$where_kota = [];
			if ( ! empty( $user_location['regency_id'] ) ) {
				if ( $jml_kota > '0' ) $where_kota['regency_id ' . ( ( $jml_kota >= '2' ) ? "IN ({$user_location['regency_id']}) " : " = {$user_location['regency_id']}" )] = null;
			} else {
				$where_kota['province_id'] = $user_location['province_id'];
			}
			$params_kota = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT kode_kabupaten, kabupaten',
				'where' => $where_kota,
				'order_by' => 'kabupaten',
			];
			$query_kota = get_data( $params_kota );
			foreach ( $query_kota->result() as $key => $value ) {
				if ( $jml_kota == '1' && ! empty( $user_location['regency_id'] ) ) {
					$option_kota = '<option value="' . $value->kode_kabupaten . '" selected>' . $value->kabupaten . '</option>';
				} else {
					$option_kota .= '<option value="' . $value->kode_kabupaten . '">' . $value->kabupaten . '</option>';
				}
			}
		}

		if ( $jml_kota == '1' ) {
			$where_kecamatan = [];
			if ( ! empty( $user_location['district_id'] ) ) {
				if ( $jml_kecamatan > '0' ) $where_kecamatan['district_id ' . ( ( $jml_kecamatan >= '2' ) ? "IN ({$user_location['district_id']}) " : " = {$user_location['district_id']}" )] = null;
			} else {
				$where_kecamatan['regency_id'] = $user_location['regency_id'];
			}
			$params_kecamatan = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT kode_kecamatan, kecamatan',
				'where' => $where_kecamatan,
				'order_by' => 'kecamatan',
			];
			$query_kecamatan = get_data( $params_kecamatan );
			foreach ( $query_kecamatan->result() as $key => $value ) {
				if ( $jml_kecamatan == '1' && ! empty( $user_location['district_id'] ) ) {
					$option_kecamatan = '<option value="' . $value->kode_kecamatan . '" selected>' . $value->kecamatan . '</option>';
				} else {
					$option_kecamatan .= '<option value="' . $value->kode_kecamatan . '">' . $value->kecamatan . '</option>';
				}
			}
		}

		if (  $jml_kecamatan == '1' ) {
			$where_kelurahan = [];
			if ( ! empty( $user_location['village_id'] ) ) {
				if ( $jml_kelurahan > '0' ) $where_kelurahan['village_id ' . ( ( $jml_kelurahan >= '2' ) ? "IN ({$user_location['village_id']}) " : " = {$user_location['village_id']}" )] = null;
			} else {
				$where_kelurahan['district_id'] = $user_location['district_id'];
			}
			$params_kelurahan = [
				'table' => 'dbo.vw_administration_regions',
				'select' => 'DISTINCT village_id, kelurahan',
				'where' => $where_kelurahan,
				'order_by' => 'kelurahan',
			];
			$query_kelurahan = get_data( $params_kelurahan );
			foreach ( $query_kelurahan->result() as $key => $value ) {
				if ( $jml_kelurahan == '1' && ! empty( $user_location['village_id'] ) ) {
					$option_kelurahan = '<option value="' . $value->village_id . '" selected>' . $value->kelurahan . '</option>';
				} else {
					$option_kelurahan .= '<option value="' . $value->village_id . '">' . $value->kelurahan . '</option>';
				}
			}
		}

		$form_cari = '
		<div class="row"">
		<div class="form-group col-md-3">
		<select id="select-propinsi" style="width:100%" name="propinsi" class="select2 form-control" ' . ( ( ( $jml_propinsi == '1') && ( ! empty( $user_location['province_id'] ) ) ) ? 'disabled ' : '' ) . '>
		' . $option_propinsi . '
		</select>
		</div>
		<div class="form-group col-md-3">
		<select id="select-kabupaten" style="width:100%" name="kabupaten" class="select2 form-control" ' . ( ( ( $jml_kota == '1' ) && ( ! empty( $user_location['regency_id'] ) ) ) ? 'disabled ' : '' ) . '>
		' . $option_kota . '
		</select>
		</div>
		<div class="form-group col-md-3">
		<select id="select-kecamatan" style="width:100%" name="kecamatan" class="select2 form-control" ' . ( ( ( $jml_kecamatan == '1' ) && ( ! empty( $user_location['district_id'] ) ) ) ? 'disabled ' : '' ) . '>
		' . $option_kecamatan . '
		</select>
		</div>
		<div class="form-group col-md-3">
		<select id="select-kelurahan" style="width:100%" name="kelurahan" class="select2 form-control" >
		' . $option_kelurahan . '
		</select>
		</div>
		</div>


		';
		return $form_cari;
	}

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '';
		$regency_id = '';
		$district_id = '';
		$village_id = '';
		if ( ! empty( $user_location ) ) {
			$count = count( $user_location );
			$no = 1;
			foreach ( $user_location as $loc ) {
				$params_location = [
					'table' => 'dbo.ref_locations',
					'where' => [
						'location_id' => $loc
					]
				];
				$query = get_data( $params_location );
				$country_id = $query->row( 'country_id' ) . ( ( $no < $count ) ? ',' : '' );

				$province_id = $query->row( 'province_id' ) != '' ? ($no < $count ? $province_id . $query->row( 'province_id' ) . ',' : $province_id . $query->row( 'province_id' )) : '';

				$regency_id = $query->row( 'regency_id' ) != '' ? ($no < $count ? $regency_id . $query->row( 'regency_id' ) . ',' : $regency_id . $query->row( 'regency_id' )) : '';

				$district_id = $query->row( 'district_id' ) != '' ? ($no < $count ? $district_id . $query->row( 'district_id' ) . ',' : $district_id . $query->row( 'district_id' )) : '';

				$village_id = $query->row( 'village_id' ) != '' ? ($no < $count ? $village_id . $query->row( 'village_id' ) . ',' : $village_id . $query->row( 'village_id' )) : '';

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

	function get_show_location(){
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

		$query = get_data( $params );
		$data = [];
		foreach ( $query->result_array() as $key => $value ) {
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
		echo json_encode( $data );
	}

	public function export_data(){
		$data = array();
		$where = $region = '';
		$s_prov = $this->uri->segment(4);
		$s_regi = $this->uri->segment(5);
		$s_dist = $this->uri->segment(6);
		$s_vill = $this->uri->segment(7);
		$s_ph = $this->uri->segment(8);
		$s_enum = $this->uri->segment(9);

		if ($s_prov != 0) {
			if ($s_prov != 0 && $s_regi == 0 && $s_dist == 0 && $s_vill == 0) {
				$region = $s_prov;
			} elseif ($s_regi != 0 && $s_dist == 0 && $s_vill == 0) {
				$region = $s_prov . $s_regi;
			} elseif ($s_dist != 0 && $s_vill == 0) {
				$region = $s_prov . $s_regi . $s_dist;
			} elseif ($s_vill != 0) {
				$region = $s_prov . $s_regi . $s_dist . $s_vill;
			}

			$where .= "bps_full_code like '" . $region . "%' AND ";
		}

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('My Notes Code')
					 ->setLastModifiedBy('My Notes Code')
					 ->setTitle("Data Prelist")
					 ->setSubject("Prelist")
					 ->setDescription("Laporan Semua Data Prelist")
					 ->setKeywords("Data Prelist");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
		  'font' => array('bold' => true), // Set font nya jadi bold
		  'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$style_row = array(
		  'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ),
		  'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  )
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "propinsi");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "kabupaten");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "kecamatan");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "kelurahan");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "enum_name");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "enum_phone");
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "terkonfirmasi");
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "tidak_terkonfirmasi");
		$excel->setActiveSheetIndex(0)->setCellValue('I1', "ganda");
		$excel->setActiveSheetIndex(0)->setCellValue('J1', "meninggal");
		$excel->setActiveSheetIndex(0)->setCellValue('K1', "no_doc");
		$excel->setActiveSheetIndex(0)->setCellValue('L1', "total_selesai");

		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);

		$sql = "
			EXEC dbo.export_rekap_per_enum '". $region."', '".$s_enum."', '".$s_ph."'
		";

		$data = $this->db->query($sql);
		//var_dump($data);die();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($data->result_array() as $key => $value)
        {
			// Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $value['propinsi'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $value['kabupaten'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$numrow, $value['kecamatan'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numrow, $value['kelurahan'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $value['enum_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numrow, $value['enum_phone'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $value['terkonfirmasi']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $value['tidak_terkonfirmasi']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $value['ganda']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $value['meninggal']);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $value['no_doc']);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $value['total_selesai']);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Daftar Prelist");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="rekap_per_enumerator"'.date('Y-m-d').'".xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
