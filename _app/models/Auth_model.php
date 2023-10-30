<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
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

    //Query manual
    function manualQuery($q)
    {
        return $this->db->query($q);
    }
	
	function getAssetIDVerval($id)
    {
        $t = "SELECT proses_id FROM asset.master_data_proses WHERE stereotype='VERIVALI-SUPERVISOR-APPROVED' and hasil_verivali is not null and status_rumahtangga=1 and location_id=$id";
        $d = $this->db->query($t);
       
        return $d;
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
				$region_village_get[]= $this->region_village_get($location_id);
			}
			
			$region_village=$this->merge_location($region_village_get);
			
			$regions = array(
					'village_codes' => $region_village,
				);
			return $regions;
		}
    }
    
    function merge_location($location_id)
	{
		$kalimat = implode(",",$location_id);
		$tes =explode(',', $kalimat);
		sort($tes);
		$str = implode(',',array_unique($tes));	
		$str=ltrim($str,',');			
		return $str;
	}
	
	
	function all_location_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details = $user_group->result_array();
		sort($details);
		$group = array();
		foreach($details as $db)
		{
			$group[] =$db['location_id'];
		}
		$kalimat = implode(",",$group);
		return $kalimat;
	}
	
	function unique_multidim_array($array, $key) {
		$temp_array = array();
		$i = 0;
		$key_array = array();
	   
		foreach($array as $val) {
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
		$details =  $this->searchForId('PROVINCE',$user_group->result_array());
		sort($details);
		$group = array();
		foreach($details as $db)
		{
			$group[] =$db['location_id'];
		}
		$kalimat = implode(",",$group);
		return $kalimat;
	}
	
	function region_district_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details =  $this->searchForId('DISTRICT',$user_group->result_array());
		sort($details);
		$group = array();
		foreach($details as $db)
		{
			$group[] =$db['location_id'];
		}
		$kalimat = implode(",",$group);
		return $kalimat;
	}
	
	function region_regency_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$details =  $this->searchForId('REGENCY',$user_group->result_array());
		sort($details);
		$group = array();
		foreach($details as $db)
		{
			$group[] =$db['location_id'];
		}
		$kalimat = implode(",",$group);
		return $kalimat;
	}
	
	function region_village_get($location_id)
	{
		$user_group = $this->get_location_all_up_stream($location_id);
		$user_group2 = $this->get_location_all_down_stream($location_id);
		$details =  array_merge($user_group->result_array(),$user_group2->result_array());
		$details = $this->unique_multidim_array($details,'location_id');
		$details =  $this->searchForId('VILLAGE',$details);
		sort($details);
		$group = array();
		foreach($details as $db)
		{
			$group[] =$db['location_id'];
		}
		$kalimat = implode(",",$group);
		return $kalimat;
	}
	

	function searchForId($id, $array) {
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
        $query = $this->db->query("EXEC dbo.stp_get_location_all_up '".$id."'");
		return $query;
    }
	function get_location_all_down_stream($id)
    {
		$query = $this->db->query("EXEC dbo.stp_get_location_all_down '".$id."'");
		return $query;
    }
	

}

?>