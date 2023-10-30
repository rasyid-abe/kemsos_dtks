<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kartu_keluarga extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->json = [];
		$this->id = $this->session->userdata('user_info');
		$this->dir = "kartu_keluarga/";
	}

	function tambah()
	{
		$i_file = false;
		$input = $this->input->post();

		$loc_id = $this->db->get_where('master_data_detail', ['proses_id' => $input['proses_id']])->row('bps_full_code');
		$loc = $this->db->get_where('ref_locations', ['bps_full_code' => $loc_id])->row_array();

		$sql_i = "
			SELECT DISTINCT(ul.user_location_user_account_id) enum FROM master_data_detail mdd
			LEFT JOIN ref_locations rl ON mdd.bps_full_code = rl.bps_full_code
			LEFT JOIN user_location ul ON rl.location_id = ul.user_location_location_id
			WHERE mdd.bps_full_code = '$loc_id'
		";

		$input_by = $this->db->query($sql_i)->row('enum');
		$en_d = $this->db->get_where('files', ['created_by' => $input_by])->row_array();


		$data_save = [
			'proses_id' => $input['proses_id'],
			'nokk' => $input['nokk'],
			'nuk' => $input['nuk'],
			'row_status' => 'NEW',
			'jenis_kk' => $input['jenis_kk'],
			'created_by' => $input_by,
			'created_on' => date('Y-m-d H:i:s'),
		];
		// $id = 12;
		$id = save_data('master_kartu_keluarga', $data_save);
		if ($id) {
			$ext = '.' . explode(".", $_FILES['file']['name'])[1];
			$file_name = 'F-KK' . '-' . $input_by . '-' . $input['nokk'] . '-' . time() . $ext;
			$path = './assets/photos/' . $loc['bps_province_code'] . '_' . $loc['province_name'] . '/' . $loc['bps_regency_code'] . '_' . $loc['regency_name'] . '/' . $loc['bps_district_code'] . '_' . $loc['district_name'] . '/' . $loc['bps_village_code'] . '_' . $loc['village_name'] . '/' . $id . '/' . $file_name;

			$config_uload = [
				'file' => $_FILES,
				'path' => $path,
				'name' => $file_name,
			];

			$arr_file = [
				'owner_id' => $id,
				'file_name' => $file_name,
				'file_size' => $_FILES['file']['size'],
				'internal_filename' => $path,
				'latitude' => $en_d['latitude'],
				'longitude' => $en_d['longitude'],
				'ip_user' => $en_d['ip_user'],
				'stereotype' => 'F-KK',
				'row_status' => 'ACTIVE',
				'created_by' => $input_by,
				'created_on' => date('Y-m-d H:i:s'),
			];


			$upload = $this->upload_files($config_uload);
			if ($upload) {
				$f_ins = save_data('files', $arr_file);
				if ($f_ins) {
					$i_file = true;
				}
			}
		}


		$this->session->set_flashdata('tab', 'kk');
		if ($i_file) {
			$this->session->set_flashdata('status', '1');
			return redirect('monitoring/detail_data/get_form_detail/' . enc(['proses_id' => $input['proses_id']]));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('monitoring/detail_data/get_form_detail/' . enc(['proses_id' => $input['proses_id']]));
		}
	}

	private function upload_files($e)
	{
		$this->load->library('ftp');

		$config['upload_path']          = $e['path'];
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name']            = $e['name'];
		$config['overwrite']			= true;
		$config['max_size']             = 1024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		// echo "<pre>";
		// print_r($config);
		// die;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if ($this->upload->do_upload('file')) {
			return true;
		} else {
			echo $this->upload->display_errors();
			die;
		}

		return false;
	}
}
