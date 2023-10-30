<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prelist extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('server/auth_model');
	}


	// public function index_post()
	// {
	// 	$token = $this->cektoken();
	// 	$user_id = $token->user_id;
	// 	$errors = array();
	// 	$json = file_get_contents("php://input");
	// 	$data = json_decode($json);
	// 	//$stage = $data->stage;
	// 	$filter = $data->prelistKrtName;
	// 	$kd_propinsi = $data->prelistBpsProvinceCode;
	// 	$kd_kabupaten = $data->prelistBpsRegencyCode;
	// 	$kd_kecamatan = $data->prelistBpsDistrictCode;
	// 	$kd_kelurahan = $data->prelistBpsVillageCode;


	// 	$region = $this->auth_model->ambil_location_get($user_id);
	// 	$up = array('P3','P3a');

	// 	if (!empty($kd_propinsi) && $kd_propinsi != '00')
	// 		$ud = "ref_locations.bps_province_code=$kd_propinsi";
	// 	if (!empty($kd_kabupaten) && $kd_kabupaten != '00')
	// 		$ud .= " and ref_locations.bps_regency_code=$kd_kabupaten";
	// 	if (!empty($kd_kecamatan) && $kd_kecamatan != '00')
	// 		$ud .= " and ref_locations.bps_district_code=$kd_kecamatan";
	// 	if (!empty($kd_kelurahan) && $kd_kelurahan != '00')
	// 		$ud .= " and ref_locations.bps_village_code=$kd_kelurahan";

	// 	if (empty($ud))
	// 		$ud = "location_id in (" . $region['village_codes'] . ")";
	// 	else
	// 		$ud .= " and location_id in (" . $region['village_codes'] . ")";

	// 	if (!empty($filter) && $filter != '') {
	// 		$fu = "(id_prelist LIKE '%" . $filter . "%' or nama_krt LIKE '%" . $filter . "%' or alamat LIKE '%" . $filter . "%')";
	// 	} else
	// 		$fu = '';

	// 	$data = $this->auth_model->getSelectedDataIn("dbo.master_data", $ud, $up, $fu);
	// 	$prelist = array();
	// 	foreach ($data->result() as $db) {
	// 		$x['prelistServerId'] = $db->proses_id;
	// 		$x['prelistProvince'] = $db->province_name;
	// 		$x['prelistRegency'] = $db->regency_name;
	// 		$x['prelistDistrict'] = $db->district_name;
	// 		$x['prelistVillage'] = $db->village_name;
	// 		$x['prelistAddress'] = $db->alamat;
	// 		$x['prelistIdPrelist'] = $db->id_prelist;
	// 		$x['prelistKrtName'] = $db->nama_krt;
	// 		$x['prelistStereoType'] = $db->stereotype;
	// 		$x['prelistRevokeNote'] = $db->revoke_note;
	// 		$x['prelistPublishDate'] = $db->lastupdate_on;
	// 		$prelist[] = $x;
	// 	}
	// 	$this->app_response(
	// 		REST_Controller::HTTP_OK,
	// 		array(
	// 			'code' => '200',
	// 			'message' => 'Data Prelist'
	// 		),
	// 		array(
	// 			'prelist' => $prelist
	// 		)


	// 	);
	// }

	public function index_post()
	{
		$token = $this->cektoken();
		$user_id = $token->user_id;
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		//$stage = $data->stage;
		$filter = $data->prelistKrtName;
		$kd_propinsi = $data->prelistBpsProvinceCode;
		$kd_kabupaten = $data->prelistBpsRegencyCode;
		$kd_kecamatan = $data->prelistBpsDistrictCode;
		$kd_kelurahan = $data->prelistBpsVillageCode;
		$region = $this->auth_model->ambil_location_get($user_id);
		$kc = 0;
		$kl = 0;
		if (!empty($kd_kecamatan) && $kd_kecamatan != '00')
			$kc = $kd_kecamatan;
		if (!empty($kd_kelurahan) && $kd_kelurahan != '00')
			$kl = $kd_kelurahan;
		
		$sqln = "
			EXEC dbo.stp_ANDRO_AMBIL_DATA '".$region['village_codes']."', '".$filter."' , '0','0','".$kc."','".$kl."'
		";
		
		$get_data = $this->db->query($sqln);
	//	$row = $get_data->result();
		$prelist = array();
		foreach ($get_data->result() as $db) {
			$x['prelistServerId'] = $db->proses_id;
			$x['prelistProvince'] = $db->province_name;
			$x['prelistRegency'] = $db->regency_name;
			$x['prelistDistrict'] = $db->district_name;
			$x['prelistVillage'] = $db->village_name;
			$x['prelistAddress'] = $db->alamat;
			$x['prelistIdPrelist'] = $db->id_prelist;
			$x['prelistKrtName'] = $db->nama_krt;
			$x['prelistStereoType'] = $db->stereotype;
			$x['prelistRevokeNote'] = $db->revoke_note;
			$x['prelistPublishDate'] = $db->lastupdate_on;
			$prelist[] = $x;
		}
		$this->app_response(
			REST_Controller::HTTP_OK,
			array(
				'code' => '200',
				'message' => 'Data Prelist'
			),
			array(
				'prelist' => $prelist
			)


		);
	}
	
	public function download_post()
	{
		$token = $this->cektoken();
		$user_id = $token->user_id;
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$proses_id = $data->prelistServerId;;
		//$stereotype = $data->stereotype;

		$id['proses_id'] = $proses_id;
		$gmd = "
			EXEC dbo.sp_get_master_data ?
		";
		$prelist =  $this->db->query($gmd, $id);
		//$prelist = $this->auth_model->getSelectedData("dbo.master_data", $id);
		foreach ($prelist->result() as $db) {
			//	$stereotype_prelist = $db->stereotype;
			$prelistBpsFullCode = $db->bps_full_code;
			$prelistSls = $db->nama_sls;
			$prelistRw = $db->rw;
			$prelistRt = $db->rt;
			$prelistAddress = $db->alamat;
			$prelistIdPrelist = $db->id_prelist;
			$prelistKrtName = $db->nama_krt;
			$lat = $db->lat;
			$long = $db->long;
			$prelistDateSurvey = !empty($db->tanggal_pelaksanaan) ? DateTime::createFromFormat('d-m-Y H:i:s', $db->tanggal_pelaksanaan) : DateTime::createFromFormat('d-m-Y H:i:s', '00-00-0000 00:00:00');
			$prelistCheckUpResult = $db->keberadaan_ruta;
			$prelistStereotype = $db->stereotype;
			$prelistNote = $db->revoke_note;
			//	$dengan_foto = $db->dengan_foto;
		}

		if ($prelistStereotype == "P3" || $prelistStereotype == "P3a") {

			$status = 'M1';
			$cek = $this->cekAssignment($proses_id, $status);
			if ($cek == 0) {
				$up['stereotype'] = 'M1';
				$up['lastupdate_by'] = $user_id;
				$up['lastupdate_on'] = date("Y-m-d H:i:s");
				//	$rw = array('ACTIVE', 'NEW');
				$art['proses_id'] = $proses_id;
				$gmk = "
					EXEC dbo.sp_get_master_kk ?
				";
				$kk_list =  $this->db->query($gmk, $art);
				//$kk_list = $this->auth_model->getSelectedDataART("dbo.master_kartu_keluarga", $art);
				$kk_data = array();
				foreach ($kk_list->result() as $db) {
					$kk_foto = $this->auth_model->cek_foto_kk($db->id);
					$foto = str_replace( "./", base_url(), $kk_foto);
					$x['kkServerId'] = $db->id;
					$x['kkNuk'] = $db->nuk;
					$x['kkKind'] = $db->jenis_kk;
					$x['kkNoKk'] = $db->nokk;
					$x['kkRowStatus'] = $db->row_status;
					$x['kkPhotoLink'] = $foto;
					$kk_data[] = $x;
				}
				$gmdd = "
					EXEC dbo.sp_get_master_detail ?
				";
				$art_list =  $this->db->query($gmdd, $art);
				//$art_list = $this->auth_model->getSelectedDataART("dbo.master_data_detail", $art);
				$art_data = array();
				foreach ($art_list->result() as $db) {
					$x['artServerId'] = $db->id;
					$x['artArtName'] = $db->nama_art;
					$x['artCheckUpResult'] = $db->keberadaan_art;
					$x['artNuk'] = $db->nuk;
					$x['artNik'] = $db->nik;
					$x['artRelationWithHof'] = $db->hubungan_kepkel;
					$x['artGender'] = $db->jenis_kelamin;
					$x['artBornPlace'] = $db->tempat_lahir;
					$x['artDob'] = $db->tanggal_lahir;
					$x['artMotherName'] = $db->nama_ibu_kandung;
					$x['artRowStatus'] = $db->row_status;
					$x['artCanBeEdited'] = $db->status_edit;
					$art_data[] = $x;
				}
				//	$foto2 = [];
			} else {
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => 'Anda tidak diperbolehkan untuk mendownload prelist ini'
					)
				);
				die;
			}
		} else {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Anda tidak diperbolehkan untuk mendownload prelist ini'
				)
			);
			die;
		}

		$this->db->trans_begin();
		$ur['user_id'] = $user_id;
		$ur['proses_id'] = $proses_id;
		$ur['stereotype'] = 'M1';
		$ur['row_status'] = 'ACTIVE';
		$ur['created_by'] = $user_id;
		$ur['created_on'] = date("Y-m-d H:i:s");
		
		$this->db->query("EXEC dbo.sp_insert_assignment ?, ?, ?, ?, ?, ?", $ur);
		//$res = $this->auth_model->insertData("dbo.ref_assignment", $ur);

		$up['proses_id'] = $proses_id;
		$this->db->query("EXEC dbo.sp_update_master_data ?, ?, ?, ?", $up);
		//$res2 = $this->auth_model->updateData("dbo.master_data", $up, $id);
		$this->update_trails($id, $up);
		$this->update_trails2($id, $data);

		$desc = 'Data dengan ID-Prelist  ' . $prelistIdPrelist . ' diunduh oleh user id ' . $user_id . '.';
		$dl['created_by'] = $user_id;
		$dl['proses_id'] = $proses_id;
		$dl['status'] = 'sukses';
		$dl['stereotype'] = 'M1';
		$dl['description'] = $desc;
		$dl['prelist_id'] = $prelistIdPrelist;
		$dl['created_on'] = date("Y-m-d H:i:s");
		$this->db->query("EXEC dbo.sp_insert_master_log ?, ?, ?, ?, ?, ?, ?", $dl);
		//$res3 = $this->auth_model->insertData("dbo.master_data_log", $dl);


		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'success' => false,
					'proses_id' => $proses_id,
					'msg' => 'Gagal Download Prelist',
				)
			);
			
		} else {
			$this->db->trans_commit();
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Download Prelist'
				),
				array(
					"prelistServerId" => $proses_id,
					"prelistBpsFullCode" => $prelistBpsFullCode,
					"prelistSls" => $prelistSls,
					"prelistRw" => $prelistRw,
					"prelistRt" => $prelistRt,
					"prelistAddress" => $prelistAddress,
					"prelistIdPrelist" => $prelistIdPrelist,
					"prelistKrtName" => $prelistKrtName,
					"prelistDateSurvey" => null,
					"prelistCheckUpResult" => $prelistCheckUpResult,
					"prelistLatitude" => $lat,
					"prelistLongitude" => $long,
					"prelistStereotype" => $prelistStereotype,
					"prelistNote" => $prelistNote,
					"prelistKkList" => $kk_data,
					"prelistArtList" => $art_data

				)
			);
		}
	}

	public function synchronized_post()
	{
		$token = $this->cektoken();
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$user_id = $token->user_id;

		///data prelist
		$local_id = $data->prelistLocalId;
		$proses_id = $data->prelistServerId;
		$sync_status = $data->prelistSyncStatus;

		$kk_list = $data->prelistKkList;
		$art_list = $data->prelistArtList;

		///data prelist
		$up['nama_sls'] = $data->prelistSls;
		$up['alamat'] = $data->prelistAddress;
		$up['rw'] = $data->prelistRw;
		$up['rt'] = $data->prelistRt;
		$up['nama_krt'] = $data->prelistKrtName;
		$up['keberadaan_ruta'] = $data->prelistCheckUpResult;
		$up['lat'] = $data->prelistLatitude;
		$up['long'] = $data->prelistLongitude;
		$tanggal_pelaksanaan = $data->prelistDateSurvey;
		if ($tanggal_pelaksanaan != 0 || !empty($tanggal_pelaksanaan))
			$up['tanggal_pelaksanaan'] = date('Y-m-d H:i:s', $tanggal_pelaksanaan / 1000);
		else
			$up['tanggal_pelaksanaan'] = date('Y-m-d H:i:s');
		$last_submit = $data->prelistMobileLastSubmitted;
			if ($last_submit != 0 || !empty($last_submit))
				$up['last_submit'] = date('Y-m-d H:i:s', $last_submit / 1000);
			else
				$up['last_submit'] = date('Y-m-d H:i:s');
			
	
		$up['lastupdate_by'] = $user_id;
		$up['lastupdate_on'] = date("Y-m-d H:i:s");
		$this->db->trans_begin();
		if ($sync_status == 'UPDATE') {
			$status = 'M1';
			$cek = $this->cekAssignment2($proses_id, $status, $user_id);
			if ($cek > 0) {
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => 'Anda tidak diperbolehkan untuk update prelist ini'
					)
				);
			}
			if (empty($proses_id)) {
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => 'Masukan Proses id'
					)
				);
			}
			if (!empty($art_list)) {
				foreach ($art_list as $key => $art_value) {
					$art['proses_id'] = $proses_id;
					$art['nama_art'] = $art_value->artArtName;
					$art['jenis_kelamin'] = $art_value->artGender;
					$art['tempat_lahir'] = $art_value->artBornPlace;
					$art['tanggal_lahir'] = $art_value->artDob;
					$art['hubungan_kepkel'] = $art_value->artRelationWithHof;
					$art['nik'] = $art_value->artNik;
					$art['nuk'] = $art_value->artNuk;
					$art['row_status'] = $art_value->artRowStatus;
					$art['keberadaan_art'] = $art_value->artCheckUpResult;
					$art['nama_ibu_kandung'] = $art_value->artMotherName;
					$art['stereotype'] = 'M2';
					// if (empty($art_value->artServerId) || $art_value->artServerId == '' || $art_value->artServerId == '0') {
					// 	$art['status'] = 'ACTIVE';
					// 	$art['created_by'] = $user_id;
					// 	$art['created_on'] = date("Y-m-d H:i:s");
					// 	$art['id'] = 0;
					// 	//$res2 = $this->auth_model->insertData("dbo.master_data_detail", $art);
					// 	$this->db->query("EXEC dbo.sp_sync_master_detail ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
					// 	$status = 'NEW-ART';
					// 	$desc = "Data ART " . $art['nama_art'] . " ditambahkan oleh user " . $user_id . '.';
					// 	$id_art = $res2;
					// } else {
						//$art_id['id'] = $art_value->artServerId;
					$art['status'] = 'ACTIVE';
					$art['lastupdate_by'] = $user_id;
					$art['lastupdate_on'] = date("Y-m-d H:i:s");
					$art['id'] = $art_value->artServerId;
					//$res2 = $this->auth_model->updateData("dbo.master_data_detail", $art, $art_id);
					$this->db->query("EXEC dbo.sp_sync_master_detail ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
					$status = 'UPDATING-ART';
					$desc = "Data ART " . $art['nama_art'] . " diperbaharui oleh user " . $user_id . '.';
					$id_art = $art_value->artServerId;
					// }
					$list_art[] = array(
						'artServerId' => $id_art,
						'artLocalId' => $art_value->artLocalId
					);

					$dl_art['created_by'] = $user_id;
					$dl_art['detail_id'] = $id_art;
					$dl_art['status'] = 'sukses';
					$dl_art['stereotype'] = $status;
					$dl_art['description'] = $desc;
					$dl_art['created_on'] = date("Y-m-d H:i:s");
				//	$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
					//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
				}
			} else {
				$list_art = [];
			}
			if (!empty($kk_list)) {
				foreach ($kk_list as $key => $kk_value) {
					$kk['proses_id'] = $proses_id;
					$kk['nokk'] = $kk_value->kkNoKk;
					$kk['nuk'] = $kk_value->kkNuk;
					$kk['row_status'] = $kk_value->kkRowStatus;
					$kk['jenis_kk'] = $kk_value->kkKind;
					if (empty($kk_value->kkServerId) || $kk_value->kkServerId == '' || $kk_value->kkServerId == '0') {
						$kk['created_by'] = $user_id;
						$kk['created_on'] = date("Y-m-d H:i:s");
						$kk['id'] = 0;
						//$res2 = $this->auth_model->insertData("dbo.master_kartu_keluarga", $kk);
						$query_kk = $this->db->query("EXEC dbo.sp_sync_kartu_keluarga ?, ?, ?, ?, ?, ?, ?, ?", $kk);
						$last_id = '';
						foreach ($query_kk->result() as $db) {
							$last_id = $db->last_id;
							
						}
						$status = 'NEW-KK';
						$desc = "Data KK " . $kk['nokk'] . " ditambahkan oleh user " . $user_id . '.';
						$id_kk = $last_id;
					} else {
						$kk['created_by'] = $user_id;
						$kk['created_on'] = date("Y-m-d H:i:s");
						$kk['id'] = $kk_value->kkServerId;
						//$res2 = $this->auth_model->updateData("dbo.master_kartu_keluarga", $kk, $kk_id);
						$this->db->query("EXEC dbo.sp_sync_kartu_keluarga ?, ?, ?, ?, ?, ?, ?, ?", $kk);
					
						$status = 'UPDATING-KK';
						$desc = "Data KK " . $kk['nokk'] . " diperbaharui oleh user " . $user_id . '.';
						$id_kk = $kk_value->kkServerId;
					}

					$list_kk[] = array(
						'kkServerId' => $id_kk,
						'kkLocalId' => $kk_value->kkLocalId
					);

					$dl_kk['created_by'] = $user_id;
					$dl_kk['kk_id'] = $id_kk;
					$dl_kk['status'] = 'sukses';
					$dl_kk['stereotype'] = $status;
					$dl_kk['description'] = $desc;
					$dl_kk['created_on'] = date("Y-m-d H:i:s");
				//	$this->db->query("EXEC dbo.sp_insert_kk_log ?, ?, ?, ?, ?, ?", $dl_kk);
				//	$this->auth_model->insertData("dbo.master_kk_log", $dl_kk);
				}
			} else {
				$list_kk = [];
			}

			$up['stereotype'] = 'M2';
			$up['proses_id'] = $proses_id;
			$id['proses_id'] = $proses_id;
			$status = 'M2-UPDATED';
			$desc = 'Data Prelist ' . $proses_id . ' di update oleh user id ' . $user_id . '.';
			//$res2 = $this->auth_model->updateData("dbo.master_data", $up, $id);
			$this->db->query("EXEC dbo.sp_sync_master_data ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $up);
			$this->update_trails($id, $up);
			$this->update_trails2($id, $data);
		} else if ($sync_status == 'SUBMIT') {
			//$strfoto = 'M-';
			//$cekfoto = $this->cek_foto($proses_id, $strfoto);
			$status = 'M1';
			$cek = $this->cekAssignment2($proses_id, $status, $user_id);
			if ($cek > 0) {
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => 'Anda tidak diperbolehkan untuk submit prelist ini'
					)
				);
			}
			if (empty($proses_id)) {
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => 'Masukan Proses id'
					)
				);
			}

			if (!empty($art_list)) {
				foreach ($art_list as $key => $art_value) {
					$art['proses_id'] = $proses_id;
					$art['nama_art'] = $art_value->artArtName;
					$art['jenis_kelamin'] = $art_value->artGender;
					$art['tempat_lahir'] = $art_value->artBornPlace;
					$art['tanggal_lahir'] = $art_value->artDob;
					$art['hubungan_kepkel'] = $art_value->artRelationWithHof;
					$art['nik'] = $art_value->artNik;
					$art['nuk'] = $art_value->artNuk;
					$art['row_status'] = $art_value->artRowStatus;
					$art['keberadaan_art'] = $art_value->artCheckUpResult;
					$art['nama_ibu_kandung'] = $art_value->artMotherName;
					if ($art_value->artCheckUpResult == 1 || $art_value->artCheckUpResult == 6)
						$art['stereotype'] = 'M4';
					else
						$art['stereotype'] = 'MKb';
					// if (empty($art_value->artServerId) || $art_value->artServerId == '' || $art_value->artServerId == '0') {
					// 	$art['status'] = 'ACTIVE';
					// 	$art['created_by'] = $user_id;
					// 	$art['created_on'] = date("Y-m-d H:i:s");
					// 	$art['id'] = 0;
					// 	//$res2 = $this->auth_model->insertData("dbo.master_data_detail", $art);
					// 	$this->db->query("EXEC dbo.sp_sync_master_detail ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
					// 	$status2 = 'NEW-ART';
					// 	$desc = "Data ART " . $art['nama_art'] . " ditambahkan oleh user " . $user_id . '.';
					// 	$id_art = $res2;
					// } else {
						//$art_id['id'] = $art_value->artServerId;
					$art['status'] = 'ACTIVE';
					$art['lastupdate_by'] = $user_id;
					$art['lastupdate_on'] = date("Y-m-d H:i:s");
					$art['id'] = $art_value->artServerId;
					//$res2 = $this->auth_model->updateData("dbo.master_data_detail", $art, $art_id);
					$this->db->query("EXEC dbo.sp_sync_master_detail ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
					$status2 = 'UPDATING-ART';
					$desc = "Data ART " . $art['nama_art'] . " diperbaharui oleh user " . $user_id . '.';
					$id_art = $art_value->artServerId;
					// }
					$list_art[] = array(
						'artServerId' => $id_art,
						'artLocalId' => $art_value->artLocalId
					);

					$dl_art['created_by'] = $user_id;
					$dl_art['detail_id'] = $id_art;
					$dl_art['status'] = 'sukses';
					$dl_art['stereotype'] = $art['stereotype'];
					$dl_art['description'] = $desc;
					$dl_art['created_on'] = date("Y-m-d H:i:s");
					$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
					//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
				}
			} else {
				$list_art = [];
			}
			if (!empty($kk_list)) {
				foreach ($kk_list as $key => $kk_value) {
					$kk['proses_id'] = $proses_id;
					$kk['nokk'] = $kk_value->kkNoKk;
					$kk['nuk'] = $kk_value->kkNuk;
					$kk['row_status'] = $kk_value->kkRowStatus;
					$kk['jenis_kk'] = $kk_value->kkKind;
					if (empty($kk_value->kkServerId) || $kk_value->kkServerId == '' || $kk_value->kkServerId == '0') {
						$kk['created_by'] = $user_id;
						$kk['created_on'] = date("Y-m-d H:i:s");
						$kk['id'] = 0;
						//$res2 = $this->auth_model->insertData("dbo.master_kartu_keluarga", $kk);
						$query_kk = $this->db->query("EXEC dbo.sp_sync_kartu_keluarga ?, ?, ?, ?, ?, ?, ?, ?", $kk);
						$last_id = '';
						foreach ($query_kk->result() as $db) {
							$last_id = $db->last_id;
							
						}
						$status = 'NEW-KK';
						$desc = "Data KK " . $kk['nokk'] . " ditambahkan oleh user " . $user_id . '.';
						$id_kk = $last_id;
					} else {
						$kk['created_by'] = $user_id;
						$kk['created_on'] = date("Y-m-d H:i:s");
						$kk['id'] = $kk_value->kkServerId;
						//$res2 = $this->auth_model->updateData("dbo.master_kartu_keluarga", $kk, $kk_id);
						$this->db->query("EXEC dbo.sp_sync_kartu_keluarga ?, ?, ?, ?, ?, ?, ?, ?", $kk);
						$status = 'UPDATING-KK';
						$desc = "Data KK " . $kk['nokk'] . " diperbaharui oleh user " . $user_id . '.';
						$id_kk = $kk_value->kkServerId;
					}

					$list_kk[] = array(
						'kkServerId' => $id_kk,
						'kkLocalId' => $kk_value->kkLocalId
					);

					$dl_kk['created_by'] = $user_id;
					$dl_kk['kk_id'] = $id_kk;
					$dl_kk['status'] = 'sukses';
					$dl_kk['stereotype'] = $status;
					$dl_kk['description'] = $desc;
					$dl_kk['created_on'] = date("Y-m-d H:i:s");
					$this->db->query("EXEC dbo.sp_insert_kk_log ?, ?, ?, ?, ?, ?", $dl_kk);
				//	$this->auth_model->insertData("dbo.master_kk_log", $dl_kk);
				}
			} else {
				$list_kk = [];
			}

			if ($data->prelistCheckUpResult == 1)
				$status = $up['stereotype'] = 'M4';
			else
				$status = $up['stereotype'] = 'M4a';
			
			$up['proses_id'] = $proses_id;
			$id['proses_id'] = $proses_id;
		

			$desc = 'Data Prelist ' . $proses_id . ' disubmit oleh user id ' . $user_id . '.';

			//$res2 = $this->auth_model->updateData("dbo.master_data", $up, $id);
			$this->db->query("EXEC dbo.sp_sync_master_data ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $up);
			$this->update_trails($id, $up);
			$this->update_trails2($id, $data);
		}


		$idx['proses_id'] = $proses_id;
		$prelist = $this->auth_model->getSelectedData("dbo.master_data", $idx);
		foreach ($prelist->result() as $db) {
			$prelistIdPrelist = $db->id_prelist;
		}
		$dl['created_by'] = $user_id;
		$dl['proses_id'] = $proses_id;
		$dl['status'] = 'sukses';
		$dl['stereotype'] = $status;
		$dl['description'] = $desc;
		$dl['prelist_id'] = $prelistIdPrelist;
		$dl['created_on'] = date("Y-m-d H:i:s");
		if ($sync_status == 'SUBMIT')
		{
			$this->db->query("EXEC dbo.sp_insert_master_log ?, ?, ?, ?, ?, ?, ?", $dl);
		}
		//$res3 = $this->auth_model->insertData("dbo.master_data_log", $dl);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Gagal UPDATE/SUBMITTED'
				)
			);
		} else {
			$this->db->trans_commit();
			// if ($sync_status == 'SUBMIT')
			// {
			// 	$this->pemadanan_data($proses_id);
			// }
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Syncron Prelist'
				),
				array(
					'prelistServerId' => $proses_id,
					'prelistLocalId' => $local_id,
					'prelistArtList' => $list_art,
					'prelistKkList' => $list_kk,

				)
			);
			
		}
		
	}
	public function pemadanan_data($proses_id)
	{
		$url     = "http://siksnik.kemsos.net/api/clidata/ceknik" ;
		
		//$idx['stereotype'] = 'M4';
		
		$sqln = "
			SELECT * FROM master_data_detail
			WHERE proses_id =".$proses_id." and stereotype = 'M4'
		";
		//$get_data =  $this->db->query("EXEC dbo.sp_get_data_m4");
		$get_data = $this->db->query($sqln);
		if($get_data->num_rows() > 0) {
			foreach ($get_data->result() as $db) {
				$nik = $db->nik;
				$idart = $db->id;
				$nama_art = str_replace("'","",$db->nama_art);
				$nama_art2 = str_replace('"','',$nama_art);
				$jumlah_hit = $db->jumlah_hit;
				$data = ['NIK'=>$nik , 'token'=>'IoRJ0FnMdB5Bckhj0emY5jvbgCfm15PQZXWZs3Riml'];
				$ch = curl_init($url);
				
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

				curl_setopt($ch, CURLOPT_USERAGENT , 'PostmanRuntime/7.26.5');
					
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				curl_close($ch);
				$output2 = json_decode($output);
				$cek_api = 0;
				if(!empty($output2->content))
				{
					foreach ($output2->content as $entry) {
						if(empty($entry->RESPON))
						{
							$art['NO_KK'] = $entry->NO_KK;
							$art['DUSUN'] = $entry->DUSUN;
							$art['NIK'] = $entry->NIK;
							$art['NAMA_LGKP'] = $entry->NAMA_LGKP;
							$art['STAT_HBKEL'] = $entry->STAT_HBKEL;
							$art['KAB_NAME'] = $entry->KAB_NAME;
							$art['NAMA_LGKP_AYAH'] = $entry->NAMA_LGKP_AYAH;
							$art['NO_RW'] = $entry->NO_RW;
							$art['KEC_NAME'] = $entry->KEC_NAME;
							$art['JENIS_PKRJN'] = $entry->JENIS_PKRJN;
							$art['NO_RT'] = $entry->NO_RT;
							$art['NO_KEL'] = $entry->NO_KEL;
							$art['ALAMAT'] = $entry->ALAMAT;
							$art['NO_KEC'] = $entry->NO_KEC;
							$art['TMPT_LHR'] = $entry->TMPT_LHR;
							$art['PDDK_AKH'] = $entry->PDDK_AKH;
							$art['NO_PROP'] = $entry->NO_PROP;
							$art['STATUS_KAWIN'] = $entry->STATUS_KAWIN;
							$art['NAMA_LGKP_IBU'] = $entry->NAMA_LGKP_IBU;
							$art['PROP_NAME'] = $entry->PROP_NAME;
							$art['NO_KAB'] = $entry->NO_KAB;
							$art['KEL_NAME'] = $entry->KEL_NAME;
							$art['JENIS_KLMIN'] = $entry->JENIS_KLMIN;
							$art['TGL_LHR'] = $entry->TGL_LHR;
							$id['NIK'] = $entry->NIK;
							//$data2 = $this->auth_model->getSelectedData("dbo.HITNIK", $id);
							//if($data2->num_rows() == 0) {
								$this->db->query("EXEC dbo.sp_insert_hitnik ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
								//$this->auth_model->insertData("dbo.HITNIK", $art);
							//} 
							$list_art[] = array(
								'data' => $entry
							);
							$nama_capil = str_replace("'","",$entry->NAMA_LGKP);
							$nama_capil2 = str_replace('"','',$nama_capil);
							$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$nama_capil2);
							$nilai = $nilai_padan * 100;
							if($nilai>=60)
							{
								$mdd['stereotype'] = 'MK';
								//$this->db->set('stereotype', 'MK');
								$status = 'MK';
								$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
							}
							else
							{
								if(strpos($nama_capil2, '/') !== false){
									$str = explode("/",$nama_capil2);
									$MAX_VALUE=0;
									for ($i = 0; $i < count($str); $i++)  {
										$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$str[$i]);
										$nilai = $nilai_padan * 100;
										if($nilai > $MAX_VALUE){
											$MAX_VALUE=$nilai;
										}
									}
									if($MAX_VALUE>=60)
									{
										$mdd['stereotype'] = 'MK';
										//$this->db->set('stereotype', 'MK');
										$status = 'MK';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									else
									{
										$mdd['stereotype'] = 'MKa';
										//$this->db->set('stereotype', 'MKa');
										$status = 'MKa';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}	
								}
								elseif(strpos($nama_art2, '/') !== false){
									$str = explode("/",$nama_art2);
									$MAX_VALUE=0;
									for ($i = 0; $i < count($str); $i++)  {
										$nilai_padan = $this->cek_padan(strtoupper($str[$i]),$nama_capil2);
										$nilai = $nilai_padan * 100;
										if($nilai > $MAX_VALUE){
											$MAX_VALUE=$nilai;
										}
									}
									if($MAX_VALUE>=60)
									{
										$mdd['stereotype'] = 'MK';
										//$this->db->set('stereotype', 'MK');
										$status = 'MK';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									else
									{
										$mdd['stereotype'] = 'MKa';
										//$this->db->set('stereotype', 'MKa');
										$status = 'MKa';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									
								}
								else
								{
									$mdd['stereotype'] = 'MKa';
									//$this->db->set('stereotype', 'MKa');
									$status = 'MKa';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
							
								}
							}
							$cek_api = 1;
						}
						elseif($entry->RESPON == 'Data Tidak Ditemukan')
						{
							$mdd['stereotype'] = 'MKa';
							//$this->db->set('stereotype', 'MKa');
							$status = 'MKa';
							$desc = "Data ART NIK" . $nik . " TIDAK PADAN, Data Tidak Ditemukan ";
							$cek_api = 1;
						}
						else
						{
							$cek_api = 0;
						}
					}
					
				}
				else
				{
					$cek_api = 0;
				}
				if($cek_api==1)
				{
					$mdd['jumlah_hit'] = $jumlah_hit + 1;
					$mdd['id'] = $idart;
					$this->db->query("EXEC dbo.sp_update_mdd_pemadanan ?, ?, ?", $mdd);
					// $this->db->set('jumlah_hit', $jumlah_hit + 1);
					// $this->db->where('IDARTBDT', $idartbdt);
					// $this->db->update('dbo.master_data_detail');
					$dl_art['created_by'] = 0;
					$dl_art['detail_id'] = $idart;
					$dl_art['status'] = 'sukses';
					$dl_art['stereotype'] = $status;
					$dl_art['description'] = $desc;
					$dl_art['created_on'] = date("Y-m-d H:i:s");
					$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
				}

				//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
			}
			//print_r(json_encode($list_art));
		}
		
	}

	public function cek_padan($param1,$param2)
	{
		$sqln = '
			DECLARE @dblSimil float
			EXEC dbo.spSimil "'.$param1.'", "'.$param2.'" , @dblSimil OUTPUT
			SELECT @dblSimil
		';
		$get_data = $this->db->query($sqln);
		$row = $get_data->row_array();
		return $row[''];
	}

	function cleardata_post()
	{
		$token = $this->cektoken();
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$user_id = $token->user_id;
		$list_data = array();
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$prelistServerId = $value->prelistServerId;
				$prelistLocalId = $value->prelistLocalId;
				$prelistMobileLastSubmitted = $value->prelistMobileLastSubmitted;
				$ud['proses_id'] = $prelistServerId;
				if ($prelistMobileLastSubmitted != 0 || !empty($prelistMobileLastSubmitted))
					$ud['last_submit'] = date('Y-m-d H:i:s', $prelistMobileLastSubmitted / 1000);
				$data2 = $this->auth_model->getSelectedData("dbo.master_data", $ud);
				if ($data2->num_rows() > 0) {
					$list_data[] = array(
						'prelistServerId' => $prelistServerId,
						'prelistLocalId' => $prelistLocalId
					);
				}
			}
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Data Prelist'
				),
				array(
					'prelist' => $list_data
				)
			);
		} else {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'prelist server id cannot be blank'
				)
			);
		}
	}
	function cekAssignment($proses_id, $status)
	{
		$id['proses_id'] = $proses_id;
		$id['row_status'] = 'ACTIVE';
		$id['stereotype'] = $status;
		$prelist = $this->auth_model->getSelectedData("dbo.ref_assignment", $id);

		if ($prelist->num_rows() > 0)
			return 1;
		else
			return 0;
	}
	function cekAssignment2($proses_id, $status, $user_id)
	{
		$id['proses_id'] = $proses_id;
		$id['row_status'] = 'ACTIVE';
		$id['stereotype'] = $status;
		$id['user_id'] = $user_id;
		$prelist = $this->auth_model->getSelectedData("dbo.ref_assignment", $id);

		if ($prelist->num_rows() > 0)
			return 0;
		else
			return 1;
	}
	function cek_foto($proses_id, $stereotype)
	{
		$id['owner_id'] = $proses_id;
		$data = $this->auth_model->getFoto("dbo.files", $id, $stereotype);
		return $data->num_rows();
	}

	function update_trails($id, $data)
	{
		$token = $this->cektoken();
		$username = $token->username;
		$prelist = $this->auth_model->getSelectedData("dbo.master_data", $id);

		foreach ($prelist->result() as $db) {
			$stereotype = $db->stereotype;
			$id_prelist = $db->id_prelist;
			$audit_trails = $db->audit_trails;
		}
		$old_json = json_decode($audit_trails);

		$column_data['proses_id'] = $id['proses_id'];
		$column_data['id_prelist'] = $id_prelist;
		$column_data['stereotype'] = $data['stereotype'];
		$up['ip'] = $this->GetClientIP();
		$up['on'] = date("Y-m-d H:i:s");;
		$up['act'] = 'UPDATED';
		$up['user_id'] = $data['lastupdate_by'];
		$up['username'] = $username;
		$up['column_data'] = $column_data;
		$up['is_proxy_access'] = false;
		$new_json[] = $up;
		if (empty($old_json))
			$res = $new_json;
		else
			$res = array_merge($new_json, $old_json);

		$update['audit_trails'] = json_encode($res);
		$this->auth_model->updateData("dbo.master_data", $update, $id);
	}
	function update_trails2($id, $data)
	{
		$token = $this->cektoken();
		$username = $token->username;
		$prelist = $this->auth_model->getSelectedData("dbo.master_data", $id);

		foreach ($prelist->result() as $db) {
			$stereotype = $db->stereotype;
			$id_prelist = $db->id_prelist;
			$audit_trails = $db->audit_trails2;
		}
		$old_json = json_decode($audit_trails);

		$new_json[] = $data;
		if (empty($old_json))
			$res = $new_json;
		else
			$res = array_merge($new_json, $old_json);

		$update['audit_trails2'] = json_encode($res);
		$this->auth_model->updateData("dbo.master_data", $update, $id);
	}


	public function GetClientIP()
	{
		if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1')
			$ip = 'localhost';
		else
			$ip = $_SERVER['REMOTE_ADDR'];
		return ($ip);
	}
}
