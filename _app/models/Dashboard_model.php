<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('replication', TRUE);
	}

	## Start Eksekutif ============================================================================================== ##

	function get_prog_ruta_head($area)
	{
		$sql = "EXEC dbo.usp_d_get_prog_ruta_head '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_prog_art_head($area)
	{
		$sql = "EXEC dbo.usp_d_get_prog_art_head '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_art_today_head($area)
	{
		$now = date('Y-m-d');
		$sql = "EXEC dbo.usp_d_get_art_today_head '" . $now . "', '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_prog_today_head($area)
	{
		$now = date('Y-m-d');
		$sql = "EXEC dbo.usp_d_get_tabel_head '" . $now . "', '" . $area . "'";
		return $this->db2->query($sql)->row_array();
	}

	function get_get_sum_target_art($area)
	{
		$sql = "EXEC dbo.usp_d_get_sum_target_art '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_view_dates()
	{
		$sql = "EXEC dbo.usp_d_get_view_dates";
		return $this->db2->query($sql)->result_array();
	}

	function get_chart_art_perday($area)
	{
		$sql = "EXEC dbo.usp_dashboard_chart '" . $area . "'";
		return $this->db2->query($sql)->result_array();
	}

	function get_target_chart($area)
	{
		$sql = "EXEC dbo.usp_dashboard_chart_target_new '" . $area . "'";
		return $this->db2->query($sql)->result_array();
	}

	function get_arr_data_table($area)
	{
		$cond = $area != '' ? strlen($area) : 0;
		$sql = "EXEC dbo.usp_d_get_arr_data_table '" . $cond . "', '" . $area . "'";
		return $this->db2->query($sql)->result_array();
	}
	function get_arr_data_table_new($area)
	{
		$cond = $area != '' ? strlen($area) : 0;
		$sql = "EXEC dbo.usp_d_get_arr_data_table_new '" . $cond . "', '" . $area . "'";
		return $this->db2->query($sql)->result_array();
	}

	function get_arr_data_table_progres($area)
	{
		$cond = $area != '' ? strlen($area) : 0;
		$sql = "EXEC dbo.usp_d_get_arr_data_table_progres '" . $cond . "', '" . $area . "'";
		return $this->db2->query($sql)->result_array();
	}

	function get_code_table($wilayah, $area)
	{
		$cond = $area != '' ? strlen($area) : 0;
		$wil = str_replace("'", "''", $wilayah);
		$sql = "EXEC dbo.usp_d_get_code_table '" . $area . "', '" . $wil . "', '" . $cond . "'";
		return $this->db2->query($sql)->row('kode');
	}

	function get_art_pemadanan($sts, $kode)
	{
		$sql = "EXEC dbo.usp_d_get_art_pemadanan_table '" . $kode . "', '" . $sts . "'";
		return $this->db2->query($sql)->row('tot_art');
	}

	function get_art_konfirmasi($sts, $kode)
	{
		$sql = "EXEC dbo.usp_d_get_art_konfirmasi_table '" . $kode . "', '" . $sts . "'";
		return $this->db2->query($sql)->row('tot_art');
	}

	function get_desa_foto($kode, $type)
	{
		$sql = "EXEC dbo.usp_d_get_desa_foto '" . $type . "', '" . $kode . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_keberadaan_art($sts, $kode)
	{
		$sql = "EXEC dbo.usp_d_get_keberadaan_art_table '" . $kode . "', '" . $sts . "'";
		return $this->db2->query($sql)->row('tot_art');
	}

	function get_real_desa($kode)
	{
		$sql = "EXEC dbo.usp_d_get_desa_realisasi '" . $kode . "'";
		return $this->db2->query($sql)->row('total');
	}

	## End Eksekutif ================================================================================================ ##


	## Start Status Proses ========================================================================================== ##

	function get_status_query_md($sts, $area)
	{
		$sql = "EXEC dbo.usp_d_get_status_query_md '" . $sts . "', '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_status_query_mdd($sts, $area)
	{
		$sql = "EXEC dbo.usp_d_get_status_query_mdd '" . $sts . "', '" . $area . "'";
		return $this->db2->query($sql)->row('total');
	}

	function get_status_query_md_new($area)
	{
		$sql = "EXEC dbo.usp_d_get_status_query_md_new '" . $area . "'";
		return $this->db2->query($sql)->row_array();
	}

	function get_status_query_mdd_new($area)
	{
		$sql = "EXEC dbo.usp_d_get_status_query_mdd_new '" . $area . "'";
		return $this->db2->query($sql)->row_array();
	}

	function get_status_art($area)
	{
		$sql = "EXEC dbo.usp_d_get_status_keberadaan_art '" . $area . "'";
		return $this->db2->query($sql)->row_array();
	}

	## End Status Proses ============================================================================================ ##

	## Start Maps =-================================================================================================= ##

	function get_wilayah($area)
	{
		$filter = 'DISTINCT(province_name) wilayah, COUNT(proses_id) total';
		$grup = 'GROUP BY province_name';
		$f_area = '';
		if ($area != '') {
			$f_area = "AND bps_full_code LIKE '$area%'";
			if (strlen($area) == 2) {
				$filter = 'DISTINCT(regency_name) wilayah, COUNT(proses_id) total';
				$grup = 'GROUP BY regency_name';
			} else if (strlen($area) == 4) {
				$filter = 'DISTINCT(district_name) wilayah, COUNT(proses_id) total';
				$grup = 'GROUP BY district_name';
			} else if (strlen($area) == 7) {
				$filter = 'DISTINCT(village_name) wilayah, COUNT(proses_id) total';
				$grup = 'GROUP BY village_name';
				// } else if (strlen($area) == 10){
				// 	$filter = 'village_name wilayah';
				// 	$grup = '';
			}
		}
		$sql = "SELECT $filter FROM dbo.vw_dashboard_map WHERE Lat IS NOT NULL AND long IS NOT NULL $f_area $grup";
		return $this->db2->query($sql)->result_array();
	}

	function get_latlng($wilayah, $area)
	{
		$filter = 'province_name';
		$t = 'TOP 1';
		if ($area != '') {
			if (strlen($area) == 2) {
				$filter = 'regency_name';
			} else if (strlen($area) == 4) {
				$filter = 'district_name';
			} else if (strlen($area) == 7) {
				$filter = 'village_name';
				// } else if (strlen($area) == 10){
				// 	$filter = 'village_name';
				// 	$t = '';
			}
		}

		$sql = "SELECT $t lat, long FROM dbo.vw_dashboard_map WHERE Lat IS NOT NULL AND long IS NOT NULL AND $filter = '$wilayah'";
		// print_r($sql);
		return $this->db2->query($sql)->row_array();
	}

	## End Maps ==================================================================================================== ##
}
