<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('server/auth_model');
	}

	public function checkupdate_get()
	{
		$query = $this->db->query("SELECT TOP 1 * FROM version_apps ORDER BY id_version DESC ");
		$result = $query->row_array();

		$this->app_response(
			REST_Controller::HTTP_OK,

			array(
				'code' => '200',
				'message' => 'Version Apps'
			),
			array(
				"appCodeVersion" => $result['app_version_code'],
				"appVersion" => $result['app_version'],
				"appDateUpdate" => $result['force_update_after'],
				"appUpdateDesc" => $result['description']
			)
		);
	}
	public function pemadanan_post()
	{
		$url     = "http://siksnik.kemsos.net/api/clidata/ceknik" ;
		
		//$idx['stereotype'] = 'M4';
		
		// $sqln = "
		// 	SELECT top 200 * FROM master_data_detail
		// 	WHERE stereotype = 'M4'
		// ";
		$get_data =  $this->db->query("EXEC dbo.sp_get_data_m4");
		//$get_data = $this->db->query($sqln);
		foreach ($get_data->result() as $db) {
			$nik = $db->nik;
			$idartbdt = $db->IDARTBDT;
			$idart = $db->id;
			$nama_art = str_replace("'","",$db->nama_art);
			$nama_art2 = str_replace('"','',$nama_art);
			$jumlah_hit = $db->jumlah_hit;
			$data = ['NIK'=>$nik , 'token'=>'IoRJ0FnMdB5Bckhj0emY5jvbgCfm15PQZXWZs3Riml'];
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			curl_setopt($ch, CURLOPT_USERAGENT , 'PostmanRuntime/7.26.5');
				
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			$output2 = json_decode($output);
			$cek_api = 0;
			if(!empty($output2->content))
			{
				foreach ($output2->content as $entry) {
					if(empty($entry->RESPON))
					{
						$art['NO_KK'] = $entry->NO_KK;
						$art['DUSUN'] = $entry->DUSUN;
						$art['NIK'] = $entry->NIK;
						$art['NAMA_LGKP'] = $entry->NAMA_LGKP;
						$art['STAT_HBKEL'] = $entry->STAT_HBKEL;
						$art['KAB_NAME'] = $entry->KAB_NAME;
						$art['NAMA_LGKP_AYAH'] = $entry->NAMA_LGKP_AYAH;
						$art['NO_RW'] = $entry->NO_RW;
						$art['KEC_NAME'] = $entry->KEC_NAME;
						$art['JENIS_PKRJN'] = $entry->JENIS_PKRJN;
						$art['NO_RT'] = $entry->NO_RT;
						$art['NO_KEL'] = $entry->NO_KEL;
						$art['ALAMAT'] = $entry->ALAMAT;
						$art['NO_KEC'] = $entry->NO_KEC;
						$art['TMPT_LHR'] = $entry->TMPT_LHR;
						$art['PDDK_AKH'] = $entry->PDDK_AKH;
						$art['NO_PROP'] = $entry->NO_PROP;
						$art['STATUS_KAWIN'] = $entry->STATUS_KAWIN;
						$art['NAMA_LGKP_IBU'] = $entry->NAMA_LGKP_IBU;
						$art['PROP_NAME'] = $entry->PROP_NAME;
						$art['NO_KAB'] = $entry->NO_KAB;
						$art['KEL_NAME'] = $entry->KEL_NAME;
						$art['JENIS_KLMIN'] = $entry->JENIS_KLMIN;
						$art['TGL_LHR'] = $entry->TGL_LHR;
						$id['NIK'] = $entry->NIK;
						//$data2 = $this->auth_model->getSelectedData("dbo.HITNIK", $id);
						//if($data2->num_rows() == 0) {
							$this->db->query("EXEC dbo.sp_insert_hitnik ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
							//$this->auth_model->insertData("dbo.HITNIK", $art);
						//} 
						$list_art[] = array(
							'data' => $entry
						);
						$nama_capil = str_replace("'","",$entry->NAMA_LGKP);
						$nama_capil2 = str_replace('"','',$nama_capil);
						$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$nama_capil2);
						$nilai = $nilai_padan * 100;
						if($nilai>=60)
						{
							$mdd['stereotype'] = 'MK';
							//$this->db->set('stereotype', 'MK');
							$status = 'MK';
							$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
						}
						else
						{
							if(strpos($nama_capil2, '/') !== false){
								$str = explode("/",$nama_capil2);
								$MAX_VALUE=0;
								for ($i = 0; $i < count($str); $i++)  {
									$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$str[$i]);
									$nilai = $nilai_padan * 100;
									if($nilai > $MAX_VALUE){
										$MAX_VALUE=$nilai;
									}
								}
								if($MAX_VALUE>=60)
								{
									$mdd['stereotype'] = 'MK';
									//$this->db->set('stereotype', 'MK');
									$status = 'MK';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								else
								{
									$mdd['stereotype'] = 'MKa';
									//$this->db->set('stereotype', 'MKa');
									$status = 'MKa';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}	
							}
							elseif(strpos($nama_art2, '/') !== false){
								$str = explode("/",$nama_art2);
								$MAX_VALUE=0;
								for ($i = 0; $i < count($str); $i++)  {
									$nilai_padan = $this->cek_padan(strtoupper($str[$i]),$nama_capil2);
									$nilai = $nilai_padan * 100;
									if($nilai > $MAX_VALUE){
										$MAX_VALUE=$nilai;
									}
								}
								if($MAX_VALUE>=60)
								{
									$mdd['stereotype'] = 'MK';
									//$this->db->set('stereotype', 'MK');
									$status = 'MK';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								else
								{
									$mdd['stereotype'] = 'MKa';
									//$this->db->set('stereotype', 'MKa');
									$status = 'MKa';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								
							}
							else
							{
								$mdd['stereotype'] = 'MKa';
								//$this->db->set('stereotype', 'MKa');
								$status = 'MKa';
								$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
						
							}
						}
						$cek_api = 1;
					}
					elseif($entry->RESPON == 'Data Tidak Ditemukan')
					{
						$mdd['stereotype'] = 'MKa';
						//$this->db->set('stereotype', 'MKa');
						$status = 'MKa';
						$desc = "Data ART NIK" . $nik . " TIDAK PADAN, Data Tidak Ditemukan ";
						$cek_api = 1;
					}
					else
					{
						$cek_api = 0;
					}
				}
				
			}
			else
			{
				$cek_api = 0;
			}
			if($cek_api==1)
			{
				$mdd['jumlah_hit'] = $jumlah_hit + 1;
				$mdd['id'] = $idart;
				$this->db->query("EXEC dbo.sp_update_mdd_pemadanan ?, ?, ?", $mdd);
				// $this->db->set('jumlah_hit', $jumlah_hit + 1);
				// $this->db->where('IDARTBDT', $idartbdt);
				// $this->db->update('dbo.master_data_detail');
				$dl_art['created_by'] = 0;
				$dl_art['detail_id'] = $idart;
				$dl_art['status'] = 'sukses';
				$dl_art['stereotype'] = $status;
				$dl_art['description'] = $desc;
				$dl_art['created_on'] = date("Y-m-d H:i:s");
				$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
			}

			//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
		}
		//print_r(json_encode($list_art));
		
		
	}
	public function pemadanan2_post()
	{
		$url     = "http://siksnik.kemsos.net/api/clidata/ceknik" ;
		
		//$idx['stereotype'] = 'M4';
		$query = $this->db->query("SELECT count(id) as jumlah FROM master_data_detail WHERE stereotype = 'M4'");
		$row = $query->row();
		if($row->jumlah > 1000)
		{
			/*$sqln = "
				SELECT top 500 * FROM master_data_detail
				WHERE stereotype = 'M4' order by lastupdate_on desc
			 ";*/
			$get_data =  $this->db->query("EXEC dbo.sp_get_data_m4_desc");
			//$get_data = $this->db->query($sqln);
			foreach ($get_data->result() as $db) {
				$nik = $db->nik;
				$idartbdt = $db->IDARTBDT;
				$idart = $db->id;
				$nama_art = str_replace("'","",$db->nama_art);
				$nama_art2 = str_replace('"','',$nama_art);
				$jumlah_hit = $db->jumlah_hit;
				$data = ['NIK'=>$nik , 'token'=>'IoRJ0FnMdB5Bckhj0emY5jvbgCfm15PQZXWZs3Riml'];
				$ch = curl_init($url);
				
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

				curl_setopt($ch, CURLOPT_USERAGENT , 'PostmanRuntime/7.26.5');
					
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				curl_close($ch);
				$output2 = json_decode($output);
				$cek_api = 0;
				if(!empty($output2->content))
				{
					foreach ($output2->content as $entry) {
						if(empty($entry->RESPON))
						{
							$art['NO_KK'] = $entry->NO_KK;
							$art['DUSUN'] = $entry->DUSUN;
							$art['NIK'] = $entry->NIK;
							$art['NAMA_LGKP'] = $entry->NAMA_LGKP;
							$art['STAT_HBKEL'] = $entry->STAT_HBKEL;
							$art['KAB_NAME'] = $entry->KAB_NAME;
							$art['NAMA_LGKP_AYAH'] = $entry->NAMA_LGKP_AYAH;
							$art['NO_RW'] = $entry->NO_RW;
							$art['KEC_NAME'] = $entry->KEC_NAME;
							$art['JENIS_PKRJN'] = $entry->JENIS_PKRJN;
							$art['NO_RT'] = $entry->NO_RT;
							$art['NO_KEL'] = $entry->NO_KEL;
							$art['ALAMAT'] = $entry->ALAMAT;
							$art['NO_KEC'] = $entry->NO_KEC;
							$art['TMPT_LHR'] = $entry->TMPT_LHR;
							$art['PDDK_AKH'] = $entry->PDDK_AKH;
							$art['NO_PROP'] = $entry->NO_PROP;
							$art['STATUS_KAWIN'] = $entry->STATUS_KAWIN;
							$art['NAMA_LGKP_IBU'] = $entry->NAMA_LGKP_IBU;
							$art['PROP_NAME'] = $entry->PROP_NAME;
							$art['NO_KAB'] = $entry->NO_KAB;
							$art['KEL_NAME'] = $entry->KEL_NAME;
							$art['JENIS_KLMIN'] = $entry->JENIS_KLMIN;
							$art['TGL_LHR'] = $entry->TGL_LHR;
							$id['NIK'] = $entry->NIK;
							//$data2 = $this->auth_model->getSelectedData("dbo.HITNIK", $id);
							//if($data2->num_rows() == 0) {
								$this->db->query("EXEC dbo.sp_insert_hitnik ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
								//$this->auth_model->insertData("dbo.HITNIK", $art);
							//} 
							$list_art[] = array(
								'data' => $entry
							);
							$nama_capil = str_replace("'","",$entry->NAMA_LGKP);
							$nama_capil2 = str_replace('"','',$nama_capil);
							$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$nama_capil2);
							$nilai = $nilai_padan * 100;
							if($nilai>=60)
							{
								$mdd['stereotype'] = 'MK';
								//$this->db->set('stereotype', 'MK');
								$status = 'MK';
								$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
							}
							else
							{
								if(strpos($nama_capil2, '/') !== false){
									$str = explode("/",$nama_capil2);
									$MAX_VALUE=0;
									for ($i = 0; $i < count($str); $i++)  {
										$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$str[$i]);
										$nilai = $nilai_padan * 100;
										if($nilai > $MAX_VALUE){
											$MAX_VALUE=$nilai;
										}
									}
									if($MAX_VALUE>=60)
									{
										$mdd['stereotype'] = 'MK';
										//$this->db->set('stereotype', 'MK');
										$status = 'MK';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									else
									{
										$mdd['stereotype'] = 'MKa';
										//$this->db->set('stereotype', 'MKa');
										$status = 'MKa';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}	
								}
								elseif(strpos($nama_art2, '/') !== false){
									$str = explode("/",$nama_art2);
									$MAX_VALUE=0;
									for ($i = 0; $i < count($str); $i++)  {
										$nilai_padan = $this->cek_padan(strtoupper($str[$i]),$nama_capil2);
										$nilai = $nilai_padan * 100;
										if($nilai > $MAX_VALUE){
											$MAX_VALUE=$nilai;
										}
									}
									if($MAX_VALUE>=60)
									{
										$mdd['stereotype'] = 'MK';
										//$this->db->set('stereotype', 'MK');
										$status = 'MK';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									else
									{
										$mdd['stereotype'] = 'MKa';
										//$this->db->set('stereotype', 'MKa');
										$status = 'MKa';
										$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
									}
									
								}
								else
								{
									$mdd['stereotype'] = 'MKa';
									//$this->db->set('stereotype', 'MKa');
									$status = 'MKa';
									$desc = "Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
							
								}
							}
							$cek_api = 1;
						}
						elseif($entry->RESPON == 'Data Tidak Ditemukan')
						{
							$mdd['stereotype'] = 'MKa';
							//$this->db->set('stereotype', 'MKa');
							$status = 'MKa';
							$desc = "Data ART NIK" . $nik . " TIDAK PADAN, Data Tidak Ditemukan ";
							$cek_api = 1;
						}
						else
						{
							$cek_api = 0;
						}
					}
					
				}
				else
				{
					$cek_api = 0;
				}
				if($cek_api==1)
				{
					$mdd['jumlah_hit'] = $jumlah_hit + 1;
					$mdd['id'] = $idart;
					$this->db->query("EXEC dbo.sp_update_mdd_pemadanan ?, ?, ?", $mdd);
					// $this->db->set('jumlah_hit', $jumlah_hit + 1);
					// $this->db->where('IDARTBDT', $idartbdt);
					// $this->db->update('dbo.master_data_detail');
					$dl_art['created_by'] = 0;
					$dl_art['detail_id'] = $idart;
					$dl_art['status'] = 'sukses';
					$dl_art['stereotype'] = $status;
					$dl_art['description'] = $desc;
					$dl_art['created_on'] = date("Y-m-d H:i:s");
					$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
				}

				//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
			}
			//print_r(json_encode($list_art));
		}
		
	}
	public function pemadanan_mka_post()
	{
		$url     = "http://siksnik.kemsos.net/api/clidata/ceknik" ;
		
		//$idx['stereotype'] = 'M4';
		
		$sqln = "
			SELECT top 500 * FROM master_data_detail
			WHERE stereotype = 'Q1a' order by lastupdate_on
		";
		//$get_data =  $this->db->query("EXEC dbo.sp_get_data_m4");
		$get_data = $this->db->query($sqln);
		foreach ($get_data->result() as $db) {
			$nik = $db->nik;
			$idartbdt = $db->IDARTBDT;
			$idart = $db->id;
			$nama_art = str_replace("'","",$db->nama_art);
			$nama_art2 = str_replace('"','',$nama_art);
			$jumlah_hit = $db->jumlah_hit;
			$data = ['NIK'=>$nik , 'token'=>'IoRJ0FnMdB5Bckhj0emY5jvbgCfm15PQZXWZs3Riml'];
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			curl_setopt($ch, CURLOPT_USERAGENT , 'PostmanRuntime/7.26.5');
				
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			$output2 = json_decode($output);
			$cek_api = 0;
			if(!empty($output2->content))
			{
				foreach ($output2->content as $entry) {
					if(empty($entry->RESPON))
					{
						$art['NO_KK'] = $entry->NO_KK;
						$art['DUSUN'] = $entry->DUSUN;
						$art['NIK'] = $entry->NIK;
						$art['NAMA_LGKP'] = $entry->NAMA_LGKP;
						$art['STAT_HBKEL'] = $entry->STAT_HBKEL;
						$art['KAB_NAME'] = $entry->KAB_NAME;
						$art['NAMA_LGKP_AYAH'] = $entry->NAMA_LGKP_AYAH;
						$art['NO_RW'] = $entry->NO_RW;
						$art['KEC_NAME'] = $entry->KEC_NAME;
						$art['JENIS_PKRJN'] = $entry->JENIS_PKRJN;
						$art['NO_RT'] = $entry->NO_RT;
						$art['NO_KEL'] = $entry->NO_KEL;
						$art['ALAMAT'] = $entry->ALAMAT;
						$art['NO_KEC'] = $entry->NO_KEC;
						$art['TMPT_LHR'] = $entry->TMPT_LHR;
						$art['PDDK_AKH'] = $entry->PDDK_AKH;
						$art['NO_PROP'] = $entry->NO_PROP;
						$art['STATUS_KAWIN'] = $entry->STATUS_KAWIN;
						$art['NAMA_LGKP_IBU'] = $entry->NAMA_LGKP_IBU;
						$art['PROP_NAME'] = $entry->PROP_NAME;
						$art['NO_KAB'] = $entry->NO_KAB;
						$art['KEL_NAME'] = $entry->KEL_NAME;
						$art['JENIS_KLMIN'] = $entry->JENIS_KLMIN;
						$art['TGL_LHR'] = $entry->TGL_LHR;
						$id['NIK'] = $entry->NIK;
						$data2 = $this->auth_model->getSelectedData("dbo.HITNIK", $id);
						if($data2->num_rows() == 0) {
							$this->db->query("EXEC dbo.sp_insert_hitnik ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $art);
							//$this->auth_model->insertData("dbo.HITNIK", $art);
						} 
						$list_art[] = array(
							'data' => $entry
						);
						$nama_capil = str_replace("'","",$entry->NAMA_LGKP);
						$nama_capil2 = str_replace('"','',$nama_capil);
						$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$nama_capil2);
						$nilai = $nilai_padan * 100;
						if($nilai>=60)
						{
							$mdd['stereotype'] = 'Q2';
							//$this->db->set('stereotype', 'MK');
							$status = 'Q2';
							$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
						}
						else
						{
							if(strpos($nama_capil2, '/') !== false){
								$str = explode("/",$nama_capil2);
								$MAX_VALUE=0;
								for ($i = 0; $i < count($str); $i++)  {
									$nilai_padan = $this->cek_padan(strtoupper($nama_art2),$str[$i]);
									$nilai = $nilai_padan * 100;
									if($nilai > $MAX_VALUE){
										$MAX_VALUE=$nilai;
									}
								}
								if($MAX_VALUE>=60)
								{
									$mdd['stereotype'] = 'Q2';
									//$this->db->set('stereotype', 'MK');
									$status = 'Q2';
									$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								else
								{
									$mdd['stereotype'] = 'Q1a';
									//$this->db->set('stereotype', 'MKa');
									$status = 'Q1a';
									$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}	
							}
							elseif(strpos($nama_art2, '/') !== false){
								$str = explode("/",$nama_art2);
								$MAX_VALUE=0;
								for ($i = 0; $i < count($str); $i++)  {
									$nilai_padan = $this->cek_padan(strtoupper($str[$i]),$nama_capil2);
									$nilai = $nilai_padan * 100;
									if($nilai > $MAX_VALUE){
										$MAX_VALUE=$nilai;
									}
								}
								if($MAX_VALUE>=60)
								{
									$mdd['stereotype'] = 'Q2';
									//$this->db->set('stereotype', 'MK');
									$status = 'Q2';
									$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								else
								{
									$mdd['stereotype'] = 'Q1a';
									//$this->db->set('stereotype', 'MKa');
									$status = 'Q1a';
									$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
								}
								
							}
							else
							{
								$mdd['stereotype'] = 'Q1a';
								//$this->db->set('stereotype', 'MKa');
								$status = 'Q1a';
								$desc = "Dipadankan Ulang - Data ART Nama " . $nama_art2 . " NIK " . $nik . " TIDAK PADAN dengan  " . $nama_capil2 . " NIK " . $entry->NIK . " nilai " . $nilai . "" ;
						
							}

						}
						$cek_api = 1;
					}
					elseif($entry->RESPON == 'Data Tidak Ditemukan')
					{
						$mdd['stereotype'] = 'Q1a';
						//$this->db->set('stereotype', 'MKa');
						$status = 'Q1a';
						$desc = "Data ART NIK" . $nik . " TIDAK PADAN, Data Tidak Ditemukan";
						$cek_api = 1;
					}
					else
					{
						$cek_api = 0;
					}
				}
				
			}
			else
			{
				$cek_api = 0;
			}
			if($cek_api == 1)
			{
				$mdd['jumlah_hit'] = $jumlah_hit + 1;
				$mdd['id'] = $idart;
				$this->db->query("EXEC dbo.sp_update_mdd_pemadanan ?, ?, ?", $mdd);
				// $this->db->set('jumlah_hit', $jumlah_hit + 1);
				// $this->db->where('IDARTBDT', $idartbdt);
				// $this->db->update('dbo.master_data_detail');
				$dl_art['created_by'] = 0;
				$dl_art['detail_id'] = $idart;
				$dl_art['status'] = 'sukses';
				$dl_art['stereotype'] = $status;
				$dl_art['description'] = $desc;
				$dl_art['created_on'] = date("Y-m-d H:i:s");
				$this->db->query("EXEC dbo.sp_insert_master_detail_log ?, ?, ?, ?, ?, ?", $dl_art);
			}
			//$this->auth_model->insertData("dbo.master_detail_log", $dl_art);
		}
		//print_r(json_encode($list_art));
		
		
	}

	public function coba2_post()
	{
		$url     = "http://siksnik.kemsos.net/api/clidata/ceknik" ;
		
		// $idx['stereotype'] = null;
		// $idx['nik'] = '';
		$idx = array(
			'stereotype'          => null,
			'nik IS NOT NULL'       => null
		);
		$sqln = "
			SELECT top 1000 * FROM master_data_detail
			WHERE stereotype is null and nik is not null
		";
		// $get_data = $this->db->query($sqln);
		// foreach ($get_data->result() as $db) {
			$nik = '1404042810770006';
			$nama = 'rudyy';
			// $idartbdt = $db->IDARTBDT;
			// $jumlah_hit = $db->jumlah_hit;
			$data = ['NIK'=>$nik , 'token'=>'IoRJ0FnMdB5Bckhj0emY5jvbgCfm15PQZXWZs3Riml'];
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			$output2 = json_decode($output);
			if(!empty($output2->content))
			{
				foreach ($output2->content as $entry) {
					if(empty($entry->RESPON))
					{
						
						$art['NO_KK'] = $entry->NO_KK;
						$art['DUSUN'] = $entry->DUSUN;
						$art['NIK'] = $entry->NIK;
						$art['NAMA_LGKP'] = $entry->NAMA_LGKP;
						$art['STAT_HBKEL'] = $entry->STAT_HBKEL;
						$art['KAB_NAME'] = $entry->KAB_NAME;
						$art['NAMA_LGKP_AYAH'] = $entry->NAMA_LGKP_AYAH;
						$art['NO_RW'] = $entry->NO_RW;
						$art['KEC_NAME'] = $entry->KEC_NAME;
						$art['JENIS_PKRJN'] = $entry->JENIS_PKRJN;
						$art['NO_KEL'] = $entry->NO_KEL;
						$art['ALAMAT'] = $entry->ALAMAT;
						$art['NO_KEC'] = $entry->NO_KEC;
						$art['TMPT_LHR'] = $entry->TMPT_LHR;
						$art['PDDK_AKH'] = $entry->PDDK_AKH;
						$art['NO_PROP'] = $entry->NO_PROP;
						$art['STATUS_KAWIN'] = $entry->STATUS_KAWIN;
						$art['NAMA_LGKP_IBU'] = $entry->NAMA_LGKP_IBU;
						$art['PROP_NAME'] = $entry->PROP_NAME;
						$art['NO_KAB'] = $entry->NO_KAB;
						$art['KEL_NAME'] = $entry->KEL_NAME;
						$art['JENIS_KLMIN'] = $entry->JENIS_KLMIN;
						$art['TGL_LHR'] = $entry->TGL_LHR;
						//$this->auth_model->insertData("dbo.HITNIK", $art);
						$nilai_padan = $this->cek_padan(strtoupper($nama),$entry->NAMA_LGKP);
						$nilai = $nilai_padan * 100;
						if($nilai>=60)
						{
							$this->db->set('stereotype', 'MK');
							$status = 'MK';
							$desc = "Data ART NIK" . $nilai . " PADAN " ;
						}
						else
						{
							$this->db->set('stereotype', 'MKa');
							$status = 'MKa';
							$desc = "Data ART NIK" . $nilai . " TIDAK PADAN ";
						}
						$list_art[] = array(
							'data' => $desc
						);
						// $this->db->set('stereotype', 'MK');
					}
					// else
					// {
					// 	$this->db->set('stereotype', 'MKa');
					// }
				}
				
			}
			// else
			// {
			// 	$this->db->set('stereotype', 'MKa');
			// }
			// $this->db->set('jumlah_hit', $jumlah_hit + 1);
			// $this->db->where('IDARTBDT', $idartbdt);
			// $this->db->update('dbo.master_data_detail');
		// }
		print_r(json_encode($list_art));
		// print_r($get_data->result_array());
		
		
	}
	public function cek_padan($param1,$param2)
	{
		$sqln = '
			DECLARE @dblSimil float
			EXEC dbo.spSimil "'.$param1.'", "'.$param2.'" , @dblSimil OUTPUT
			SELECT @dblSimil
		';
		$get_data = $this->db->query($sqln);
		$row = $get_data->row_array();
		return $row[''];
	}

	public function GetClientIP()
	{
		if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1')
			$ip = 'localhost';
		else
			$ip = $_SERVER['REMOTE_ADDR'];
		return ($ip);
	}

	function token_wa_post() {
        $data = ['username' => 'ronal' , 'password' => 'ronal123'];
        $ch   = curl_init();
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  
        curl_setopt($ch, CURLOPT_URL, "http://202.157.177.157/api/client/auth/login");          
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen(json_encode($data))
		));        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($ch);
        
        curl_close($ch);
        
        $result = json_decode($output, true);
		$token  = $result['_token_'];
		
		$upd_data = [
			'token' => $token
		];
        $update = $this->db->update('_token_wa', $upd_data);
        
        echo json_encode($update);           
    }
}
