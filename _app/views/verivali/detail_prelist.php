<link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<style>
    th { font-size: 13px; }
    td { font-size: 12px; }
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $title; ?></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Petugas Pengumpul Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Rumah Tangga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Profil Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab14" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Anggota Rumah Tangga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab15" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Log Activity</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Informasi Petugas Pengumpul Data -->
                    <div role="tabpanel" class="tab-pane active" aria-expanded="true" id="tab1" aria-labelledby="base-tab11">
                        <form class="form-bordered">
                            <?php 
                                $tanggal = $monitoring->tanggal_pelaksanaan;
                                $nama_petugas = $monitoring->user_profile_first_name . ' ' . $monitoring->user_profile_last_name;
                                $nomorhp = $monitoring->user_account_username;
                                $status_ruta = $monitoring->keberadaan_ruta;

                                if ($monitoring->keberadaan_ruta == 1) {
                                    $status_ruta = "Terkonfirmasi";
                                } else if ($monitoring->keberadaan_ruta == 2) {
                                    $status_ruta = "Tidak Terkonfirmasi";
                                }
                                
                            ?>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Prelist ID</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="id_prelist" value="<?php echo $monitoring->id_prelist;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-map"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Tanggal Pelaksanaan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="tanggal" value="<?php echo $tanggal;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama Petugas</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="petugas" value="<?php echo $nama_petugas;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nomor HP Petugas</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="nohp" value="<?php echo $nomorhp;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-flag"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="bordered-form-6">Status Hasil Pemeriksaan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="status_pemeriksaan" value="<?php echo $status_ruta;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-home"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row last mb-3">
                                <label class="col-md-3 label-control" for="bordered-form-6">Revoke Note</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="status_pemeriksaan" value="<?php echo $monitoring->revoke_note;?>" >
                                        <div class="form-control-position">
                                            <i class="ft ft-trending-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Informasi Rumah Tangga -->
                    <div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
                        <form class="form-bordered">                            
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama KRT</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="nama_krt" value="<?php echo $prelist_data->nama_krt;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama Provinsi</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="provinsi" value="<?php echo $prelist_data->province_name;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-map"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama Kabupaten</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="kabupaten" value="<?php echo $prelist_data->regency_name;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-flag"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama Kecamatan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="kecamatan" value="<?php echo $prelist_data->district_name;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-globe"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama Kelurahan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="kelurahan" value="<?php echo $prelist_data->village_name;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-map-pin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama SLS</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="sls" value="<?php echo $prelist_data->nama_sls;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-image"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">RW / RT</label>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">RW</span>
                                        </div>
                                        <input type="text" class="form-control" name="rw" value="<?php echo $prelist_data->rw;?>" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">RT</span>
                                        </div>
                                        <input type="text" class="form-control" name="rt" value="<?php echo $prelist_data->rt;?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row last mb-3">
                                <label class="col-md-3 label-control" for="bordered-form-6">Alamat KRT</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="alamat" value="<?php echo $prelist_data->alamat;?>" >
                                        <div class="form-control-position">
                                            <i class="ft-home"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Profile Keluarga -->
                    <div class="tab-pane" id="tab3" aria-labelledby="base-tab13">                    
                        <div class="card-body table-responsive">
                            <table class="table text-center m-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis Kartu Keluarga</th>
                                        <th>Nomor Kartu Keluarga</th>
                                        <th>NUK</th>
                                        <th>Foto Kartu Keluarga</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no=1;
                                    foreach($keluarga as $datakk) { 
                                        $jenis_kk = "";
                                        if($datakk['jenis_kk'] == 1) {$jenis_kk = "Baru";} else $jenis_kk = "Lama";
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $jenis_kk; ?></td>
                                        <td><?php echo $datakk['nokk']; ?></td>
                                        <td><?php echo $datakk['nuk']; ?></td>
                                        <td>
                                            <?php
                                                //$url = 'http://dev-mkdtks-mbl.cacah.net/';
                                                $url = 'https://api-mkdtks.kemensos.go.id/';
                                                $image = '<a href="'.$url.substr($datakk['internal_filename'], 2).'" target="_blank">
                                                            <img src="'.$url.substr($datakk['internal_filename'], 2).'" style="height:150px;width:150px">
                                                        </a>';
                                                echo $image;
                                            ?>
                                        </td>
                                        <td class="text-truncate">
                                            <a href="#" class="info p-0" data-toggle="modal" data-target="#modal_foto_kk">
                                                <i class="ft-search font-medium-3 mr-2"></i>
                                            </a>                                          
                                        </td>
                                    </tr>
                                <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php 
                                if ((in_array('root', $this->id['user_group']) == true && in_array('kemsos', $this->id['user_group']) == false && in_array('pimpinan', $this->id['user_group']) == false)) {
                            ?>
                                <button type="button" class="btn btn-social btn-outline-dropbox round" data-toggle="modal" data-target="#modal_tambah_kk"><i class="fa fa-dropbox"></i>Tambah KK Baru</button>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Profile Anggota Rumah Tangga -->
                    <div class="tab-pane" id="tab4" aria-labelledby="base-tab14">
                        <div class="card-body table-responsive" style="overflow-x: scroll;">
                            <table class="table text-center m-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Actions</th>                                                 
                                        <th>Nomor KK</th>                                        
                                        <th>NUK</th>
                                        <th>Stereotype</th> 
                                        <th>Edit Android</th> 
                                        <th>Nama Anggota</th>
                                        <th>Status ART</th>
                                        <th>NIK</th>                                        
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>                                        
                                        <th>Hub. Keluarga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no=1;
                                    foreach($art as $artdata) { 
                                    $gender = "--";
                                    $status_art = "--";
                                    $hubkel = "--";
                                    $kk = $artdata['nokk'];
                                    $tmplahir = $artdata['tempat_lahir'];
                                    $niks = $artdata['nik'];
                                    $editapp = '';

                                    if($kk == NULL) { $kk = "--"; }
                                    if($tmplahir == NULL) { $tmplahir = "--"; }
                                    if($niks == NULL) { $niks = "--"; }
                                    
                                    //gender
                                    if($artdata['jenis_kelamin'] == 1) {
                                        $gender = "Laki-laki";
                                    } else if($artdata['jenis_kelamin'] == 2) {
                                        $gender = "Perempuan";
                                    }

                                    //status-edit
                                    if($artdata['status_edit'] == 1) {
                                        $editapp = "Bisa Diedit";
                                    } else if($artdata['status_edit'] == 0) {
                                        $editapp = "Tidak Bisa Edit";
                                    }

                                    //status_art
                                    if($artdata['keberadaan_art'] == 1) {
                                        $status_art = "Terkonfirmasi";
                                    } else if($artdata['keberadaan_art'] == 2) {
                                        $status_art = "Tidak Terkonfirmasi";
                                    } else if($artdata['keberadaan_art'] == 3) {
                                        $status_art = "Ganda";
                                    } else if($artdata['keberadaan_art'] == 4) {
                                        $status_art = "Meninggal";
                                    } else if($artdata['keberadaan_art'] == 5) {
                                        $status_art = "Tidak Memiliki/Belum tercatat dalam dokumen kependudukan
                                        ";
                                    }

                                    //hubkel
                                    if($artdata['hubungan_kepkel'] == 1) {
                                        $hubkel = "Kepala Keluarga";
                                    } else if ($artdata['hubungan_kepkel'] == 2) {
                                        $hubkel = "Istri/Suami";
                                    } else if ($artdata['hubungan_kepkel'] == 3) {
                                        $hubkel = "Anak";
                                    } else if ($artdata['hubungan_kepkel'] == 4) {
                                        $hubkel = "Menantu";
                                    } else if ($artdata['hubungan_kepkel'] == 5) {
                                        $hubkel = "Cucu";
                                    } else if ($artdata['hubungan_kepkel'] == 6) {
                                        $hubkel = "Orang Tua/Mertua";
                                    } else if ($artdata['hubungan_kepkel'] == 7) {
                                        $hubkel = "Pembantu Rumah Tangga";
                                    } else if ($artdata['hubungan_kepkel'] == 8) {
                                        $hubkel = "Lainnya";
                                    }

                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>                                        
                                        <td class="text-truncate">
                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">                                               
                                                <?php 
                                                    if ((in_array('root', $this->id['user_group']) == true && in_array('kemsos', $this->id['user_group']) == false && in_array('pimpinan', $this->id['user_group']) == false) || in_array('admin-junior', $this->id['user_group']) == true || in_array('korkab', $this->id['user_group']) == true || in_array('q-c', $this->id['user_group']) == true) {
                                                ?>
                                                    <?php if ($artdata['stereotype'] == 'MK' || $artdata['stereotype'] == 'MKa' || $artdata['stereotype'] == 'MKb') { ?> 
                                                    <a 
                                                        href="<?php echo base_url( 'korkab/qc_art/act_approve_per_art/' . enc( ['id' => $artdata['id']] ) )?>"
                                                        class="btn btn-success bg-light-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin APPROVE data ini?')" >
                                                        <i class="ft ft-trending-up"></i> Approve
                                                    </a>   
                                                    <?php } ?> 
                                                    <?php if ($artdata['stereotype'] == 'MK' || $artdata['stereotype'] == 'MKa') { ?>                                   
                                                    <a 
                                                        href="javascript:;"
                                                        data-id="<?php echo $artdata['id'] ?>"
                                                        data-proses_id="<?php echo $artdata['proses_id'] ?>"
                                                        data-nama_art="<?php echo $artdata['nama_art'] ?>"
                                                        data-nik="<?php echo $artdata['nik'] ?>"
                                                        data-keberadaan_art="<?php echo $artdata['keberadaan_art'] ?>"
                                                        data-jenis_kelamin="<?php echo $artdata['jenis_kelamin'] ?>"
                                                        data-tempat_lahir="<?php echo $artdata['tempat_lahir'] ?>"
                                                        data-tanggal_lahir="<?php echo $artdata['tanggal_lahir'] ?>"
                                                        data-hubungan_kepkel="<?php echo $artdata['hubungan_kepkel'] ?>"
                                                        data-stereotype="<?php echo $artdata['stereotype'] ?>"
                                                        data-toggle="modal" 
                                                        data-target="#edit-data"
                                                        class="btn btn-danger bg-light-danger btn-sm">
                                                        <i class="ft-edit-2"></i> Edit
                                                    </a>    
                                                    <?php } ?>                                   
                                                <?php } ?>
                                                <a 
                                                    href="<?php echo base_url( 'monitoring/detail_data/get_form_detail_art/' . enc( ['id' => $artdata['id']] ) )?>" 
                                                    class="btn btn-info bg-light-info btn-sm">
                                                    <i class="ft-search"></i> Detail Log
                                                </a>
                                            </div>
                                        </td>
                                        
                                            <?php
                                                // if($artdata['internal_filename'] != NULL) {
                                                //     $url = 'http://dev-mkdtks-mbl.cacah.net/';
                                                //     $url = 'https://api-mkdtks.kemensos.go.id/';
                                                //     $image = '<a href="'.$url.substr($artdata['internal_filename'], 2).'" target="_blank">
                                                //                 <img src="'.$url.substr($artdata['internal_filename'], 2).'" style="height:100px;width:100px">
                                                //             </a>';
                                                //     echo $image;
                                                // } else {
                                                //     echo '<img src="'.base_url('assets/no-image.png').'" style="height:80px;width:80px">';
                                                // }
                                                
                                            ?>
                                                                              
                                        <td><?php echo $kk; ?></td>                                                                              
                                        <td><?php echo $artdata['nuk']; ?></td>   
                                        <td>
                                            <span class="' . <?php echo $artdata['css']; ?> . '">
                                                <?php echo $artdata['stereotype']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $editapp; ?></td>
                                        <td><?php echo $artdata['nama_art']; ?></td>
                                        <td><?php echo $status_art; ?></td>
                                        <td><?php echo $niks; ?></td>                                                                             
                                        <td><?php echo $gender; ?></td>
                                        <td><?php echo $tmplahir; ?></td>
                                        <td><?php echo $artdata['tanggal_lahir']; ?></td>
                                        <td><?php echo $hubkel; ?></td>                                    
                                    </tr>
                                <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Log Activity -->
                     <div class="tab-pane" id="tab5" aria-labelledby="base-tab15">
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr>
									<th>Action</th>
									<th>By</th>
									<th>From</th>
									<th>On</th>
									<th>Stereotype</th>
									<th>Remark</th>
								</tr>
							</thead>
							<tbody>
								<?php
								function date_compare($element1, $element2) {
									$datetime1 = strtotime($element1['on']);
									$datetime2 = strtotime($element2['on']);
									return $datetime1 - $datetime2;
								}
								// Sort the array
								$audit_trail = json_decode( $prelist_data->audit_trails, true );
								usort($audit_trail, 'date_compare');
								if ( $audit_trail ) {
									foreach ( $audit_trail as $key => $value) {
										$on = date("d-m-Y H:i:s",strtotime($value['on']));
										echo '
											<tr>
												<td>' . $value['act'] . '</td>
												<td>' . $value['username'] . ' ( ' . $value['user_id'] . ' )</td>
												<td>' . $value['ip'] . '</td>
												<td>' . $on . '</td>
												<td>' . $value['column_data']['stereotype'] . '</td>
												<td>' . $on . '</td>
											</tr>
										';
									}
								}
								?>
							</tbody>
						</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal-Detail-KK -->
<div class="modal fade text-left" id="modal_tambah_kk" tabindex="-1" role="dialog" aria-labelledby="tambah_kk_mod" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title" id="tambah_kk_mod">Tambah Kartu Keluarga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url('monitoring/kartu_keluarga/tambah'); ?>">
                <div class="modal-body">
                    <div class="modal-body">
                        <fieldset class="form-group">
                            <label for="user_full_name">Nomor Kartu Keluarga</label>
                            <input type="hidden" name="proses_id" value="<?php echo $prelist_data->proses_id?>"/>
                            <input minlength="20" class="form-control" maxlength="20" pattern=".{20,20}" title="Wajib 20 digit." id="nik" name="nokk" required >
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="user_nik">Nomor Urut</label>
                            <input minlength="1" class="form-control" maxlength="2" pattern=".{1,2}" title="Wajib diisi." id="nik" name="nuk" required >
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="user_email">Jenis KK</label>
                            <select style="width:100%" name="jenis_kk" class="select2 form-control" required >
                                <option value="">Pilih Jenis</option>
                                <option value="2">KK Lama</option>
                                <option value="1">KK Baru</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal-Detail-KK -->
<div class="modal fade text-left" id="modal_foto_kk" tabindex="-1" role="dialog" aria-labelledby="foto_kk_mod" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="foto_kk_mod">Detail Foto Kartu Keluarga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url('config/user/simpan_user_baru'); ?>">
                <div class="modal-body">
                    <div class="card-body table-responsive">
                        <table class="table text-center m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto KK</th>
                                    <th>Jenis KK</th>
                                    <th>Nomor KK</th>                                    
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>IP User</th>
                                    <th>Row_status</th>
                                    <th>By</th>
                                    <th>On</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no=1;
                                foreach($fotokk as $datakkd) { 
                                    $jenis_kkd = "";
                                    if($datakkd['jenis_kk'] == 1) {$jenis_kkd = "Baru";} else $jenis_kkd = "Lama";
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td>
                                        <?php
                                            $image = '<a href="'.$url.substr($datakkd['internal_filename'], 2).'" target="_blank">
                                                        <img src="'.$url.substr($datakkd['internal_filename'], 2).'" style="height:150px;width:150px">
                                                    </a>';
                                            echo $image;
                                        ?>
                                    </td>
                                    <td><?php echo $jenis_kkd; ?></td>
                                    <td><?php echo $datakkd['nokk']; ?></td>
                                    <td><?php echo $datakkd['latitude']; ?></td>
                                    <td><?php echo $datakkd['longitude']; ?></td>
                                    <td><?php echo $datakkd['ip_user']; ?></td>
                                    <td><?php echo $datakkd['row_status']; ?></td>
                                    <td><?php echo $datakkd['created_by']; ?></td>
                                    <td><?php echo $datakkd['created_on']; ?></td>
                                    
                                </tr>
                            <?php $no++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Detail -->
<div class="modal fade text-left" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="edit_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="edit_detail">Edit Anggota Rumah Tangga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form action="<?php echo base_url('monitoring/detail_data/edit_art')?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="card-body row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-12 control-label">Nama ART</label>
                                <div class="col-lg-10">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="proses_id" name="proses_id">
                                    <input type="text" class="form-control" id="nama_art" name="nama_art" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">NIK</label>
                                <div class="col-lg-10">
                                    <input minlength="16" class="form-control niks" maxlength="16" pattern=".{16,16}" title="Wajib 16 digit." id="nik" name="nik" placeholder="331121..." required >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">Status ART</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="keberadaan_art" name="keberadaan_art" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">Gender</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="col-12 control-label">Tempat Lahir</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">Tanggal Lahir</label>
                                <div class="col-lg-10">
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">Hubungan Keluarga</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="hubungan_kepkel" name="hubungan_kepkel" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-12 control-label">Stereotype</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="stereotype" name="stereotype" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info" type="submit"> Simpan&nbsp;</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Untuk sunting
        $('#edit-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) 
            var modal = $(this)
            var gender = '';
            var status_artv = '';
            var hub_kelv = '';

            //gender
            if (div.data('jenis_kelamin') == 1) {
                gender = "Laki-laki";
            } else if (div.data('jenis_kelamin') == 2) {
                gender = "Perempuan";
            }   

            //status_art
            if (div.data('keberadaan_art') == 1) {
                status_artv = "Terkonfirmasi";
            } else if(div.data('keberadaan_art') == 2) {
                status_artv = "Tidak Terkonfirmasi";
            } else if(div.data('keberadaan_art') == 3) {
                status_artv = "Ganda";
            } else if(div.data('keberadaan_art') == 4) {
                status_artv = "Meninggal";
            } else if(div.data('keberadaan_art') == 5) {
                status_artv = "Tidak Memiliki/Belum tercatat dalam dokumen kependudukan";
            }

            //hubkel
            if (div.data('hubungan_kepkel') == 1) {
                hub_kelv = "Kepala Keluarga";
            } else if (div.data('hubungan_kepkel') == 2) {
                hub_kelv = "Istri/Suami";
            } else if (div.data('hubungan_kepkel') == 3) {
                hub_kelv = "Anak";
            } else if (div.data('hubungan_kepkel') == 4) {
                hub_kelv = "Menantu";
            } else if (div.data('hubungan_kepkel') == 5) {
                hub_kelv = "Cucu";
            } else if (div.data('hubungan_kepkel') == 6) {
                hub_kelv = "Orang Tua/Mertua";
            } else if (div.data('hubungan_kepkel') == 7) {
                hub_kelv = "Pembantu Rumah Tangga";
            } else if (div.data('hubungan_kepkel') == 8) {
                hub_kelv = "Lainnya";
            }

            modal.find('#id').attr("value",div.data('id'));
            modal.find('#proses_id').attr("value",div.data('proses_id'));
            modal.find('#nama_art').attr("value",div.data('nama_art'));
            modal.find('.niks').attr("value",div.data('nik'));
            modal.find('#keberadaan_art').attr("value",status_artv);
            modal.find('#jenis_kelamin').attr("value",gender);
            modal.find('#tempat_lahir').attr("value",div.data('tempat_lahir'));
            modal.find('#tanggal_lahir').attr("value",div.data('tanggal_lahir'));
            modal.find('#hubungan_kepkel').attr("value",hub_kelv);
            modal.find('#stereotype').attr("value",div.data('stereotype'));
        });
    });
</script>

<script type="text/javascript">
    $(document).ready( function(){
        $.noConflict();
        toasterOptions();
        response_edit_art();
        response_art_approve();
        response_kk_baru();

        // zero configuration
		$('.zero-configuration').DataTable( {
			"ordering": false
		});

        function response_edit_art() {
            if ('<?=$this->session->flashdata('tab')?>' == 'update_art') {
                $('#base-tab11').toggleClass('active');
                $('#tab1').toggleClass('active');
                $('#tab4').toggleClass('active');
                $('#base-tab14').toggleClass('active');
                if ('<?=$this->session->flashdata('status')?>' == '1') {
                    toastr.info('ART berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('ART gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

        function response_art_approve() {
            if ('<?=$this->session->flashdata('tab')?>' == 'approve_art') {
                $('#base-tab11').toggleClass('active');
                $('#tab1').toggleClass('active');
                $('#tab4').toggleClass('active');
                $('#base-tab14').toggleClass('active');
                if ('<?=$this->session->flashdata('status')?>' == '1') {
                    toastr.info('ART berhasil diapprove.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('ART gagal diapprove.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

        function response_kk_baru() {
            if ('<?=$this->session->flashdata('tab')?>' == 'kk') {
                $('#base-tab11').toggleClass('active');
                $('#tab1').toggleClass('active');
                $('#tab3').toggleClass('active');
                $('#base-tab13').toggleClass('active');
                if ('<?=$this->session->flashdata('status')?>' == '1') {
                    toastr.info('Kartu keluarga berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Kartu keluarga gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }
    })

    // Restricts input for the given textbox to the given inputFilter.
    function setInputFilter(textbox, inputFilter) {
        ["input"].forEach(function(event) {
            textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        });
    }

    // Install input filters.
    setInputFilter(document.getElementById("nik"), function(value) {
    return /^-?\d*$/.test(value); });
    
</script>

 