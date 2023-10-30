<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coordination extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('server/auth_model');
	}

	public function synchronized_post()
	{
		$token = $this->cektoken();
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$user_id = $token->user_id;

		///data coordination
		$up['bps_code'] = $data->bpsFullCode;
		$up['jml_art_terkonfirmasi'] = $data->totalArtConfirmed;
		$up['jml_art_tidak_terkonfirmasi'] = $data->totalArtNotConfirmed;
		$up['jml_art_meninggal'] = $data->totalArtDied;
		$up['jml_art_ganda'] = $data->totalArtDouble;
		$up['jml_art_no_dokumen'] = $data->totalArtNotRecorded;
		$up['total_art_hasil_perbaikan'] = $data->totalArtRepair;
		$up['kontak_kepala_desa'] = $data->headmanMobilePhone;
		$up['kontak_operator_desa'] = $data->villageOperatorsMobilePhone;
		$up['latitude'] = $data->coordinationLatitude;
		$up['longitude'] = $data->coordinationLongitude;
		$up['lastupdate_by'] = $user_id;
		$up['lastupdate_on'] = date("Y-m-d H:i:s");
		$id['bps_code'] = $data->bpsFullCode;
		$cek = $this->cekKoordinasi($data->bpsFullCode);
		if ($cek > 0) {
			$id['bps_code'] = $data->bpsFullCode;
			$res = $this->auth_model->updateData("dbo.koordinasi", $up, $id);
			$this->update_trails($id, $data);
		}
		else
		{
			$id['bps_code'] = $data->bpsFullCode;
			$res = $this->auth_model->insertData2("dbo.koordinasi", $up);
			$this->update_trails($id, $data);
		}
		if ($res) {
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Berhasil tambah atau update koordinasi'
				),
				array(
					'bpsFullCode' => $data->bpsFullCode
					

				)
			);
		} else {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Gagal UPDATE/INSERT'
				)
			);
		}
	}

	function cekKoordinasi($bps)
	{
		$id['bps_code'] = $bps;
		$prelist = $this->auth_model->getSelectedData("dbo.koordinasi", $id);

		if ($prelist->num_rows() > 0)
			return 1;
		else
			return 0;
	}

	function update_trails($id, $data)
	{
		$token = $this->cektoken();
		$prelist = $this->auth_model->getSelectedData("dbo.koordinasi", $id);

		foreach ($prelist->result() as $db) {
			$audit_trails = $db->audit_trails;
		}
		$old_json = json_decode($audit_trails);

		$new_json[] = $data;
		if (empty($old_json))
			$res = $new_json;
		else
			$res = array_merge($new_json, $old_json);

		$update['audit_trails'] = json_encode($res);
		$this->auth_model->updateData("dbo.koordinasi", $update, $id);
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
