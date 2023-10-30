<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_member_account($username)
	{
		try {
			// $query = $this->db->query("SELECT				
			// 	user_account_username as username,
			// 	user_account_password as password,
			// 	user_account_id,
			// 	user_account_is_active
			// 	FROM core_user_account				
			// 	WHERE user_account_username = '{$username}'");
			$query = $this->db->query("EXEC dbo.stp_get_member_account '".$username."'");
			return $query->row();
		} catch (Exception $e) {
			return (object)[];
		}
	}

	public function getAllData($table)
	{
		return $this->db->get($table);
	}

	public function getAllDataLimited($table, $limit, $offset)
	{
		return $this->db->get($table, $limit, $offset);
	}

	public function getSelectedDataLimited($table, $data, $limit, $offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}

	//select table
	public function getSelectedData($table, $data)
	{
		return $this->db->get_where($table, $data);
	}
	//select table
	public function getFoto($table, $data, $filter)
	{
		$this->db->like('stereotype', $filter, 'after');
		return $this->db->get_where($table, $data);
	}

	//select table
	public function getSelectedDataIn($table, $data, $data2, $filter)
	{
		//$this->db->where($data);
		$this->db->select('master_data.*,province_name,regency_name,district_name,village_name');
		$this->db->where_in('master_data.stereotype', $data2);
		$this->db->where($data);
		$this->db->limit(100);
		$this->db->join('dbo.ref_locations', 'ref_locations.bps_full_code = master_data.bps_full_code');
		if (!empty($filter))
			$this->db->where($filter);

		$query = $this->db->get($table);
		return $query;
	}
	public function getSelectedDataInNew($table, $data, $data2, $filter)
	{
		//$this->db->where($data);
		if (!empty($filter))
			$filter2 = 'and '.$filter;
		else
			$filter2 = '';
		$query = $this->db->query("SELECT top 100			
				master_data.* 
				FROM dbo.master_data
				WHERE master_data.stereotype in ('P3','P3a') 
				AND $data $filter2");
		return $query;
	}
	public function getSelectedDataInAssign($table, $data, $data2, $filter, $user_id)
	{
		//$this->db->where($data);
		$this->db->select('master_data.*,province_name,regency_name,district_name,village_name');
		$this->db->where_in('master_data.stereotype', $data2);
		$this->db->where($data);
		//$this->db->group_by("master_data.proses_id,master_data.parent_id"); 
		$this->db->limit(100);
		$this->db->join('dbo.ref_locations', 'ref_locations.location_id = master_data.location_id');
		$this->db->join("(select * from dbo.ref_assignment
		where assignment_id in (select max(assignment_id) from dbo.ref_assignment group by proses_id)) as ref_assignment2", "ref_assignment2.proses_id = master_data.proses_id and ref_assignment2.user_id=$user_id  and ref_assignment2.row_status='ACTIVE' and ref_assignment2.flag='assign'");
		if (!empty($filter))
			$this->db->where($filter);

		$query = $this->db->get($table);
		return $query;
	}
	public function getSelectedDataSpv($table, $data, $data2, $filter)
	{
		//$this->db->where($data);
		$this->db->select('master_data.*,province_name,regency_name,district_name,village_name,mdd.nama as nama_krt_detail,,mdd.no_kk,mdd2.nama as nama_pasangan, mdd2.nama_gadis_ibu_kandung');
		$this->db->where_in('master_data.stereotype', $data2);
		$this->db->where($data);
		$this->db->join('dbo.ref_locations', 'ref_locations.location_id = master_data.location_id');
		$this->db->join('asset.master_data_detail_proses mdd', '(mdd.id = ( SELECT TOP 1 mdd2.id FROM asset.master_data_detail_proses mdd2 WHERE ((mdd2.proses_id = master_data.proses_id) AND mdd2.hubungan_krt=1)))', 'left');
		$this->db->join('asset.master_data_detail_proses mdd2', '(mdd2.id = ( SELECT TOP 1 mdd3.id FROM asset.master_data_detail_proses mdd3 WHERE ((mdd3.proses_id = master_data.proses_id) AND mdd3.hubungan_krt=2)))', 'left');
		if (!empty($filter))
			$this->db->where($filter);

		$query = $this->db->get($table);
		return $query;
	}

	public function getSelectedDataIn2($table, $data, $data2, $filter)
	{
		//$this->db->where($data);
		$this->db->select('monev_data.*,province_name,regency_name,district_name,village_name');
		$this->db->where_in('monev_data.stereotype', $data2);
		$this->db->where($data);
		$this->db->join('dbo.ref_locations', 'ref_locations.location_id = monev_data.location_id');
		if (!empty($filter))
			$this->db->where($filter);

		$query = $this->db->get($table);
		return $query;
	}

	public function getSelectedDataMsign($table, $data)
	{
		//$this->db->where($data);
		$this->db->select('files_msign.*,province_name,regency_name');
		$this->db->where($data);
		$this->db->join('dbo.ref_locations', 'ref_locations.bps_province_code = files_msign.kode_propinsi and ref_locations.bps_regency_code = files_msign.kode_kabupaten and ref_locations.bps_district_code is null');

		$query = $this->db->get($table);
		return $query;
	}

	//select table
	public function getSelectedDataART($table, $data)
	{
		//$this->db->where($data);
		//$this->db->where_in('row_status', $data2);
		$this->db->where($data);
		$query = $this->db->get($table);
		return $query;
	}

	//update table
	function updateData($table, $data, $field_key)
	{
		return $this->db->update($table, $data, $field_key);
	}

	function deleteData($table, $data)
	{
		return $this->db->delete($table, $data);
	}

	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id($table, $data);
	}
	
	function insertData2($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->affected_rows($table, $data);
	}

	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}

	function data_user($id)
	{
		$t = "SELECT * FROM core_user_profile WHERE user_profile_id='$id'";
		$d = $this->db->query($t);

		return $d->row();
	}
	function getGroupUser($id)
	{
		// $query = $this->db->query("SELECT ug.user_group_title as title
		// 		FROM user_group u  
		// 		left join core_user_group ug on u.user_group_group_id=ug.user_group_id 
		// 		WHERE user_group_user_account_id = '{$id}'");
		$query = $this->db->query("EXEC dbo.stp_getGroupUser '".$id."'");
		return $query;
	}
	function ambil_location_prelist($id)
	{
		$text = "
                SELECT bps_province_code,bps_regency_code,bps_district_code,bps_village_code, province_name,regency_name,district_name, village_name
				FROM  [dbo].[ref_locations] 
                WHERE ref_locations.location_id = '$id'
            ";
		$data = $this->manualQuery($text);

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $db) {
				$bps_province_code = $db->bps_province_code . '_' . $db->province_name;
				$bps_regency_code = $db->bps_regency_code . '_' . $db->regency_name;
				$bps_district_code = $db->bps_district_code . '_' . $db->district_name;
				$bps_village_code = $db->bps_village_code . '_' . $db->village_name;
			}

			$regions = array(
				'province' => $bps_province_code,
				'regency' => $bps_regency_code,
				'district' => $bps_district_code,
				'village' => $bps_village_code,
			);
			return $regions;
		}
	}

	
	function cek_foto_kk($id)
	{
		$text = "
                SELECT *
				FROM  [dbo].[files] 
                WHERE owner_id = '$id' and stereotype = 'F-KK' and row_status='ACTIVE'
            ";
		$data = $this->manualQuery($text);

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $db) {
				$internal_filename = $db->internal_filename;
			}
		}
		else
		{
			$internal_filename = '';
		}
		return $internal_filename;
	}

	function ambil_location_get($id)
	{
		$text = "
                SELECT
                user_location_location_id
                FROM [dbo].[user_location]
                WHERE user_location_user_account_id = '$id'
            ";
		$data = $this->manualQuery($text);

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $db) {
				$location_id = $db->user_location_location_id;
				$all_location_get[] = $this->all_location_get($location_id);
				$region_province_get[] = $this->region_province_get($location_id);
				$region_district_get[] = $this->region_district_get($location_id);
				$region_regency_get[] = $this->region_regency_get($location_id);
				$region_village_get[] = $this->region_village_get($location_id);
			}

			$all_location = $this->merge_location($all_location_get);
			$region_province = $this->merge_location($region_province_get);
			$region_district = $this->merge_location($region_district_get);
			$region_regency = $this->merge_location($region_regency_get);
			$region_village = $this->merge_location($region_village_get);

			$regions = array(
				'region_codes' => $all_location,
				'province_codes' => $region_province,
				'regency_codes' => $region_regency,
				'district_codes' => $region_district,
				'village_codes' => $region_village,
			);
			return $regions;
		}
	}
	function ambil_region_get($id)
	{
		$text = "
                SELECT
                user_location_location_id
                FROM [dbo].[user_location]
                WHERE user_location_user_account_id = '$id'
            ";
		$data = $this->manualQuery($text);

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $db) {
				$location_id = $db->user_location_location_id;
				$all_location_get[] = $this->all_location_get($location_id);
			}

			$all_location = $this->merge_location($all_location_get);

			return $all_location;
		}
	}

	function merge_location($location_id)
	{
		$kalimat = implode(",", $location_id);
		$tes = explode(',', $kalimat);
		sort($tes);
		$str = implode(',', array_unique($tes));
		$str = ltrim($str, ',');
		return $str;
	}


	function all_location_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details = $user_group->result_array();
		sort($details);
		$group = array();
		foreach ($details as $db) {
			$group[] = $db['location_id'];
		}
		$kalimat = implode(",", $group);
		return $kalimat;
	}

	function unique_multidim_array($array, $key)
	{
		$temp_array = array();
		$i = 0;
		$key_array = array();

		foreach ($array as $val) {
			if (!in_array($val[$key], $key_array)) {
				$key_array[$i] = $val[$key];
				$temp_array[$i] = $val;
			}
			$i++;
		}
		return $temp_array;
	}

	function region_province_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details =  $this->searchForId('PROVINCE', $user_group->result_array());
		sort($details);
		$group = array();
		foreach ($details as $db) {
			$group[] = $db['location_id'];
		}
		$kalimat = implode(",", $group);
		return $kalimat;
	}

	function region_district_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details =  $this->searchForId('DISTRICT', $user_group->result_array());
		sort($details);
		$group = array();
		foreach ($details as $db) {
			$group[] = $db['location_id'];
		}
		$kalimat = implode(",", $group);
		return $kalimat;
	}

	function region_regency_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details =  $this->searchForId('REGENCY', $user_group->result_array());
		sort($details);
		$group = array();
		foreach ($details as $db) {
			$group[] = $db['location_id'];
		}
		$kalimat = implode(",", $group);
		return $kalimat;
	}

	function region_village_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$user_group2 = $this->get_location_all_down_stream($location_id);
		$details =  array_merge($user_group->result_array(), $user_group2->result_array());
		$details = $this->unique_multidim_array($details, 'location_id');
		$details =  $this->searchForId('VILLAGE', $details);
		sort($details);
		$group = array();
		foreach ($details as $db) {
			$group[] = $db['location_id'];
		}
		$kalimat = implode(",", $group);
		return $kalimat;
	}


	function searchForId($id, $array)
	{
		$temp_array = array();
		$i = 0;
		foreach ($array as $key => $val) {
			if ($val['stereotype'] === $id) {
				$temp_array[$i] = $val;
			}
			$i++;
		}
		return $temp_array;
	}
	function get_location_all_up_stream($id)
	{
		// $query = $this->db->query("WITH cte_org as (
		// 		select 
		// 			a.location_id,
		// 			a.parent_id,
		// 			1 as level,
		// 			a.full_name,
		// 			a.name,
		// 			a.stereotype
		// 		FROM [dbo].[ref_locations] a
		// 		WHERE a.location_id = '{$id}'
		// 	UNION ALL
		// 		SELECT
		// 			c.location_id,
		// 			c.parent_id,
		// 			p.level + 1 AS level,
		// 			c.full_name,
		// 			c.name,
		// 			c.stereotype
		// 		FROM [dbo].[ref_locations] c
		// 		JOIN cte_org p ON c.location_id = p.parent_id
		// )
		// SELECT
		// 	location_id,
		// 	parent_id,
		// 	full_name,
		// 	name,
		// 	stereotype
		// FROM cte_org ");
		$query = $this->db->query("EXEC dbo.stp_get_location_all_up '".$id."'");
		return $query;
	}
	function get_location_all_down_stream($id)
	{
		// $query = $this->db->query("WITH cte_org as (
		// 		select 
		// 			a.location_id,
		// 			a.parent_id,
		// 			1 as level,
		// 			a.full_name,
		// 			a.name,
		// 			a.stereotype
		// 		FROM [dbo].[ref_locations] a
		// 		WHERE a.location_id = '{$id}'
		// 	UNION ALL
		// 		SELECT
		// 			c.location_id,
		// 			c.parent_id,
		// 			p.level + 1 AS level,
		// 			c.full_name,
		// 			c.name,
		// 			c.stereotype
		// 		FROM [dbo].[ref_locations] c
		// 		JOIN cte_org p ON c.parent_id = p.location_id
		// )
		// SELECT
		// 	location_id,
		// 	parent_id,
		// 	full_name,
		// 	name,
		// 	stereotype
		// FROM cte_org ");
		$query = $this->db->query("EXEC dbo.stp_get_location_all_down '".$id."'");
		return $query;
	}


	function getNewBDTID($location_id, $prelist_prefix)
	{
		$year = date('Y');
		$text = "SELECT top 1 id_prelist FROM asset.master_data 
				WHERE fiscal_year = '$year' and id_prelist LIKE '$prelist_prefix%'
				order by id_prelist desc ";
		$data = $this->manualQuery($text);

		if ($data->num_rows() > 0) {
			foreach ($data->result() as $t) {
				$last_bdt_id = $t->id_prelist;
				$last_index = intval(substr($last_bdt_id, 10, 6));
				if ($last_index >= 900000) {
					$next_index = $last_index + 1;
				}
			}
		} else {
			$next_index = 900001;
		}
		return $prelist_prefix . $next_index;
	}

	function getNewProsesId()
	{
		$text = "SELECT max(proses_id) as proses_id FROM asset.master_data";
		$data = $this->manualQuery($text);
		$text2 = "SELECT max(proses_id) as proses_id FROM asset.master_data";
		$data2 = $this->manualQuery($text2);
		$row = $data->row();
		$row2 = $data2->row();
		if (isset($row)) {
			$proses_id = $row->proses_id;
		} else {
			$proses_id = 1;
		}
		if (isset($row2)) {
			$proses_id2 = $row2->proses_id;
		} else {
			$proses_id2 = 1;
		}
		if ($proses_id < $proses_id2)
			$max_id = $proses_id2 + 1;
		elseif ($proses_id > $proses_id2)
			$max_id = $proses_id + 1;
		else
			$max_id = $proses_id + 1;

		return $max_id;
	}
}
