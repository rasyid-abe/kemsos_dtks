<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_data extends Backend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->json = [];
		$this->dir = base_url('monitoring/detail_data/');
		$this->id = $this->session->userdata('user_info');
	}

	function index()
	{
		redirect(base_url());
	}

	function get_form_detail($par = null)
	{
		$this->load->library('encryption');
		$params = (($par != null) ? dec($par) : $par);
		$proses_id = $params['proses_id'];

		//tab1-profil-ruta
		$sql1 = "
			SELECT * FROM master_data md
			LEFT JOIN ref_locations loc ON md.bps_full_code = loc.bps_full_code
			WHERE md.proses_id = $proses_id
		";
		$get_data1 = $this->db->query($sql1)->row();

		//tab2-info-petugas-monitoring
		$sql2 = "
			SELECT * FROM master_data md
			LEFT JOIN ref_assignment task ON md.proses_id = task.proses_id
			LEFT JOIN core_user_profile usr ON task.user_id = usr.user_profile_id
			LEFT JOIN core_user_account acc ON task.user_id = acc.user_account_id
			WHERE md.proses_id = $proses_id
		";
		$get_data2 = $this->db->query($sql2)->row();

		//tab3-profil-keluarga
		$sql3 = "
			SELECT kk.proses_id, kk.nokk, kk.nuk, kk.jenis_kk, fl.internal_filename, fl.stereotype, fl.created_on
			FROM master_kartu_keluarga kk
			LEFT JOIN files fl ON kk.id = fl.owner_id
			WHERE kk.proses_id = $proses_id AND fl.stereotype = 'F-KK' AND kk.row_status != 'DELETED'
			ORDER BY fl.created_on DESC
		";
		$get_data3 = $this->db->query($sql3)->result_array();

		//tab4-profil-anggota-ruta
		$sql4 = "
			SELECT * FROM vw_tab4_data_art 
			WHERE proses_id = $proses_id
		";
		$get_data4 = $this->db->query($sql4)->result_array();

		//detail-foto-kk
		$sql6 = "
			SELECT kk.id, kk.proses_id, kk.nokk, kk.nuk, kk.jenis_kk, fl.internal_filename, fl.stereotype, fl.created_on, fl.file_size, fl.description, fl.latitude, fl.longitude, fl.ip_user, fl.created_by, fl.created_on, fl.row_status 
			FROM master_kartu_keluarga kk
			LEFT JOIN files fl ON kk.id = fl.owner_id
			WHERE kk.proses_id = $proses_id AND fl.stereotype = 'F-KK'
			ORDER BY fl.created_on DESC
		";
		$get_data6 = $this->db->query($sql6)->result_array();

		$data = array();
		$data['prelist_data'] = $get_data1;
		$data['monitoring'] = $get_data2;
		$data['keluarga'] = $get_data3;
		$data['art'] = $get_data4;
		$data['fotokk'] = $get_data6;
		$data['title'] = 'Detail Data Prelist';
		$data['proses_id'] = $proses_id;
		$this->template->title($data['title']);
		$this->template->content("verivali/detail_prelist", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function get_form_detail_art($par = null)
	{
		$this->load->library('encryption');
		$params = (($par != null) ? dec($par) : $par);
		$detail_id = $params['id'];

		//log-data-art
		$sql1 = "
			SELECT TOP 150 * FROM master_detail_log
			WHERE detail_id = $detail_id
			ORDER BY log_id DESC
		";
		$get_data1 = $this->db->query($sql1)->result();

		//nama-art
		$sql2 = "
			SELECT nama_art FROM master_data_detail
			WHERE id = $detail_id
		";
		$get_data2 = $this->db->query($sql2)->row();

		$data = array();
		$data['log'] = $get_data1;
		$data['namas'] = $get_data2;
		$data['title'] = 'Log Detail ART';
		$this->template->title($data['title']);
		$this->template->content("general/log_art", $data);
		$this->template->show(THEMES_BACKEND . 'index');
	}

	function edit_art()
	{
		$id = $this->input->post('id');
		$proses_id = $this->input->post('proses_id');
		$stereotype = $this->input->post('stereotype');
		$nama_art = $this->input->post('nama_art');
		$nik = $this->input->post('nik');
		$keberadaan_art = $this->input->post('keberadaan_art');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$tempat_lahir = $this->input->post('tempat_lahir');
		$tanggal_lahir = $this->input->post('tanggal_lahir');
		$hubungan_kepkel = $this->input->post('hubungan_kepkel');
		$statuss = "";

		if ($stereotype != '') {
			$statuss = "M4";
		}

		$user_ip = client_ip();

		$upd_data = [
			'nama_art' => $nama_art,
			'nik' => $nik,
			'tempat_lahir' => $tempat_lahir,
			'tanggal_lahir' => $tanggal_lahir,
			'stereotype' => $statuss,
			'lastupdate_by' => $this->id['user_id'],
			'lastupdate_on' => date('Y-m-d H:i:s')
		];

		$this->db->where('id', $id);
		$update = $this->db->update('master_data_detail', $upd_data);

		$data_log = [];
		if ($update) {
			$sukses++;
			$data_log['status'] = 'sukses';
		} else {
			$gagal++;
			$data_log['status'] = 'gagal';
		}

		$data_log['detail_id'] = $id;
		$data_log['description'] = 'Edit data ART';
		$data_log['stereotype'] = $statuss;
		$data_log['created_by'] = $this->id['user_id'];
		$data_log['created_on'] =  date('Y-m-d H:i:s');

		$in_log = $this->db->insert('master_detail_log', $data_log);

		$this->session->set_flashdata('tab', 'update_art');
		if ($in_log && $update) {
			$this->session->set_flashdata('status', '1');
			return redirect('monitoring/detail_data/get_form_detail/' . enc(['proses_id' => $proses_id]));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('monitoring/detail_data/get_form_detail/' . enc(['proses_id' => $proses_id]));
		}
	}
}
