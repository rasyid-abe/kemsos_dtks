<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('server/auth_model');
	}


	public function login_post()
	{
		try {
			$this->load->library('encryption');
			$errors = '';
			$json = file_get_contents("php://input");
			$data = json_decode($json);
			$username = $data->userMobilePhone;
			$password = $data->userPassword;
			$android_id = $data->deviceAndroidId;
			if (!isset($username) || !strlen($username))
				$errors .=  'Username tidak boleh kosong. ';

			if (!isset($password) || !strlen($password))
				$errors .=  'Password tidak boleh kosong. ';

			if (empty($errors)) {
				$user_account = $this->auth_model->get_member_account($username);

				if (empty($user_account))
					$errors .=  'Username tidak terdaftar, silahkan periksa kembali. ';
				// if (!password_verify($password, $user_account->password))
				if (!empty($user_account)) {
					if ($password != $this->encryption->decrypt($user_account->password))
						$errors .=  'Password salah, silahkan periksa kembali. ';
				}
				if (!empty($user_account) && $user_account->user_account_is_active == 0) {
					$errors .=  'Akun anda tidak aktif. ';
				}
				if ($user_account) {
					$id['user_profile_id'] = $user_account->user_account_id;
					$user_profile = $this->auth_model->getSelectedData("core_user_profile", $id);
					foreach ($user_profile->result() as $db) {
						$user_android_id = $db->user_profile_android_id;
						$user_profile_no_hp = $db->user_profile_no_hp;
						$userFullName = $db->user_profile_first_name . ' ' . $db->user_profile_last_name;
					}
					if ($user_android_id != '' && !is_null($user_android_id) && $user_android_id != $android_id)
						$errors .=  'Anda mencoba login menggunakan perangkat/HP yang berbeda. ';

					$user_group = $this->auth_model->getGroupUser($user_account->user_account_id);
					if ($user_group->num_rows() > 0) {
						foreach ($user_group->result() as $db) {
							$group[] = $db->title;
						}
					} else {
						$errors .=  'Anda belum mempunyai group di aplikasi ini. ';
					}
				}
			}


			/* response error validation */
			if (!empty($errors))
				$this->app_response(
					REST_Controller::HTTP_BAD_REQUEST,
					array(
						'code' => '400',
						'message' => $errors
					)
				);
			$log = $user_account->username . " logged in.\n\n";
			if ($user_android_id == '' || is_null($user_android_id)) {
				$ud['user_profile_android_id'] = $android_id;
				$id_d['user_profile_id'] = $user_account->user_account_id;
				$this->auth_model->updateData("core_user_profile", $ud, $id_d);

				$log .= "Device Information:\n\n";
				$log .= "Android ID: " . $android_id . "\n";
				$log .= "Application Version: " . $data->deviceAppVersion . "\n";
				$log .= "API Level: " . $data->deviceApiLevel . "\n";
				$log .= "Device Name: " . $data->deviceName . "\n";
				$log .= "Device Model: " . $data->deviceModel . "\n";
				$log .= "Resolution: " . $data->deviceResolution . "\n";
				$log .= "Memory Available: " . $data->deviceMemorySize . " MB\n";
				$log .= "Back Camera: " . $data->deviceBackCameraResolution . "\n";
				$log .= "Connection Type: " . $data->deviceConnectionType . "\n";
				$log .= "Internal Storage Available: " . $data->deviceStorageSize . "\n";
				$log .= "Internal Storage Size: " . $data->deviceStorageSize . "\n";

				$tag = "FIRST-TIME-LOGIN";
			} else {
				$tag = "LOGIN";
			}

			$log .= "GPS Information:\n\n";
			$log .= "Latitude: " . $data->deviceGpsLatitude . "\n";
			$log .= "Longitude: " . $data->deviceGpsLongitude . "\n";

			$up['user_id'] = $user_account->user_account_id;
			$up['user_logged_on'] = date("Y-m-d H:i:s");
			$up['user_ip_address'] = $this->GetClientIP();
			$up['user_stereotype'] = $tag;
			$up['user_desciption'] = $log;

			$this->auth_model->insertData("user_log", $up);


			/* create token jwt */
			$token_start = time();
			$token_expired = strtotime(TOKEN_TIMEOUT, $token_start);

			$payload = (object) array(
				'username' => $username,
				"user_id" => $user_account->user_account_id,
				'token_start' => $token_start,
				'token_expired' => $token_expired,
				"group" => $group,
			);

			$token = $this->jwt->encode($payload, config_item('jwt_key'));

			$ua['user_account_token'] = $token;
			$id_ua['user_account_id'] = $user_account->user_account_id;
			$this->auth_model->updateData("dbo.core_user_account", $ua, $id_ua);

			$region = $this->auth_model->ambil_region_get($user_account->user_account_id);

			unset($user_account->password);
			/* response sukses */
			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Anda Berhasil Login'
				),
				array(
					"userId" => $user_account->user_account_id,
					"userFullName" => $userFullName,
					"userMobilePhone" => $user_profile_no_hp,
					"userRole" => $group,
					"regionCode" => $region,
					"token" => $token

				)

			);
		} catch (Exception $e) {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Invalid Parameter'
				)
			);
		}
	}

	public function register_post()
	{
		$this->load->library('encryption');
		$json = file_get_contents("php://input");
		$data = json_decode($json);

		$WorkExperience = $data->userWorkExperience;
		$username = $data->userMobilePhone;
		$location = $data->userWorkingArea;
		$cekKorkab = $this->cekKorkab($location);
		if ($cekKorkab == 0) {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Korkab pada lokasi ini belum ada'
				)
			);
		}
		$ua['user_account_username'] = $data->userMobilePhone;
		$ua['user_account_password'] = $this->encryption->encrypt($this->get_random_char(6));
		$ua['user_account_email'] = $data->userEmail;
		$ua['user_account_is_active'] = 0;
		$ua['user_account_create_by'] = $cekKorkab;
		$ua['user_account_wilayah_kerja'] = $location;


		$cek = $this->cekUser($username);
		if ($cek > 0) {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Username sudah terdaftar'
				)
			);
		}
		$res = $this->auth_model->insertData("dbo.core_user_account", $ua);
		if (!empty($res)) {
			$up['user_profile_id'] = $res;
			$up['user_profile_first_name'] = $data->userFullName;
			$up['user_profile_born_date'] = $data->userDob;
			$up['user_profile_born_place'] = $data->userBornPlace;
			$up['user_profile_agama'] = $data->userReligion;
			$up['user_profile_status_nikah'] = $data->userMaritalStatus;
			$up['user_profile_nik'] = $data->userNik;
			$up['user_profile_gender'] = $data->userGender;
			$up['user_profile_address'] = $data->userAddress;
			$up['bps_full_code'] = $data->userBpsAddress;
			$up['user_profile_no_hp'] = $data->userMobilePhone;
			$up['user_profile_pendidikan_terakhir'] = $data->userLastEducation;
			$up['user_profile_jurusan'] = $data->userMajor;
			$up['user_profile_institusi_pendidikan'] = $data->userSchoolName;
			$up['user_profile_tahun_lulus'] = $data->userGraduationYear;
			$this->auth_model->insertData("dbo.core_user_profile", $up);

			$ug['user_group_user_account_id'] = $res;
			$ug['user_group_group_id'] = 3;
			$this->auth_model->insertData("dbo.user_group", $ug);

			if (!empty($WorkExperience)) {
				foreach ($WorkExperience as $key => $work_value) {
					$upk['user_id'] = $res;
					$upk['tahun_kerja'] = $work_value->workYear;
					$upk['jabatan'] = $work_value->workPosition;
					$upk['nama_kegiatan'] = $work_value->workNameActivities;
					$upk['perusahaan'] = $work_value->workCompany;
					$upk['created_by'] = $res;
					$upk['created_on'] = date("Y-m-d H:i:s");
					$this->auth_model->insertData("dbo.user_pengalaman_kerja", $upk);
				}
			}

			$ul['user_id'] = $res;
			$ul['user_logged_on'] = date("Y-m-d H:i:s");
			$ul['user_ip_address'] = $this->GetClientIP();
			$ul['user_stereotype'] = 'REGISTER';
			$ul['user_desciption'] = $data->userMobilePhone . " Register in.\n\n";

			$this->auth_model->insertData("user_log", $ul);

			$this->app_response(
				REST_Controller::HTTP_OK,
				array(
					'code' => '200',
					'message' => 'Anda Berhasil Register'
				),
				array(
					"userServerId" => $res
				)

			);
		} else {
			$this->app_response(
				REST_Controller::HTTP_BAD_REQUEST,
				array(
					'code' => '400',
					'message' => 'Invalid Parameter'
				)
			);
		}
	}
	function get_random_char($length = 6)
	{
		$str = "";
		$characters = array_diff(array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')), ["O", "0", "l", "I", "1"]);
		$clear_char = [];
		foreach ($characters as $key => $value) {
			$clear_char[] = $value;
		}
		$max = count($clear_char) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $clear_char[$rand];
		}
		return $str;
	}
	function cekUser($username)
	{
		$id['user_account_username'] = $username;
		$prelist = $this->auth_model->getSelectedData("dbo.core_user_account", $id);
		if ($prelist->num_rows() > 0)
			return 1;
		else
			return 0;
	}

	
	function cekKorkab($location_id)
	{
		$sqln = "
			SELECT l.* FROM dbo.user_location l join user_group g on l.user_location_user_account_id=g.user_group_user_account_id
			WHERE l.user_location_location_id = $location_id and g.user_group_group_id=1003	";
		$get_data = $this->db->query($sqln);
		if ($get_data->num_rows() > 0)
		{
			foreach ($get_data->result() as $db) {
				$korkab_id = $db->user_location_user_account_id;
			}
		}
		else
		{
			$korkab_id=0;
		}
		return $korkab_id;
	}

	public function logout_get()
	{
		$token = $this->cektoken();
		$user_id = $token->user_id;

		$ua['user_account_token'] = '';
		$id_ua['user_account_id'] = $user_id;
		$this->auth_model->updateData("dbo.core_user_account", $ua, $id_ua);

		$ud['user_profile_android_id'] = '';
		$id_d['user_profile_id'] = $user_id;
		$this->auth_model->updateData("core_user_profile", $ud, $id_d);

		$this->app_response(
			REST_Controller::HTTP_OK,
			array(
				'code' => '200',
				'message' => 'Logout successful'
			)
		);
	}

	public function refresh_token_get()
	{

		$token = $this->cektokenrefresh();
		$username = $token->username;
		$user_id = $token->user_id;
		$group = $token->group;

		/* create token jwt */
		$token_start = time();
		$token_expired = strtotime(TOKEN_TIMEOUT, $token_start);

		$payload = (object) array(
			'username' => $username,
			"user_id" => $user_id,
			'token_start' => $token_start,
			'token_expired' => $token_expired,
			"group" => $group,
		);

		$token = $this->jwt->encode($payload, config_item('jwt_key'));

		$ua['user_account_token'] = $token;
		$id_ua['user_account_id'] = $user_id;
		$this->auth_model->updateData("dbo.core_user_account", $ua, $id_ua);

		$this->app_response(
			REST_Controller::HTTP_OK,
			"Anda Berhasil Refresh Token",
			array(
				"username" => $username,
				"token" => $token

			)
		);
	}

	public function version_apps_get()
	{
		$query = $this->db->query("SELECT TOP 1 * FROM version_apps ORDER BY id_version DESC ");
		$result = $query->result_array();

		$this->app_response(
			REST_Controller::HTTP_OK,
			"Version",
			array(
				"Version" => $query->result_array()

			)
		);
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
