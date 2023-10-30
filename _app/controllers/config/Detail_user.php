<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_user extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( 'encryption' );
		$this->id = $this->session->userdata('user_info');
		$this->json = [];
	}

	function index() {
		$this->show();
	}

	function act_edit_userdata() {
		$input = $this->input->post();

		$this->db->where('user_profile_id', $input['idus']);
		$profile = $this->db->update('core_user_profile', ['user_profile_first_name' => $input['name']]);

		$arr_acc = [
			'user_account_password' => $this->encryption->encrypt($input['pass']),
			'user_account_email' => $input['mail'],
		];

		$this->db->where('user_account_id', $input['idus']);
		$account = $this->db->update('core_user_account', $arr_acc);

		$result = [
			'status' => true,
			'pesan' => 'User data berhail diperbarui!.',
		];

		echo json_encode($result);
	}

	function show_user_group() {
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search= $this->input->post("search");
        $search = $search['value'];

		$col = 0;
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		$input['s_user_id'] != '' ? $where .= "a.user_group_user_account_id = '" . $input['s_user_id'] . "' AND " : '';

		if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {$dir = "desc";}

        $valid_columns = array(
			0=>'a.user_group_group_id',
            1=>'b.user_group_title',
        );

        if(!isset($valid_columns[$col])) {$order = null;}
        else {$order = $valid_columns[$col];}

		if($order !=null) {$order_by = $order .' '. $dir;}

		$sql = "
			SELECT * FROM user_group a
			LEFT JOIN core_user_group b ON a.user_group_group_id = b.user_group_id
			WHERE $where 1=1
			ORDER BY a.user_group_id DESC OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
		";

        $gen_data = $this->db->query($sql);
        $data = array();
        foreach($gen_data->result() as $rows)
        {

            $data[]= array(
				$rows->user_group_group_id,
				$rows->user_group_title,
            );
        }
		$sql_total = "SELECT COUNT(*) as num FROM user_group a LEFT JOIN core_user_group b ON a.user_group_group_id = b.user_group_id WHERE $where 1=1";
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

	function show_user_location() {
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search= $this->input->post("search");
        $search = $search['value'];

		$col = 0;
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		$input['s_user_id'] != '' ? $where .= "user_location_user_account_id = '" . $input['s_user_id'] . "' AND " : '';

		if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {$dir = "desc";}

        $valid_columns = array(
			0=>'user_location_location_id',
            1=>'full_name',
        );

        if(!isset($valid_columns[$col])) {$order = null;}
        else {$order = $valid_columns[$col];}

		if($order !=null) {$order_by = $order .' '. $dir;}

		$sql = "
			SELECT * FROM user_location
			LEFT JOIN ref_locations ON user_location_location_id = location_id
			WHERE $where 1=1
			ORDER BY user_location_id DESC OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
		";

        $gen_data = $this->db->query($sql);
        $data = array();
        foreach($gen_data->result() as $rows)
        {
			$delete = '<button type="button" class="btn btn-danger btn-sm ck_location" value="'.$rows->user_location_location_id.'" title="Hapus"><i class="ft ft-delete"></i></button>';

            $data[]= array(
				$rows->user_location_location_id,
				$rows->full_name,
				$delete,
            );
        }
		$sql_total = "SELECT COUNT(*) as num FROM user_location LEFT JOIN ref_locations ON user_location_location_id = location_id WHERE $where 1=1";
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

	function act_group_user() {
		$user_id = $this->input->post('user_id', true);
		$group_id = $this->input->post('group_id', true);

		$group_user = $this->db->get_where('user_group', ['user_group_user_account_id' => $user_id]);

		$arr_wh = [
			'user_group_user_account_id' => (int)$user_id,
			'user_group_group_id' => (int)$group_id,
		];

		$row = $this->db->get_where('user_group', $arr_wh);

		if ($group_user->num_rows() == 0) {
			$this->db->where($arr_wh);
			$db_act = $this->db->insert('user_group', $arr_wh);
		} else {
			$db_act = '';
		}

		if ($row->num_rows() > 0) {
			$this->db->where($arr_wh);
			$db_act = $this->db->delete('user_group');
		} 

		if ($db_act) {
			$result = [
				'status' => true,
				'pesan' => 'User group berhasil diperbarui.',
			];
		} else {
			$result = [
				'status' => false,
				'pesan' => 'User hanya boleh satu role.',
			];
		}

		echo json_encode($result);
	}

	function act_location_user() {
		$user_id = $this->input->post('user_id', true);
		$location_id = $this->input->post('location_id', true);

		$arr_wh = [
			'user_location_user_account_id' => (int)$user_id,
			'user_location_location_id' => (int)$location_id,
		];

		$row = $this->db->get_where('user_location', $arr_wh);
		$locs = $this->db->get_where('ref_locations', ['location_id' => $location_id])->row();
		$group_user = $this->db->get_where('user_group', ['user_group_user_account_id' => $user_id]);

		if ($group_user->num_rows() > 0) {
			$get_group = $group_user->row();
			if (in_array('root', $this->id['user_group']) == true || in_array('admin-junior', $this->id['user_group']) == true || in_array('pimpinan', $this->id['user_group']) == true || in_array('kemsos', $this->id['user_group']) == true) {
				if ($get_group->user_group_group_id == 1 || $get_group->user_group_group_id == 2 || $get_group->user_group_group_id == 1012 || $get_group->user_group_group_id == 1013 || $get_group->user_group_group_id == 1014 || $get_group->user_group_group_id == 1015) {
					if ($locs->stereotype != 'PROVINCE') {
						$result = [
							'status' => false,
							'pesan' => 'Lokasi user hanya boleh provinsi.',
						];
					} else {
						if ($row->num_rows() > 0) {
							$this->db->where($arr_wh);
							$db_act = $this->db->delete('user_location');
						} else {
							$db_act = $this->db->insert('user_location', $arr_wh);
						}
		
						if ($db_act) {
							$result = [
								'status' => true,
								'pesan' => 'User location berhasil diperbarui.',
							];
						} else {
							$result = [
								'status' => false,
								'pesan' => 'User location gagal diperbarui.',
							];
						}
					}
				}

				if ($get_group->user_group_group_id == 3) {
					if ($locs->stereotype != 'VILLAGE') {
						$result = [
							'status' => false,
							'pesan' => 'Lokasi user harus sampai kelurahan.',
						];
					} else {
						if ($row->num_rows() > 0) {
							$this->db->where($arr_wh);
							$db_act = $this->db->delete('user_location');
						} else {
							$db_act = $this->db->insert('user_location', $arr_wh);
						}
		
						if ($db_act) {
							$result = [
								'status' => true,
								'pesan' => 'User location berhasil diperbarui.',
							];
						} else {
							$result = [
								'status' => false,
								'pesan' => 'User location gagal diperbarui.',
							];
						}
					}
				}

				if ($get_group->user_group_group_id == 1003 || $get_group->user_group_group_id == 1011) {
					if ($locs->stereotype != 'REGENCY') {
						$result = [
							'status' => false,
							'pesan' => 'Lokasi user hanya boleh kabupaten.',
						];
					} else {
						if ($row->num_rows() > 0) {
							$this->db->where($arr_wh);
							$db_act = $this->db->delete('user_location');
						} else {
							$db_act = $this->db->insert('user_location', $arr_wh);
						}
		
						if ($db_act) {
							$result = [
								'status' => true,
								'pesan' => 'User location berhasil diperbarui.',
							];
						} else {
							$result = [
								'status' => false,
								'pesan' => 'User location gagal diperbarui.',
							];
						}
					}
				}
			}

			elseif (in_array('korkab', $this->id['user_group']) == true) {
				if ($locs->stereotype != 'VILLAGE') {
					$result = [
						'status' => false,
						'pesan' => 'Lokasi enum harus sampai kelurahan.',
					];
				} else {
					if ($row->num_rows() > 0) {
						$this->db->where($arr_wh);
						$db_act = $this->db->delete('user_location');
					} else {
						$db_act = $this->db->insert('user_location', $arr_wh);
					}
	
					if ($db_act) {
						$result = [
							'status' => true,
							'pesan' => 'User location berhasil diperbarui.',
						];
					} else {
						$result = [
							'status' => false,
							'pesan' => 'User location gagal diperbarui.',
						];
					}
				}
			}
	
			elseif (in_array('korwil', $this->id['user_group']) == true) {
				if ($locs->stereotype != 'REGENCY') {
					$result = [
						'status' => false,
						'pesan' => 'Lokasi user hanya boleh kabupaten.',
					];
				} else {
					if ($row->num_rows() > 0) {
						$this->db->where($arr_wh);
						$db_act = $this->db->delete('user_location');
					} else {
						$db_act = $this->db->insert('user_location', $arr_wh);
					}
	
					if ($db_act) {
						$result = [
							'status' => true,
							'pesan' => 'User location berhasil diperbarui.',
						];
					} else {
						$result = [
							'status' => false,
							'pesan' => 'User location gagal diperbarui.',
						];
					}
				}
			}
	
			else  {
				if ($row->num_rows() > 0) {
					$this->db->where($arr_wh);
					$db_act = $this->db->delete('user_location');
				} else {
					$db_act = $this->db->insert('user_location', $arr_wh);
				}
	
				if ($db_act) {
					$result = [
						'status' => true,
						'pesan' => 'User location berhasil diperbarui.',
					];
				} else {
					$result = [
						'status' => false,
						'pesan' => 'User location gagal diperbarui.',
					];
				}
			}
		} else {
			$result = [
				'status' => false,
				'pesan' => 'User belum memiliki Group / Role.',
			];
		}

		echo json_encode($result);
	}

	function get_data_treeview() {
		$user_id = $this->input->post('user_id', true);

		if (in_array('root', $this->id['user_group']) || in_array('admin-junior', $this->id['user_group']) || in_array('admin', $this->id['user_group'])) {
			$sql = "SELECT * FROM ref_locations WHERE level IN ('2')";
		} else {
			if (in_array('korwil', $this->id['user_group']) || in_array('p-i-c', $this->id['user_group'])) {
				$and = " AND level = '2'";
			} else if (in_array('korkab', $this->id['user_group'])) {
				$and = " AND level = '3'";
			}
			$data_in = "'" . implode("','", $this->id['user_location']) . "'";
			$sql = "SELECT * FROM ref_locations WHERE location_id IN ($data_in) $and";
		}

		$query_propinsi = $this->db->query($sql)->result_array();

		$ex_loc = $this->db->get_where('user_location', ['user_location_user_account_id' => $user_id])->result_array();
		$arr_loc = [];
		foreach ($ex_loc as $i => $v) {
			$arr_loc[] = (int)$v['user_location_location_id'];
		}

		$result = [
			'status' => true,
			'lokasi' => $query_propinsi,
			'exists' => $arr_loc,
		];

		echo json_encode($result);
	}

	function get_data_treeview_child() {
		$parent = $this->input->post('parent', true);
		$user_id = $this->input->post('user_id', true);

		$data = $this->db->get_where('ref_locations', ['parent_id' => $parent])->result_array();

		$ex_loc = $this->db->get_where('user_location', ['user_location_user_account_id' => $user_id])->result_array();
		$arr_loc = [];
		foreach ($ex_loc as $i => $v) {
			$arr_loc[] = $v['user_location_location_id'];
		}

		$result = [
			'status' => true,
			'lokasi' => $data,
			'exists' => $arr_loc,
		];

		echo json_encode($result);
	}

	function hapus_pengalaman_kerja() {
		$id_kerja = $this->uri->segment(4);
		$user_id = $this->uri->segment(5);

		$this->db->where('id', $id_kerja);
		$del = $this->db->delete('user_pengalaman_kerja');

		$this->session->set_flashdata('tab', 'kerja_hapus');
		if ($del) {
			$this->session->set_flashdata('status', '1');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ) );
		}
	}

}
