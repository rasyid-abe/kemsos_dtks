<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version_app extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->json = [];
		$this->id = $this->session->userdata('user_info');
		$this->dir = "version_app/";
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['base_url'] = $this->dir;
		$data['title'] = 'Version App';
		$this->template->title( $data['title'] );
		$this->template->content( "general/version", $data );
		$this->template->show( THEMES_BACKEND . 'index' );	
	}

	function get_show_data() {
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search= $this->input->post("search");
        $search = $search['value'];

		$col = 0;
		$where = $dir = $order_by = '';
		$input = $this->input->post();

		$input['s_app'] != '' ? $where .= "app_version LIKE '%" . $input['s_app'] . "%' AND " : '';

		if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {$dir = "desc";}

        $valid_columns = array(
			0=>'id_version',
			1=>'app_version',
            2=>'app_version_code',
            3=>'force_update_after',
            4=>'description',
            5=>'nama_file'
        );

        if(!isset($valid_columns[$col])) {$order = null;}
        else {$order = $valid_columns[$col];}

		if($order !=null) {$order_by = $order .' '. $dir;}

		$sql = "
			SELECT *
			FROM version_apps
			WHERE $where 1=1
			ORDER BY id_version OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
		";

        $gen_data = $this->db->query($sql);
        $data = array();
        foreach($gen_data->result() as $rows)
        {
			$edit = '<a href="#" class="btn btn-outline-info btn-sm md_edit" data-id_version="'.$rows->id_version.'" data-toggle="modal" data-target="#modal_ver" name="button" data-backdrop="static" data-keyboard="false" title="Edit"><i class="fa fa-pencil"></i></a>';
            $data[]= array(
				$edit,
                $rows->id_version,
                $rows->app_version,
				$rows->app_version_code,
                $rows->force_update_after,
                $rows->description,
                $rows->nama_file
            );
        }
		$sql_total = "SELECT COUNT(*) as num FROM version_apps WHERE $where 1=1";
        $total_data = $this->totalData($sql_total);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_data,
            "recordsFiltered" => $total_data,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	function totalData($sql_total) {
		$query = $this->db->query($sql_total);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}

	function _uploadApk() {
		$input = $this->input->post();

		$config['upload_path']   = './download/';
		$config['allowed_types'] = 'png';
		$config['overwrite']	 = true;
		$config['max_size']      = 102400; // 100MB

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('nama_file')) {
			return $this->upload->data("nama_file");
		}
	}

	function store_version() {
		$input = $this->input->post();

		$data_save = [
			'app_version' => $input['app_version'],
			'app_version_code' => $input['app_version_code'],
			'force_update_after' => $input['force_update_after'],
			'description' => $input['description'],
			'nama_file' => $this->_uploadApk(),
			'created_on' =>  date('Y-m-d H:i:s'),
			'created_by' => $this->id['user_id']
		];

		$pesan = '';
		
		if ($input['id_version'] != '') {
			$this->db->where('id_version', $input['id_version']);
			$act = $this->db->update('version_apps', $data_save);
			$pesan = 'diubah!';
		} else {
			$act = $this->db->insert('version_apps', $data_save);
			$pesan = 'ditambah!';
		}

		if ($act) {
			$result = [
				'status' => true,
				'pesan' => 'Version Apps berhasil di ' . $pesan,
			];
		} else {
			$result = [
				'status' => true,
				'pesan' => 'Version Apps gagal di ' . $pesan,
			];
		}

		echo json_encode($result);
	}

	function data_edit()
	{
		$id = $this->input->post('id_version', true);
		$data = $this->db->get_where('version_apps', ['id_version' => $id])->row_array();

		echo json_encode($data);
	}

	function act_delete()
	{
		$ids = $this->input->post('params', true)[0];

		$sukses = $gagal = 0;
		for ($i=0; $i < count($ids); $i++) {
			$this->db->where('id_version', $ids[$i]);
			$delete = $this->db->delete('version_apps');

			if ($delete) {
				$sukses++;
			} else {
				$gagal++;
			}
		}

		$result = [
			'status' => 'sukses',
			'pesan' => $sukses . ' berhasil dihapus. ' . $gagal .' gagal dihapus.',
		];

		echo json_encode($result);
	}
}