<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qc_art extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->dir = base_url( 'korkab/qc_art/' );
		$this->load->model('auth_model');
		$this->id = $this->session->userdata('user_info');
	}

	function index() {
		$this->show();
	}

	function show()	{
		$data = array();
		$is_pic = $this->user_info['user_group'];
		$is_qc = $this->user_info['user_group'];
		$data['pic'] = in_array('p-i-c', $is_pic) ? 1 : 0;
		$data['qc'] = in_array('q-c', $is_qc) ? 1 : 0;
		$data['cari'] = $this->form_cari();
		$data['base_url'] = $this->dir;
		$data['title'] = 'Approve Anggota Ruta (MK, MKa, dan MKb)';
		$this->template->title( $data['title'] );
		$this->template->content( "korkab/view_qc_art", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	function get_show_data() {
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

		if ((!in_array('p-i-c', $is_pic) && !in_array('q-c', $is_pic)) || $input['s_fill'] != 0) {
			$input['s_nkrt'] != '' ? $where .= "nama_art LIKE '%" . $input['s_nkrt'] . "%' AND " : '';
			$input['s_petugas'] != '' ? $where .= "nama_petugas LIKE '%" . $input['s_petugas'] . "%' AND " : '';
			$input['s_addr'] != '' ? $where .= "alamat LIKE '%" . $input['s_addr'] . "%' AND " : '';
			$input['s_keb'] != '' ? $where .= "keberadaan_art = '" . $input['s_keb'] . "' AND " : '';
			$input['s_stereo'] != '' ? $where .= "stereotype = '" . $input['s_stereo'] . "' AND " : '';

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
				$where_in = 'AND id_prelist IN'.' (' .$data_in. ')';
			}
			if ($input['s_notin'] != '') {
				$temp = explode(" ", $input['s_notin']);
				$data_in = "'" . implode("','", $temp) . "'";
				$where_in = 'AND id_prelist NOT IN'.' (' .$data_in. ')';
			}

			// $data_ins = '';
			// $in_notin = "";
			// if ($input['s_isin'] != '') {
			// 	$temp = explode(" ", $input['s_isin']);
			// 	$data_ins = implode(" ", $temp);
			// 	$in_notin = 1;
			// }
			// if ($input['s_notin'] != '') {
			// 	$temp = explode(" ", $input['s_notin']);
			// 	$data_ins = implode(" ", $temp);
			// 	$in_notin = 0;
			// }

			if(!empty($order)) {
				foreach($order as $o) {
					$col = $o['column'];
					$dir= $o['dir'];
				}
			}

			if($dir != "asc" && $dir != "desc") {$dir = "desc";}

			$valid_columns = array(
				0=>'stereotype',
				1=>'id_prelist',
				2=>'nama_art',
				3=>'province_name',
				4=>'regency_name',
				5=>'district_name',
				6=>'village_name',
				7=>'keberadaan_art',
				8=>'nik',
				9=>'jenis_kelamin',
				10=>'hubungan_kepkel',
				11=>'id',
				12=>'nama_petugas',
				13=>'lastupdate_on'
			);

			if(!isset($valid_columns[$col])) {$order = null;}
			else {$order = $valid_columns[$col];}

			if($order !=null) {$order_by = $order .' '. $dir;}

			// $sql = "
			// 	EXEC dbo.stp_daftar_semua_data_mk '". $region."', '".$input['s_nkrt']."', '".$input['s_addr']."', '".$input['s_stereo']."', '".$input['s_keb']."', '".$input['s_petugas']."', '".$data_ins."', '".$in_notin."', '".$start."', '".$length."',0
			// ";

			$sql = "
			SELECT * FROM vw_semua_data_mk
			WHERE $where 1=1 $where_in
			ORDER BY lastupdate_on DESC OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
			";
			
			$gen_data = $this->db->query($sql);
			$data = array();
			foreach($gen_data->result() as $rows)
			{
				$gender = "";
				$status_art = "";
				$hubkel = "";

				//gender
				if($rows->jenis_kelamin == 1) {
					$gender = "Laki-laki";
				} else if($rows->jenis_kelamin == 2) {
					$gender = "Perempuan";
				}

				//status_art
				if($rows->keberadaan_art == 1) {
					$status_art = "Terkonfirmasi";
				} else if($rows->keberadaan_art == 2) {
					$status_art = "Tidak Terkonfirmasi";
				} else if($rows->keberadaan_art == 3) {
					$status_art = "Ganda";
				} else if($rows->keberadaan_art == 4) {
					$status_art = "Meninggal";
				} else if($rows->keberadaan_art == 5) {
					$status_art = "Tidak Memiliki/Belum tercatat dalam dokumen kependudukan";
				}

				//hubkel
				if($rows->hubungan_kepkel == 1) {
					$hubkel = "Kepala Keluarga";
				} else if ($rows->hubungan_kepkel == 2) {
					$hubkel = "Istri/Suami";
				} else if ($rows->hubungan_kepkel == 3) {
					$hubkel = "Anak";
				} else if ($rows->hubungan_kepkel == 4) {
					$hubkel = "Menantu";
				} else if ($rows->hubungan_kepkel == 5) {
					$hubkel = "Cucu";
				} else if ($rows->hubungan_kepkel == 6) {
					$hubkel = "Orang Tua/Mertua";
				} else if ($rows->hubungan_kepkel == 7) {
					$hubkel = "Pembantu Rumah Tangga";
				} else if ($rows->hubungan_kepkel == 8) {
					$hubkel = "Lainnya";
				}

				$status = '<span class="badge badge-pill ' . $rows->css . '">'.$rows->stereotype.'</span>';
				$on     = date("d-m-Y H:i:s",strtotime($rows->lastupdate_on));
				$detail = '<a href="' . base_url( "monitoring/detail_data/get_form_detail_art/" . enc( ['id' => $rows->id] ) ) . '" target="_blank" class="btn btn-info btn-sm">Log</a>';
				$data[]= array(
					$status,
					$rows->id_prelist,
					$rows->nama_art,
					$rows->province_name,
					$rows->regency_name,
					$rows->district_name,
					$rows->village_name,
					$status_art,
					$rows->nik,
					$gender,
					$hubkel,
					$rows->id,
					$rows->nama_petugas,
					$on,
					$detail,
				);
			}

			// $sql_total = "
			// 	EXEC dbo.stp_daftar_semua_data_mk '". $region."', '".$input['s_nkrt']."', '".$input['s_addr']."', '".$input['s_stereo']."', '".$input['s_keb']."', '".$input['s_petugas']."', '".$data_ins."', '".$in_notin."', '".$start."', '".$length."',1
			// ";

			$sql_total = "SELECT COUNT(*) as num FROM vw_semua_data_mk WHERE $where 1=1 $where_in";
			
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

	function act_approve()
	{
		$ids = $this->input->post('ids', true);
		$sukses = $gagal = 0;
		$status_ste = "";

		for ($i=0; $i < count($ids); $i++) {
			$details = [
				'table' => 'dbo.master_data_detail',
				'where' => [
					'id' => $ids[$i]
				],
				'select' => 'stereotype, keberadaan_art'
			];

			$user_ip = client_ip();
			$stereotype = get_data( $details )->row('stereotype');
			$keberadaan_art = get_data( $details )->row('keberadaan_art');

			if ($stereotype == 'MK') {
				$status_ste = 'Q2';
			} elseif ($stereotype == 'MKa') {
				$status_ste = 'Q1a';
			} elseif ($stereotype == 'MKb') {
				$status_ste = 'Q1b';
			} else {
				$status_ste = $stereotype;
			}

			if ($keberadaan_art == '3' || $keberadaan_art == '4') {
				$status_ste = 'Q2a';
			}

			$upd_data = [
				'stereotype' => $status_ste,
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s')
			];

			$this->db->where('id', $ids[$i]);
			$update = $this->db->update('master_data_detail', $upd_data);

			$data_log = [];
			if ($update) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$l = $this->db->get_where('master_data_detail', ['id' => $ids[$i]])->row();
			$data_log['detail_id'] = $l->id;
			$data_log['description'] = 'Approve dari '.$stereotype.' ke '.$status_ste;
			$data_log['stereotype'] = $status_ste;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_detail_log', $data_log);

			//cek stereotype ART ------------------------------------------------------->>>
			$cek_mk = "
				SELECT stereotype FROM master_data_detail
				WHERE proses_id = $l->proses_id
				AND stereotype IN ('MK','MKa','MKb','M4','','M1','M2','M3')
			";
			$get_cek_mk = $this->db->query($cek_mk)->num_rows();

			$cek_q1a = "
				SELECT stereotype FROM master_data_detail
				WHERE proses_id = $l->proses_id
				AND stereotype = 'Q1a'
			";
			$get_cek_q1a = $this->db->query($cek_q1a)->num_rows();

			$cek_q1b = "
				SELECT stereotype FROM master_data_detail
				WHERE proses_id = $l->proses_id
				AND stereotype = 'Q1b'
			";
			$get_cek_q1b = $this->db->query($cek_q1b)->num_rows();

			$cek_q2 = "
				SELECT stereotype FROM master_data_detail
				WHERE proses_id = $l->proses_id
				AND stereotype = 'Q2'
			";
			$get_cek_q2 = $this->db->query($cek_q2)->num_rows();

			$cek_q2a = "
				SELECT stereotype FROM master_data_detail
				WHERE proses_id = $l->proses_id
				AND stereotype = 'Q2a'
			";
			$get_cek_q2a = $this->db->query($cek_q2a)->num_rows();

			//RUTA to C2 ------------------------------------------------------------------->>>
			if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a == 0 && $get_cek_q2 > 0) {
				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C2"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c2 = [
					'stereotype' => 'C2',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c2 = $this->db->update('master_data', $upd_data_c2);

				$data_log = [];
				if ($update_c2) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C2';
				$data_log['stereotype'] = 'C2';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}

			if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a > 0 && $get_cek_q2 > 0) {
				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C2"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c2 = [
					'stereotype' => 'C2',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c2 = $this->db->update('master_data', $upd_data_c2);

				$data_log = [];
				if ($update_c2) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C2';
				$data_log['stereotype'] = 'C2';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}

			//RUTA to C2a ------------------------------------------------------------------>>>
			if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a > 0 && $get_cek_q2 == 0) {
				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C2a"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c2 = [
					'stereotype' => 'C2a',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c2 = $this->db->update('master_data', $upd_data_c2);

				$data_log = [];
				if ($update_c2) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C2a';
				$data_log['stereotype'] = 'C2a';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}

			//RUTA to C1 ------------------------------------------------------------------->>>
			if ($get_cek_mk == 0 && $get_cek_q1a > 0) {
				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C1"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c1 = [
					'stereotype' => 'C1',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c1 = $this->db->update('master_data', $upd_data_c1);

				$data_log = [];
				if ($update_c1) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C1';
				$data_log['stereotype'] = 'C1';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}

			if ($get_cek_mk == 0 && ($get_cek_q1a > 0 || ($get_cek_q1b > 0 && $get_cek_q2 > 0))) {
				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C1"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c11 = [
					'stereotype' => 'C1',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c11 = $this->db->update('master_data', $upd_data_c11);

				$data_log = [];
				if ($update_c11) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C1';
				$data_log['stereotype'] = 'C1';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}

			//RUTA to C1a ------------------------------------------------------------------->>>
			if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b > 0) {

				$params_get_audit_trail = [
					'table' => 'dbo.master_data',
					'where' => [
						'proses_id' => $l->proses_id
					],
					'select' => 'audit_trails'
				];

				$user_ip = client_ip();
				$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

				$audit_trails[] = [
					"ip" => $user_ip['ip_address'],
					"on" => date('Y-m-d H:i:s'),
					"act" => "APPROVE",
					"user_id" => $this->user_info['user_id'],
					"username" => $this->user_info['user_username'],
					"column_data" => [
						"proses_id" => $l->proses_id,
						"id_prelist" => $l->id_prelist,
						"stereotype" => "C1a"
					],
					"is_proxy_access" => $user_ip['is_proxy']
				];

				$upd_data_c1a = [
					'stereotype' => 'C1a',
					'lastupdate_by' => $this->id['user_id'],
					'lastupdate_on' => date('Y-m-d H:i:s'),
					'audit_trails' => json_encode( $audit_trails )
				];

				$this->db->where('proses_id', $l->proses_id);
				$update_c1a = $this->db->update('master_data', $upd_data_c1a);

				$data_log = [];
				if ($update_c1a) {
					$sukses ++;
					$data_log['status'] = 'sukses';
				} else {
					$gagal++;
					$data_log['status'] = 'gagal';
				}

				$data_log['proses_id'] = $l->proses_id;
				$data_log['description'] = 'Approve menjadi C1a';
				$data_log['stereotype'] = 'C1a';
				$data_log['prelist_id'] = $l->id_prelist;
				$data_log['created_by'] = $this->id['user_id'];
				$data_log['created_on'] =  date('Y-m-d H:i:s');

				$in_log = $this->db->insert('master_data_log', $data_log);
			}
		}

		$result = [
			'status' => true,
			'sukses' => $sukses,
			'gagal' => $gagal,
			'pesan' => $sukses . ' data berhasil diapprove. ' . $gagal .' data gagal diapprove',
		];

		echo json_encode($result);
	}

	function act_approve_per_art($par = null)
	{
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$ids = $params['id'];
		$sukses = $gagal = 0;
		$status_ste = "";

		$details = [
			'table' => 'dbo.master_data_detail',
			'where' => [
				'id' => $ids
			],
			'select' => 'stereotype, keberadaan_art, proses_id, id_prelist'
		];

		$user_ip = client_ip();
		$stereotype = get_data( $details )->row('stereotype');
		$keberadaan_art = get_data( $details )->row('keberadaan_art');
		$proses_id = get_data( $details )->row('proses_id');
		$id_prelist = get_data( $details )->row('id_prelist');

		if ($stereotype == 'MK') {
			$status_ste = 'Q2';
		} elseif ($stereotype == 'MKa') {
			$status_ste = 'Q1a';
		} elseif ($stereotype == 'MKb') {
			$status_ste = 'Q1b';
		} else {
			$status_ste = $stereotype;
		}

		if ($keberadaan_art == '3' || $keberadaan_art == '4') {
			$status_ste = 'Q2a';
		}

		$upd_data = [
			'stereotype' => $status_ste,
			'lastupdate_by' => $this->id['user_id'],
			'lastupdate_on' => date('Y-m-d H:i:s'),
		];

		$this->db->where('id', $ids);
		$update = $this->db->update('master_data_detail', $upd_data);

		$data_log = [];
		if ($update) {
			$sukses ++;
			$data_log['status'] = 'sukses';
		} else {
			$gagal++;
			$data_log['status'] = 'gagal';
		}

		$data_log['detail_id'] = $ids;
		$data_log['description'] = 'Approve dari '.$stereotype.' ke '.$status_ste;
		$data_log['stereotype'] = $status_ste;
		$data_log['created_by'] = $this->id['user_id'];
		$data_log['created_on'] =  date('Y-m-d H:i:s');

		$in_log = $this->db->insert('master_detail_log', $data_log);

		//cek stereotype ART ------------------------------------------------------->>>
		$cek_mk = "
			SELECT stereotype FROM master_data_detail
			WHERE proses_id = $proses_id
			AND stereotype IN ('MK','MKa','MKb','M4','','M1','M2','M3')
		";
		$get_cek_mk = $this->db->query($cek_mk)->num_rows();

		$cek_q1a = "
			SELECT stereotype FROM master_data_detail
			WHERE proses_id = $proses_id
			AND stereotype = 'Q1a'
		";
		$get_cek_q1a = $this->db->query($cek_q1a)->num_rows();

		$cek_q1b = "
			SELECT stereotype FROM master_data_detail
			WHERE proses_id = $proses_id
			AND stereotype = 'Q1b'
		";
		$get_cek_q1b = $this->db->query($cek_q1b)->num_rows();

		$cek_q2 = "
			SELECT stereotype FROM master_data_detail
			WHERE proses_id = $proses_id
			AND stereotype = 'Q2'
		";
		$get_cek_q2 = $this->db->query($cek_q2)->num_rows();

		$cek_q2a = "
			SELECT stereotype FROM master_data_detail
			WHERE proses_id = $proses_id
			AND stereotype = 'Q2a'
		";
		$get_cek_q2a = $this->db->query($cek_q2a)->num_rows();

		//RUTA to C2 ------------------------------------------------------------------->>>
		if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a == 0 && $get_cek_q2 > 0) {
			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C2"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c2 = [
				'stereotype' => 'C2',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c2 = $this->db->update('master_data', $upd_data_c2);

			$data_log = [];
			if ($update_c2) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C2';
			$data_log['stereotype'] = 'C2';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a > 0 && $get_cek_q2 > 0) {
			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C2"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c2 = [
				'stereotype' => 'C2',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c2 = $this->db->update('master_data', $upd_data_c2);

			$data_log = [];
			if ($update_c2) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C2';
			$data_log['stereotype'] = 'C2';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		//RUTA to C2a ------------------------------------------------------------------>>>
		if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b == 0 && $get_cek_q2a > 0 && $get_cek_q2 == 0) {
			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C2a"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c2 = [
				'stereotype' => 'C2a',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c2 = $this->db->update('master_data', $upd_data_c2);

			$data_log = [];
			if ($update_c2) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C2a';
			$data_log['stereotype'] = 'C2a';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		//RUTA to C1 ------------------------------------------------------------------->>>
		if ($get_cek_mk == 0 && $get_cek_q1a > 0) {
			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C1"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c1 = [
				'stereotype' => 'C1',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c1 = $this->db->update('master_data', $upd_data_c1);

			$data_log = [];
			if ($update_c1) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C1';
			$data_log['stereotype'] = 'C1';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		if ($get_cek_mk == 0 && ($get_cek_q1a > 0 || ($get_cek_q1b > 0 && $get_cek_q2 > 0))) {
			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C1"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c11 = [
				'stereotype' => 'C1',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c11 = $this->db->update('master_data', $upd_data_c11);

			$data_log = [];
			if ($update_c11) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C1';
			$data_log['stereotype'] = 'C1';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		//RUTA to C1a ------------------------------------------------------------------->>>
		if ($get_cek_mk == 0 && $get_cek_q1a == 0 && $get_cek_q1b > 0 && $get_cek_q2 == 0) {

			$params_get_audit_trail = [
				'table' => 'dbo.master_data',
				'where' => [
					'proses_id' => $proses_id
				],
				'select' => 'audit_trails'
			];

			$user_ip = client_ip();
			$audit_trails = json_decode( get_data( $params_get_audit_trail )->row('audit_trails'), true );

			$audit_trails[] = [
				"ip" => $user_ip['ip_address'],
				"on" => date('Y-m-d H:i:s'),
				"act" => "APPROVE",
				"user_id" => $this->user_info['user_id'],
				"username" => $this->user_info['user_username'],
				"column_data" => [
					"proses_id" => $proses_id,
					"id_prelist" => $id_prelist,
					"stereotype" => "C1a"
				],
				"is_proxy_access" => $user_ip['is_proxy']
			];

			$upd_data_c1a = [
				'stereotype' => 'C1a',
				'lastupdate_by' => $this->id['user_id'],
				'lastupdate_on' => date('Y-m-d H:i:s'),
				'audit_trails' => json_encode( $audit_trails )
			];

			$this->db->where('proses_id', $proses_id);
			$update_c1a = $this->db->update('master_data', $upd_data_c1a);

			$data_log = [];
			if ($update_c1a) {
				$sukses ++;
				$data_log['status'] = 'sukses';
			} else {
				$gagal++;
				$data_log['status'] = 'gagal';
			}

			$data_log['proses_id'] = $proses_id;
			$data_log['description'] = 'Approve menjadi C1a';
			$data_log['stereotype'] = 'C1a';
			$data_log['prelist_id'] = $id_prelist;
			$data_log['created_by'] = $this->id['user_id'];
			$data_log['created_on'] =  date('Y-m-d H:i:s');

			$in_log = $this->db->insert('master_data_log', $data_log);
		}

		$result = [
			'status' => true,
			'sukses' => $sukses,
			'gagal' => $gagal,
			'pesan' => $sukses . ' data berhasil diapprove. ' . $gagal .' data gagal diapprove',
		];

		$this->session->set_flashdata('tab', 'approve_art');
		if ($result) {
			$this->session->set_flashdata('status', '1');
			return redirect('monitoring/detail_data/get_form_detail/'. enc( [ 'proses_id' => $proses_id ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('monitoring/detail_data/get_form_detail/'. enc( [ 'proses_id' => $proses_id ] ) );
		}

		echo json_encode($result);
	}

	function totalData($sql_total)
	{
		$query = $this->db->query($sql_total);
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
}
