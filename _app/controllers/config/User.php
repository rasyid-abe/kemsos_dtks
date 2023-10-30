<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Backend_Controller {

	public function __construct() {
		parent::__construct();
		$this->json = [];
		$this->load->library('excel');
		$this->id = $this->session->userdata('user_info');
		$this->dir = "user/";
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();
		$data['base_url'] = $this->dir;
		$data['title'] = 'User Management';
		$this->template->title( $data['title'] );
		$this->template->content( "config/view_user", $data );
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
		$where = $region = $dir = $order_by = '';
		$input = $this->input->post();

		if (in_array('root', $this->id['user_group']) == false) {
			$where .= "user_account_create_by = '".$this->id['user_id']."' AND ";
		}

		$input['s_user_id'] != '' ? $where .= "user_account_id = '" . $input['s_user_id'] . "' AND " : '';
		$input['s_username'] != '' ? $where .= "user_account_username LIKE '%" . $input['s_username'] . "%' AND " : '';
		$input['s_nama'] != '' ? $where .= "user_profile_first_name LIKE '%" . $input['s_nama'] . "%' AND " : '';

		if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {$dir = "desc";}

        $valid_columns = array(
			0=>'user_account_id',
            1=>'user_account_username',
            2=>'user_group_title',
            3=>'user_account_email',
            4=>'user_profile_first_name',
            5=>'user_account_create_by',
            6=>'user_account_is_active'
        );

        if(!isset($valid_columns[$col])) {$order = null;}
        else {$order = $valid_columns[$col];}

		if($order !=null) {$order_by = $order .' '. $dir;}

		$sql = "
			SELECT user_account_create_by, user_account_id, user_account_username, user_group_title, user_account_email, user_profile_first_name, user_account_is_active FROM vw_semua_user
			WHERE $where 1=1
			GROUP BY user_account_create_by, user_account_id, user_account_username, user_group_title, user_account_email, user_profile_first_name, user_account_is_active
			ORDER BY user_account_id DESC OFFSET $start ROWS
			FETCH NEXT $length ROWS ONLY
		";

        $gen_data = $this->db->query($sql);
        $data = array();
        foreach($gen_data->result() as $rows)
        {
			$status = "";
			if($rows->user_account_is_active == 1) {
				$status = '<span class="badge badge-success mb-1" data-toggle="tooltip" data-placement="top" title="Aktif"><i class="ft-user"></i></span>';
			} else {
				$status = '<span class="badge badge-danger mb-1" data-toggle="tooltip" data-placement="top" title="Tidak Aktif"><i class="ft-user"></i></span>';
			}

			$detail = '<a href="' . base_url( 'config/user' ) . '/get_form_detail/' . enc( [ 'user_id' => $rows->user_account_id ] ) . '" target="_blank" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>';

            $data[]= array(
				$status,
                $rows->user_account_id,
				$rows->user_account_username,
				$rows->user_profile_first_name,
                $rows->user_group_title,
                $rows->user_account_email,
                $rows->user_account_create_by,
                $detail,
            );
        }

		$sql_total = "
			SELECT COUNT(*) as num FROM core_user_account ua 
			INNER JOIN core_user_profile up ON ua.user_account_id = up.user_profile_id 
			WHERE $where 1=1
		";
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

	function act_active() {
		$ids = $this->input->post('params', true)[0];
		$sts = $this->input->post('params', true)[1];
		$txt = $sts > 0 ? 'diaktifkan' : 'dinonaktifkan';

		$sukses = $gagal = 0;
		for ($i=0; $i < count($ids); $i++) {
			$this->db->where('user_account_id', $ids[$i]);
			$update = $this->db->update('core_user_account', ['user_account_is_active' => $sts, 'user_account_token' => '']);
			if ($update) {
				$sukses++;
			} else {
				$gagal++;
			}
		}

		$result = [
			'status' => 'sukses',
			'pesan' => $sukses . ' user berhasil '.$txt.'. ' . $gagal .' user gagal '.$txt.'.',
		];

		echo json_encode($result);
	}

	function get_form_detail( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$user_id = $params['user_id'];

		//user-data
		$sql1 = "
			SELECT * FROM vw_semua_user
			WHERE user_account_id = $user_id
		";
		$sql_user1 = $this->db->query($sql1)->row();

		//device-user
		$sql2 = "
			SELECT * FROM dbo.user_log
			WHERE user_id = $user_id AND user_stereotype = 'FIRST-TIME-LOGIN'
		";
		$sql_user2 = $this->db->query($sql2)->row();

		//user-profile
		$sql3 = "
			SELECT * FROM vw_user_profile
			WHERE user_account_id = $user_id
		";
		$sql_user3 = $this->db->query($sql3)->row();

		//user-logs
		$sql4 = "
			SELECT TOP 100 * FROM master_data_log
			WHERE created_by = $user_id
			ORDER BY lastupdate_on DESC
		";
		$sql_user4 = $this->db->query($sql4)->result_array();

		//user-pengalaman-kerja
		$sql5 = "
			SELECT * FROM user_pengalaman_kerja up
			LEFT JOIN core_user_profile pr ON up.user_id = pr.user_profile_id 
			WHERE up.user_id = $user_id
			ORDER BY lastupdate_on DESC
		";
		$sql_user5 = $this->db->query($sql5)->result_array();

		//user-profile-foto-pf
		$sql6 = "
			SELECT internal_filename FROM files
			WHERE owner_id = $user_id 
			AND stereotype = 'F-PF'
			ORDER BY created_on DESC
		";
		$sql_user6 = $this->db->query($sql6)->row();

		//user-profile-foto-ktp
		$sql7 = "
			SELECT internal_filename FROM files
			WHERE owner_id = $user_id 
			AND stereotype = 'F-KTP'
			ORDER BY created_on DESC
		";
		$sql_user7 = $this->db->query($sql7)->row();

		//user-profile-foto-ijazah
		$sql8 = "
			SELECT internal_filename FROM files
			WHERE owner_id = $user_id 
			AND stereotype = 'F-IZ'
			ORDER BY created_on DESC
		";
		$sql_user8 = $this->db->query($sql8)->row();

		$data = array();
		$data['base_url'] = $this->dir;
		$data['user_detail'] = $sql_user1;
		$data['user_device'] = $sql_user2;
		$data['user_profile'] = $sql_user3;
		$data['user_log'] = $sql_user4;
		$data['user_kerja'] = $sql_user5;
		$data['pf'] = $sql_user6;
		$data['ktp'] = $sql_user7;
		$data['ijazah'] = $sql_user8;
		$data['user_group'] = $this->get_data_user_group($user_id);
		$data['title'] = 'Detail User Management';
		$this->template->title( $data['title'] );
		$this->template->content( "config/view_detail_user", $data );
		$this->template->show( THEMES_BACKEND . 'index' );
	}

	public function edit_profile() {
		$input  = $this->input->post();
		$data_save = array();

		$data_save['user_profile_first_name'] = $input['user_profile_first_name'];
		$data_save['user_profile_nik'] = $input['user_profile_nik'];
		$data_save['user_profile_born_place'] = $input['user_profile_born_place'];
		$data_save['user_profile_born_date'] = $input['user_profile_born_date'];
		$data_save['user_profile_agama'] = $input['user_profile_agama'];
		$data_save['user_profile_gender'] = $input['user_profile_gender'];
		$data_save['user_profile_status_nikah'] = $input['user_profile_status_nikah'];
		$data_save['user_profile_address'] = $input['user_profile_address'];
		$data_save['user_profile_no_hp'] = $input['user_profile_no_hp'];
		$data_save['user_profile_email_alternatif'] = $input['user_profile_email_alternatif'];
		$data_save['user_profile_pendidikan_terakhir'] = $input['user_profile_pendidikan_terakhir'];
		$data_save['user_profile_jurusan'] = $input['user_profile_jurusan'];
		$data_save['user_profile_institusi_pendidikan'] = $input['user_profile_institusi_pendidikan'];
		$data_save['user_profile_tahun_lulus'] = $input['user_profile_tahun_lulus'];

		$save = save_data( 'core_user_profile', $data_save, [ 'user_profile_id' => $input['user_profile_id'] ] );
		$this->session->set_flashdata('tab', 'profile');
		if ($save) {
			$this->session->set_flashdata('status', '1');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $input['user_profile_id'] ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $input['user_profile_id'] ] ) );
		}
	}

	function get_user_location() {
		$user_location = $this->user_info['user_location'];
		$res_loc = '';
		$country_id = '0';
		$province_id = '0';
		$regency_id = '0';
		$district_id = '0';
		$village_id = '0';
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
				$province_id = $query->row( 'province_id' ) . ( ( $no < $count ) ? ',' : '' );
				$regency_id = $query->row( 'regency_id' ) . ( ( $no < $count ) ? ',' : '' );
				$district_id = $query->row( 'district_id' ) . ( ( $no < $count ) ? ',' : '' );
				$village_id = $query->row( 'village_id' ) . ( ( $no < $count ) ? ',' : '' );
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

	function act_detail_save_account() {
		$this->load->library( 'encryption' );
		$in = $this->input->post();
		$params_edit_account = [
			'user_account_email' => $in['user_email'],
			'user_account_password' => $this->encryption->encrypt( $in['user_password'] ),
			'user_account_is_active' => $in['user_is_active']
		];
		if ( save_data( 'core_user_account', $params_edit_account, ['user_account_id' => $in['user_id']] ) ){
			echo json_encode(
				[
					'status' => 200,
					'message' => ' Data Berhasil Diubah',
				]
			);
		} else {
			echo json_encode(
				[
					'status' => 400,
					'message' => ' Data Gagal Diubah',
				]
			);
		}
	}

	function get_data_user_group($user_id) {
		$params_user_group = [
			'table' => 'dbo.core_user_group',
			'select' => 'user_group_id, user_group_name, user_group_title',
			'where' => [
				'user_group_is_active' => '1',
			],
			'order_by' => 'user_group_id'
		];

		if (in_array('root', $this->id['user_group']) || in_array('admin', $this->id['user_group'])) {
			$params_user_group['where'] = [];
		} else if (in_array('korwil', $this->id['user_group'])) {
			$params_user_group['where'] = ['user_group_parent_id' => 2];
		} else if (in_array('korkab', $this->id['user_group'])) {
			$params_user_group['where'] = ['user_group_parent_id' => 1003];
		}

		$query_user_group = get_data( $params_user_group );

		$arr_val = $this->db->get_where('user_group', ['user_group_user_account_id' => $user_id])->result_array();
		$val_chk = [];
		if ($arr_val != null) {
			foreach ($arr_val as $in => $val) {
				$val_chk[] = $val['user_group_group_id'];
			}
		}
		$html_group = '';
		if ( $query_user_group->num_rows() > 0 ) {
			foreach ( $query_user_group->result() as $key => $group ) {
				$chk = in_array($group->user_group_id, $val_chk) ? 'checked' : '';
				$html_group .="
					<div class='col-sm-12 custom-control custom-checkbox'>
						<label class='form-check-label' for='{$group->user_group_name}'>
							<input type='checkbox' onclick='act_group_user({$group->user_group_id})' class='ck form-check-input' id='{$group->user_group_name}' name='user_group_id[]' {$chk} value='{$group->user_group_id}'>&nbsp;&nbsp;{$group->user_group_title}
						</label>
					</div>
				";
			}
		}
		return $html_group;
	}

	function act_show_group() {
		$arr_output = array();
		$arr_output['message'] = '';
		$arr_output['message_class'] = '';
		$in = $this->input->post();
		if ( ( isset( $in['type'] ) && $in['type'] == 'delete' ) || ( isset( $in['delete'] ) && $in['delete'] ) ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_deleted = $item_undeleted = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'user_group',
					];
					if ( isset( $in['type'] ) ) {
						$where = [
							'user_group_group_id' => $id,
							'user_group_user_account_id' => $in['id_user'],
						];
					} else {
						$where = [
							'user_group_id' => $id
						];
					}
					$params_check['where'] = $where;
					$check = get_data( $params_check );
					if ( $check ) {
						$user_group_id = ( ( isset( $in['type'] ) ) ? $check->row('user_group_id') : $id );
						delete_data('user_group', 'user_group_id', $user_group_id);
						$item_deleted++;
					} else {
						$item_undeleted++;
					}
				}
				$arr_output['status'] = 200;
				$arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
			} else {
				$arr_output['status'] = 400;
				$arr_output['message'] = 'Anda belum memilih data.';
			}
		}

		if ( isset( $in['type'] ) && $in['type'] == 'add' ) {
			$arr_id = json_decode( $in['item'] );
			if ( is_array( $arr_id ) ) {
				$item_success = $item_unsuccess = 0;
				foreach ( $arr_id as $id ) {
					$params_check = [
						'table' => 'user_group',
						'where' => [
							'user_group_group_id' => $id,
							'user_group_user_account_id' => $in['id_user']
						]
					];
					$check = get_data( $params_check );
					if ( $check->num_rows() == '0' ) {
						$params_save_user_group = [
							'user_group_user_account_id' => $in['id_user'],
							'user_group_group_id' => $id,
						];
						save_data( 'user_group', $params_save_user_group );
						$item_success++;
						$arr_output['status'] = 200;
						$arr_output['message'] = 'Data berhasil disimpan.';
					} else {
						$item_unsuccess++;
						$arr_output['status'] = 400;
						$arr_output['message'] = 'Data Sudah Ada.';
					}
				}
			} else {
				$arr_output['status'] = 400;
				$arr_output['message'] = 'Anda belum memilih data.';
			}
		}

		echo json_encode( $arr_output );
	}

	function simpan_user_baru() {
		$this->load->library( 'encryption' );
		$input = $this->input->post();

		$no_hp = '';
		$result = [
			'status' => 500,
			'msg' => [],
		];
		$status = false;

		if ( ! empty( $input['user_no_hp'] ) ) {
			if ( preg_match( '/^[1-9][0-9]*$/' , $input['user_no_hp'] ) ) {
				if ( strlen( $input['user_no_hp'] ) >= 9 && strlen( $input['user_no_hp'] ) <= 12 ) {
					$status = true;
					$no_hp = "+62" . $input['user_no_hp'];

					if ( ! empty( $input['user_username'] ) ) {
						$getUser = $this->db->get_where('dbo.core_user_account', ['user_account_username' => $input['user_username']])->num_rows();
						if ( $getUser > 0 ) {
							$status = false;
							$result['msg'][] =  '<li>Isian <b>Username</b> harus unik!</li>';
						} else {
							if ( ! empty( $input['user_nik'] ) ) {
								if ( preg_match( '/^[1-9][0-9]*$/' , $input['user_nik'] ) ) {
									if ( strlen( $input['user_nik'] ) < 16 ) {
										$status = false;
										$result['msg'][] =  '<li>Panjang Isian <b>NIK</b> minimal 16 karakter!</li>';
									} else {
										$status = true;
									}
								} else {
									$status = false;
									$result['msg'][] =  '<li>Isian <b>NIK</b> harus diisi dengan karakter numerik!</li>';
								}
							} else {
								$status = false;
								$result['msg'][] =  '<li>Isian <b>NIK</b> harus diisi!</li>';
							}
						}
					}

				} else {
					$status = false;
					$result['msg'][] =  '<li>Panjang Isian <b>No. HP</b> 10 - 13 karakter!</li>';
				}
			} else {
				$status = false;
				$result['msg'][] =  '<li>Isian <b>No. HP</b> harus karakter numerik!</li>';
			}
		} else {
			$status = false;
			$result['msg'][] =  '<li>Isian <b>No. HP</b> harus diisi</li>';
		}

		if ( $status ) {
			$data_save_user_account = [
				'user_account_username' => $input['user_username'],
				'user_account_password' => $this->encryption->encrypt( $this->get_random_char( 6 ) ),
				'user_account_email' => $input['user_email'],
				'user_account_is_active' => '1',
				'user_account_create_by' => $this->user_info['user_id'],
			];
			$id = save_data( 'core_user_account', $data_save_user_account );

			$data_save_user_profile = [
				'user_profile_id' => $id,
				'user_profile_first_name' => $input['user_full_name'],
				'user_profile_nik' => $input['user_nik'],
				'user_profile_no_hp' => $no_hp,
				'user_profile_address' => '-'
			];
			save_data( 'core_user_profile', $data_save_user_profile );
			if ( ! empty( $id ) ){
				$result['status'] = 200;
				$result['msg'][] = 'Data Berhasil Disimpan!';
			} else {
				$result['msg'][] = 'Data Gagal Disimpan!';
			}
		}
		echo json_encode( $result );
		return redirect('config/user');
	}

	function simpan_pengalaman_kerja() {
		$input = $this->input->post();
		$user_id = $input['user_id'];

		$data_save_user_kerja = [
			'user_id' => $user_id,
			'tahun_kerja' => $input['tahun_kerja'],
			'jabatan' => $input['jabatan'],
			'nama_kegiatan' => $input['nama_kegiatan'],
			'perusahaan' => $input['perusahaan'],
			'created_by' => $this->user_info['user_id'],
			'created_on' => date('Y-m-d H:i:s'),
		];
		$id = save_data( 'user_pengalaman_kerja', $data_save_user_kerja );

		$this->session->set_flashdata('tab', 'kerja');
		if ($id) {
			$this->session->set_flashdata('status', '1');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ) );
		}

	}

	function get_random_char( $length = 6 ) {
		$str = "";
		$characters = array_diff( array_merge( range('A','Z'), range('a','z'), range('0','9') ), ["O", "0", "l", "I", "1"]);
		$clear_char = [];
		foreach ( $characters as $key => $value ) {
			$clear_char[] = $value;
		}
		$max = count( $clear_char ) - 1;
		for ( $i = 0; $i < $length; $i++ ) {
			$rand = mt_rand( 0, $max );
			$str .= $clear_char[$rand];
		}
		return $str;
	}

	public function send_whatsapp( $par = null ) {
		$this->load->library( 'encryption' );
		$params = ( ( $par != null ) ? dec( $par ) : $par );
		$user_id = $params['user_id'];
		$url = base_url('download/mkdtks.apk');
		$token_wa = $this->db->get_where('_token_wa', ['id' => 1])->row();

		$waapp = "
			SELECT * FROM vw_semua_user
			WHERE user_account_id = $user_id
		";
		$sql_wa = $this->db->query($waapp)->row();

		$phone = substr_replace($sql_wa->user_account_username,"62",0,1);

		//whatsapp-config
		$postRequest = array(
			'phone' => $phone,
			'message' =>
			'*Informasi Account MK-DTKS*
			 =============================
			 *Nama:* '. $sql_wa->user_profile_first_name.'
			 Username: ' . $sql_wa->user_account_username.'
			 Password: ' . $this->encryption->decrypt( $sql_wa->user_account_password).'
			 =============================
			 *APP MK-DTKS* bisa diunduh di '.$url
		);

		$payload = json_encode($postRequest);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://202.157.177.157/api/assistant/message/text/notification");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'_token_: '.$token_wa->token,
			'assistant_id: 16d24a5b-8633-4fe2-aa14-76102fe9044b',
			'secret_key: 8c904fa8ad0fdb27cab6caaf773abc33cf3fe61c7e46df18a897bda3b5241f955b7a5f1f3c80fee4d981a5aca11bbec4f6fd4060486817945c5b3d7c29310baf',
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload)
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);

		curl_close($ch);
		$output = json_decode($output, true);

		$this->session->set_flashdata('tab', 'wa');
		if ($output['status'] == 1) {
			$this->session->set_flashdata('status', '1');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ) );
		}

		return $output;
	}

	function act_reset_android_id() {
		$user_id = $this->uri->segment('4');
		$id = null;

		$response = [
			'status' => 200,
			'msg' => 'Android ID Gagal direset!',
			'class' => 'alert alert-danger'
		];
		if ( !empty( $user_id ) ) {
			$update_android_id = [
				'table' => 'core_user_profile',
				'data' => [
					'user_profile_android_id' => ''
				],
				'where' => [
					'user_profile_id' => $user_id
				],
			];
			$id = save_data( $update_android_id );
		}

		$this->session->set_flashdata('tab', 'reset_id');
		if ($id) {
			$this->session->set_flashdata('status', '1');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ));
		} else {
			$this->session->set_flashdata('status', '2');
			return redirect('config/user/get_form_detail/'. enc( [ 'user_id' => $user_id ] ) );
		}

		return $output;

		echo json_encode( $response );
	}

	public function restore_db() {
		$challange = $this->input->post('challange');
		$ciphertext = $this->CaesarEncryptCTR($challange,-7,-3);
		$acode = str_split($ciphertext);
		$code4 = '';
		$code4 .= $acode[1];
		$code4 .= $acode[3];
		$code4 .= $acode[6];
		$code4 .= $acode[4];
		$nilai['hasil'] = $code4;

		$params_insert_master_data_log = [
			'proses_id' => $this->user_info['user_id'],
			'status' => 'sukses',
			'description' => 'User ' . $this->user_info['user_id'] . ' mengenerate restore code dengan challange_code = '.$challange.'-'.$code4,
			'stereotype' => 'GENERATE-RESTORE-DB-PASSKEY',
			'created_by' => $this->user_info['user_id'],
			'created_on' => date( "Y-m-d H:i:s"),
			'prelist_id' => null,
			'lastupdate_by' => null,
			'lastupdate_on' => null,
		];
		$proses_id = save_data( 'dbo.master_data_log', $params_insert_master_data_log);

		echo json_encode($nilai);
	}

	function CaesarEncryptCTR($str, $alphabet_offset = 7, $number_offset = 3) {
		$encrypted_text = "";

		$alphabet_offset = $alphabet_offset % 26;
		if ($alphabet_offset < 0)
		{
			$alphabet_offset += 26;
		}

		$number_offset = $number_offset % 10;
		if ($number_offset < 0)
		{
			$number_offset += 10;
		}

		$i = 0;
		while ($i < strlen($str))
		{
			$c = $str[$i];
			if(($c >= 'A') && ($c <= 'Z')) // upper case
			{
				if((ord($c) + $alphabet_offset) > ord("Z"))
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset - 26);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset);
				}
			}
			else if(($c >= 'a') && ($c <= 'z')) // lower case
			{
				if((ord($c) + $alphabet_offset) > ord("z"))
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset - 26);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $alphabet_offset);
				}
			}
			else if(($c >= '0') && ($c <= '9')) // numeric
			{
				if((ord($c) + $number_offset) > ord("9"))
				{
					$encrypted_text .= chr(ord($c) + $number_offset - 10);
				}
				else
				{
					$encrypted_text .= chr(ord($c) + $number_offset);
				}
			}
			else
			{
				$encrypted_text .= $c;
			}
			$i++;
		}
		return $encrypted_text;
	}

	public function export_data(){
		$data = array();

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('My Notes Code')
					 ->setLastModifiedBy('My Notes Code')
					 ->setTitle("Data User")
					 ->setSubject("User")
					 ->setDescription("Laporan Semua Data User")
					 ->setKeywords("Data User");
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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "provinsi"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "kabupaten/kota"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "kecamatan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "kelurahan/desa"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "username"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "nama_lengkap"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "stereotype"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "tanggal"); 
		$excel->setActiveSheetIndex(0)->setCellValue('I1', "android_id"); 
		$excel->setActiveSheetIndex(0)->setCellValue('J1', "status_aktif"); 

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

		$sql = "EXEC dbo.stp_rekap_user";
		
		$data = $this->db->query($sql);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		$status = "";
		foreach ($data->result_array() as $key => $value)
        { 
			if ($value['user_account_is_active'] == 1) {
				$status = "AKTIF";
			} else $status = "TIDAK AKTIF";

			$tanggal = date("d-m-Y H:i:s",strtotime($value['user_logged_on']));

			// Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $value['province_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $value['regency_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $value['district_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numrow, $value['village_name'],PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $value['username'],PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numrow, $value['nama_lengkap'],PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$numrow, $value['user_stereotype'],PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$numrow, $tanggal,PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$numrow, $value['android_id'],PHPExcel_Cell_DataType::TYPE_STRING);			
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$numrow, $status,PHPExcel_Cell_DataType::TYPE_STRING);			

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
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Daftar User");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="rekap_user"'.date('Y-m-d').'".xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
