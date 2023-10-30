<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Photo extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('server/auth_model');
	}

	function uploadPhoto_post()
	{
		$token = $this->cektoken();
		$errors = array();
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$user_id = $token->user_id;
		$mobile_file_id = $data->filePhotoLocalId;
		$owner_id = $data->fileParentId;
		$location_id = $data->fileLocationId;
		$description = $data->fileDesc;
		$latitude = $data->fileLatitude;
		$longitude = $data->fileLongitude;
		$row_status = $data->fileRowStatus;
		$stereotype = $data->fileStereotype;
		$file = $data->filePhoto;
		$size = (int) (strlen(rtrim($file, '=')) * 3 / 4 / 1000);
		$file_name = $data->fileName;
		if (empty($stereotype)) {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'fileStereotype cannot be blank'
				)
			);
		}
		$region = $this->auth_model->ambil_location_prelist($location_id);
		$temp_path = $region['province'] . '/' . $region['regency'] . '/' . $region['district'] . '/' . $region['village'] . '/' . $owner_id;
		$image = base64_decode($file);
		$filename = $file_name;
		if (!is_dir('assets/photos/' . $temp_path)) {
			mkdir('./assets/photos/' . $temp_path, 0777, TRUE);
		}
		$path = "./assets/photos/" . $temp_path . "/";

		file_put_contents($path . $filename, $image);


		$up['owner_id'] = $owner_id;
		$up['file_name'] = $filename;
		$up['file_size'] = $size;
		$up['internal_filename'] = $path . $filename;
		$up['description'] = $description;
		$up['latitude'] = $latitude;
		$up['longitude'] = $longitude;
		$up['stereotype'] = $stereotype;
		$up['row_status'] = $row_status;
		$up['created_by'] = $user_id;
		$up['created_on'] = date("Y-m-d H:i:s");
		$up['ip_user'] = $this->GetClientIP();

		$id['file_name'] = $filename;
		$ud['description'] = $description;
		$ud['stereotype'] = $stereotype;
		$ud['row_status'] = $row_status;
		$ud['internal_filename'] = $path . $filename;
		$ud['lastupdate_by'] = $user_id;
		$ud['lastupdate_on'] = date("Y-m-d H:i:s");
		$data = $this->auth_model->getSelectedData("dbo.files", $id);
		if ($data->num_rows() > 0) {
			$this->auth_model->updateData("dbo.files", $ud, $id);
			foreach ($data->result() as $db) {
				$res = $db->file_id;
			}
		} else {
			$res = $this->auth_model->insertData("dbo.files", $up);
		}
		if ($res) {
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Upload Photo'
				),
				array(
					'filePhotoServerId' => $res,
					'filePhotoLocalId' => $mobile_file_id,
				)
			);
		} else {
			$this->app_error(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'success' => false,
					'msg' => 'Gagal Upload Foto',
					'mobile_file_id' => $mobile_file_id,
				)
			);
		}
	}
	function uploadphotoregister_post()
	{
		$json = file_get_contents("php://input");
		$data = json_decode($json);
		$user_id = $data->fileOwnerId;
		$mobile_file_id = $data->filePhotoLocalId;
		$fileOwnerNik = $data->fileOwnerNik;
		$location_id = $data->fileLocationId;
		$description = $data->fileDesc;
		$latitude = $data->fileLatitude;
		$longitude = $data->fileLongitude;
		$row_status = $data->fileRowStatus;
		$stereotype = $data->fileStereotype;
		$file = $data->filePhoto;
		$size = (int) (strlen(rtrim($file, '=')) * 3 / 4 / 1000);
		$file_name = $data->fileName;
		if (empty($stereotype)) {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'fileStereotype cannot be blank'
				)
			);
		}
		$region = $this->auth_model->ambil_location_prelist($location_id);
		$temp_path = $region['province'] . '/' . $region['regency'] . '/' . $fileOwnerNik;
		$image = base64_decode($file);
		$filename = $file_name;
		if (!is_dir('assets/enum/' . $temp_path)) {
			mkdir('./assets/enum/' . $temp_path, 0777, TRUE);
		}
		$path = "./assets/enum/" . $temp_path . "/";

		file_put_contents($path . $filename, $image);


		$up['owner_id'] = $user_id;
		$up['file_name'] = $filename;
		$up['file_size'] = $size;
		$up['internal_filename'] = $path . $filename;
		$up['description'] = $description;
		$up['latitude'] = $latitude;
		$up['longitude'] = $longitude;
		$up['stereotype'] = $stereotype;
		$up['row_status'] = $row_status;
		$up['created_by'] = $user_id;
		$up['created_on'] = date("Y-m-d H:i:s");
		$up['ip_user'] = $this->GetClientIP();

		$id['file_name'] = $filename;
		$ud['description'] = $description;
		$ud['stereotype'] = $stereotype;
		$ud['row_status'] = $row_status;
		$ud['internal_filename'] = $path . $filename;
		$ud['lastupdate_by'] = $user_id;
		$ud['lastupdate_on'] = date("Y-m-d H:i:s");
		$data = $this->auth_model->getSelectedData("dbo.files", $id);
		if ($data->num_rows() > 0) {
			$this->auth_model->updateData("dbo.files", $ud, $id);
			foreach ($data->result() as $db) {
				$res = $db->file_id;
			}
		} else {
			$res = $this->auth_model->insertData("dbo.files", $up);
		}
		if ($res) {
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Upload Photo'
				),
				array(
					'filePhotoServerId' => $res,
					'filePhotoLocalId' => $mobile_file_id,
				)
			);
		} else {
			$this->app_error(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'success' => false,
					'msg' => 'Gagal Upload Foto',
					'mobile_file_id' => $mobile_file_id,
				)
			);
		}
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
