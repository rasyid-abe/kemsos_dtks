<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Login_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('encryption');
		$this->load->library('form_validation');
	}

	function index() {
		$this->show();
	}

	function show() {
		$data = array();

		$vals = array(
			'word'          => rand(1,999999),
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url('assets').'/captcha/',
			'img_width'     => '130',
			'img_height'    => 30,
			'word_length'   => 8,
			'colors'        => array(
				'background'     => array(255, 255, 255),
				'border'         => array(255, 255, 255),
				'text'           => array(0, 0, 0),
				'grid'           => array(255, 75, 100)
			)
		);

		$data['captha_image'] = create_captcha($vals);
		$this->template->content( "captcha", $data );
		$this->template->show( THEMES_LOGIN . 'index' , $data);
	}

	function auth(){
		$this->load->helper('security');
		$in = $this->input->post();
		$redirect_url = ( ( ! empty( $in['redirect_url'] ) ) ? explode( base_url(), $in['redirect_url'] ) : '' );
		$redirect = ( ( ! empty( $in['redirect_url'] ) ) ? $redirect_url[1] : 'dashboard/eksekutif' );

		if($this->input->post('code_cap') == $this->input->post('captcha_input')) {
			if ( ! empty( $in['username'] ) && ! empty( $in['password'] ) ) {
				if ( $this->verify_user( xss_clean( html_escape( $in['username'] ) ) ) && $this->verify_password( xss_clean( html_escape( $in['password'] ) ) ) ) {
					$user_group = ['0' => 'root'];
					$session_arr = [
						'user_info' => [
							'user_username' => 'root',
							'user_name' => 'Root',
							'user_id' => '0',
							'user_group' => $user_group,
							'user_last_login' => '-',
							'user_image' => '',
							'user_account_email' => '',
							'user_location' => ['100000'],
							'user_is_login' => 1,
						]
					];
					$this->session->set_userdata( $session_arr );
					$this->set_session_menu( $user_group );
					redirect( base_url( $redirect ) );
				} else {
					if ( $this->cek_user( $in['username'] ) ) {
						$pass = $this->db->get_where('dbo.core_user_account', ['user_account_username' => $in['username']])->row('user_account_password');
						if ($this->encryption->decrypt($pass) === $in['password']) {
							$user = $this->get_detail_user( $in['username'] );
							if($user->user_account_is_active==1)
							{
								$id_user = $user->user_account_id;
								
								// cek group dan lokasi
								$cek_group = [
									'table' => 'dbo.user_group',
									'select' => 'user_group_user_account_id',
									'where' => [
										'user_group_user_account_id' => $id_user
									]
								];				
								
								$cek_lokasi = [
									'table' => 'dbo.user_location',
									'select' => 'user_location_user_account_id',
									'where' => [
										'user_location_user_account_id' => $id_user
									]
								];						

								$hasil_cek_g = get_data( $cek_group );

								$hasil_cek_l = get_data( $cek_lokasi );															

								if ( $hasil_cek_g->num_rows() < 1) {
									$this->session->set_flashdata('message', '<b>Group</b> user belum diatur.');
									redirect( base_url( 'login' ) );
								}	

								if ( $hasil_cek_l->num_rows() < 1) {
									$this->session->set_flashdata('message', '<b>Lokasi</b> user belum diatur.');
									redirect( base_url( 'login' ) );
								}
								// end cek group dan lokasi

								$user_group = $this->get_group_user( $user->user_account_id );
								$location = $this->get_location_user( $user->user_account_id );

								$arr_parent_id = [];
								foreach ($user_group as $key => $value) {
									$parent_group = $this->db->get_where('dbo.core_user_group', ['user_group_name' => $value])->row_array();
									$arr_parent_id[] = $parent_group['user_group_parent_id'];
								}
								if (in_array('0', $arr_parent_id)) {
									$location = ['100000'];
									array_push($user_group,"root");
								}						

								$session_arr = [
									'user_info' => [
										'user_username' => $user->user_account_username,
										'user_name' => $user->user_profile_first_name . ' ' .$user->user_profile_last_name,
										'user_id' => $id_user,
										'user_group' => $user_group,
										'user_last_login' => $user->user_account_last_login_datetime,
										'user_image' => $user->user_profile_image,
										'user_account_email' => $user->user_account_email,
										'user_location' => $location,
										'user_is_login' => 1,
									]
								];

								date_default_timezone_set('Asia/Jakarta');
								save_data( 'dbo.core_user_account', ['user_account_last_login_datetime' => date('Y-m-d H:i:s')], [ 'user_account_id' => $user->user_account_id ]);

								$this->session->set_userdata( $session_arr );

								$filter_group_menu = [];
								foreach ($user_group as $key => $value) {
									if ($value != 'root') {
										$filter_group_menu[] = $value;
									}
								}								

								$this->set_session_menu( $filter_group_menu );
								// $this->set_session_menu( $user_group );
								redirect( base_url( $redirect ) );
							}
							else
							{
								$this->session->set_flashdata('message', '<b>"Akun anda tidak aktif!!"</b>');
								redirect( base_url( 'login' ) );
							}
						} else {
							$this->session->set_flashdata('message', '<b>"Password"</b> salah !');
							redirect( base_url( 'login' ) );
						}					

					} else {
						$this->session->set_flashdata('message', '<b>"Username"</b> tidak ditemukan!');
						redirect( base_url( 'login' ) );
					}
				}
			} else {
				$this->session->set_flashdata('message', '<b>"Username"</b> atau <b>"Password</b>" harus diisi!');
				redirect( base_url( 'login' ) );
			}
		}	else {
			$this->session->set_flashdata('message', '<b>Captcha tidak sesuai.</b>');
			redirect( base_url( 'login' ) );
		}
	}

	function cek_user( $username ){
		$params_account = [
			'table' => 'dbo.core_user_account',
			'select' => 'user_account_id',
			'where' => [
				'user_account_username' => $username
			]
		];
		$query = get_data( $params_account );
		if ( $query->num_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function get_detail_user( $username ){
		$params_account = [
			'table' => [
				'dbo.core_user_account' => '',
				'dbo.core_user_profile' => 'user_account_id = user_profile_id',
			],
			'select' => 'user_account_id, user_account_username, user_account_is_active, user_account_email, user_account_last_login_datetime, user_profile_first_name, user_profile_last_name, user_profile_image',
			'where' => [
				'user_account_username' => "$username"
			]
		];
		$query = get_data( $params_account );
		return $query->row();
	}

	function get_location_user( $user_id ){
		$params_location = [
			'table' => 'dbo.user_location',
			'select' => 'user_location_location_id',
			'where' => [
				'user_location_user_account_id' => $user_id
			]
		];
		$query = get_data( $params_location );
		$arr_location = [];
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $loc ) {
				$arr_location[] = $loc->user_location_location_id;
			}
		}
		return $arr_location;
	}

	function get_group_user( $user_id ){
		$params_group = [
			'table' => [
				'dbo.user_group' => '',
				'dbo.core_user_group' => 'user_group.user_group_group_id = core_user_group.user_group_id'
			],
			'select' => 'user_group_group_id, user_group_name',
			'where' => [
				'user_group_user_account_id' => $user_id,
				'user_group_is_active' => '1'
			]
		];
		$query = get_data( $params_group );
		$arr_group = [];
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $group ) {
				$arr_group[$group->user_group_group_id] = $group->user_group_name;
			}
		}
		return $arr_group;
	}

	function set_session_menu( $arr_user_group = [] ) {
		$array_menu = [];
		$arr_menu = [];
		if ( ! empty( $arr_user_group ) ) {
			foreach ( $arr_user_group as $group_id => $group_name ) {
				$get_wh = $this->db->get_where('dbo.core_user_group', ['user_group_name' => $group_name])->row('user_group_id');
				if ( $get_wh == '0' || $group_name == 'root' ) {
					$params = [
						'table' => 'dbo.core_menu',
						'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_image, menu_class, menu_sort',
						'where' => [ 'menu_is_active' => '1' ]
					];
				} else {
					$params = [
						'table' => [
							'dbo.core_user_role' => '',
							'dbo.core_menu' => ['user_role_menu_id = menu_id', 'LEFT']
						],
						'select' => 'menu_id, menu_parent_menu_id, menu_name, menu_slug, menu_url, menu_description, menu_image, menu_class, menu_sort, user_role_menu_action menu_action',
						'where' => [
							'menu_is_active' => '1',
							'user_role_user_group_id' => $get_wh
						 ]
					];
				}
				$query_menu = get_data( $params );
				if ( $query_menu->num_rows() > 0 ) {
					foreach ( $query_menu->result_array() as $row_menu ) {
						$arr_menu[$row_menu['menu_parent_menu_id']][$row_menu['menu_sort']] = $row_menu;
					}
				}
			}
		}
		$array_menu = array(
			'user_menu' => $arr_menu
		);
		$this->session->set_userdata( $array_menu );
	}
}
