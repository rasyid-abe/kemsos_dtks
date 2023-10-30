<link rel="stylesheet" type="text/css" href="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<?php $user_id =  $user_detail->user_profile_id;?>
<div class="row match-height">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?= $title ?></h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">User Data</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Group</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Locations</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab15" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Logs</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab16" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab19" data-toggle="tab" aria-controls="tab9" href="#tab9" aria-expanded="false">Pengalaman Kerja</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab17" data-toggle="tab" aria-controls="tab7" href="#tab7" aria-expanded="false">Account</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab18" data-toggle="tab" aria-controls="tab8" href="#tab8" aria-expanded="false">Device</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab11">
							<input type="hidden" name="user_id" id="user_id_ud" value="<?= $user_detail->user_account_id;?>">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="username">Username</label>
										<div class="controls">
											<input type="text" id="username_ud" class="form-control" value="<?= $user_detail->user_account_username;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="name">Name</label>
										<div class="controls">
											<input type="text" id="name_ud" class="form-control" placeholder="Name" value="<?= $user_detail->user_profile_first_name;?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="password">Password</label>
										<div class="controls">
											<input name="user_password" id="kata_sandi_ud" type="password" class="form-control" value="<?= $this->encryption->decrypt($user_detail->user_account_password); ?>" required />
										</div>
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="email">E-mail</label>
										<div class="controls">
											<input type="text" id="email_ud" class="form-control" placeholder="E-mail" value="<?= $user_detail->user_account_email;?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="last_login_from">Last Login From</label>
										<div class="controls">
											<input type="text" class="form-control" value="<?= ( ( $user_detail->user_account_last_login_ip == '' ) ? 'Never Login' : $user_detail->user_account_last_login_ip ) ;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="last_login_on">Last Login On</label>
										<div class="controls">
											<input type="text" class="form-control" value="<?= ( ( $user_detail->user_account_last_login_datetime == '' ) ? 'Never Login' : date("d-m-Y H:i:s",strtotime($user_detail->user_account_last_login_datetime)) ) ;?>" readonly>
										</div>
									</div>
								</div>
								<div class="col-12 text-right">
									<?php
										if (in_array('root', $this->id['user_group']) == true || in_array('admin-junior', $this->id['user_group']) == true) {
									?>
									<button type="button" class="btn btn-secondary mr-sm-2 mb-1" data-toggle="modal" data-target="#modalFormRestore">Get Code DB</button>
									<?php } ?>
									<button type="button" id="save_account" class="btn btn-primary mr-sm-2 mb-1">Simpan Perubahan</button>
								</div>
							</div>
							<hr class="mt-1 mt-sm-2">
						</div>

						<div class="tab-pane show_tab_2" id="tab2" aria-labelledby="base-tab12">
							<div class="row">
								<div class="col-md-5">
									<div style="overflow: scroll; height:500px"><?= $user_group;?></div>
								</div>
								<div class="col-md-7">
									<table class="table table-sm table-striped table-bordered" width=100% id="dt-table-group">
										<thead>
											<tr>
												<th>Group ID</th>
												<th>Group Title</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab3" aria-labelledby="base-tab13">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-md-5 f-10">
											<div style="overflow: scroll; height:500px">
												<div class="my_treeview" id="my_treeview"></div>
											</div>
										</div>
										<div class="col-md-7">
											<table class="table table-sm table-striped table-bordered" width=100% id="dt-table-location">
												<thead>
													<tr>
														<th>Location ID</th>
														<th>Location Name</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab5" aria-labelledby="base-tab15">
							<style>
								th { font-size: 12px; }
								td { font-size: 11px; }
							</style>
							<div class="table-responsive">
								<table class="table table-striped zero-configuration">
									<thead>
										<tr>
											<th>#</th>
											<th>Created By</th>
											<th>Created On</th>
											<th>ID Prelist</th>
											<th>Stereotype</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$no=1;
										foreach($user_log as $logs) {
											$on = date("d-m-Y H:i:s",strtotime($logs['created_on']));
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $logs['created_by']; ?></td>
											<td><?php echo $on; ?> WIB</td>
											<td><?php echo $logs['prelist_id']; ?></td>
											<td><?php echo $logs['stereotype']; ?></td>
											<td><?php echo $logs['description']; ?></td>
										</tr>
									<?php $no++; } ?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="tab-pane grid-hover" id="tab6" aria-labelledby="base-tab16">
							<div class="tab-pane fade mt-2 show active" id="account" role="tabpanel" aria-labelledby="account-tab">
							<!-- Account form starts -->
							<form novalidate action="<?= base_url('config/user/edit_profile')?>" method="POST" enctype="multipart/form-data" >
								<div class="row">
									<?php
									$filename_pf = '';
									$filename_ktp = '';
									$filename_iz = '';
									$urlapi = "https://api-mkdtks.kemensos.go.id/";
									if(empty($pf->internal_filename) && empty($ktp->internal_filename) && empty($ijazah->internal_filename)) {
										$urlapi = base_url('assets/no-image.png');
									} else {
										$filename_pf = $pf->internal_filename;
										$filename_ktp = $ktp->internal_filename;
										$filename_iz = $ijazah->internal_filename;
									}
									$foto1 = $urlapi . ( ( ! empty( $urlapi ) ) ? $filename_pf : '' );
									$foto2 = $urlapi . ( ( ! empty( $urlapi ) ) ? $filename_ktp : '' );
									$foto3 = $urlapi . ( ( ! empty( $urlapi ) ) ? $filename_iz : '' );

									?>
									<div class="col-sm-4">
										<div class="media">
											<a href="<?= $foto1; ?>" target="_blank">
												<img src="<?= $foto1; ?>" alt="profile-img" class="rounded mr-3" height="100" width="100">
											</a>
											<div class="media-body">
												<div class="col-12 d-flex flex-sm-row flex-column justify-content-start px-0 mb-sm-2">
													<label class="btn btn-sm bg-light-primary mb-sm-0" for="select-files1">Foto Profil</label>
													<input type="file" disabled name="user_profile_image" id="select-files1" hidden>
													<input type="hidden" name="old_image1" value="<?= $user_profile->user_profile_image ?>">
												</div>
												<p class="text-muted mb-0 mt-1 mt-sm-0">
													<small>Allowed JPG or PNG. Max size of 1 MB</small>
												</p>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="media">
											<a href="<?= $foto2; ?>" target="_blank">
												<img src="<?= $foto2; ?>" alt="profile-img" class="rounded mr-3" height="100" width="100">
											</a>
											<div class="media-body">
												<div class="col-12 d-flex flex-sm-row flex-column justify-content-start px-0 mb-sm-2">
													<label class="btn btn-sm bg-light-primary mb-sm-0" for="select-files2">Foto KTP</label>
													<input type="file" disabled name="user_profile_foto_ktp" id="select-files2" hidden>
													<input type="hidden" name="old_image2" value="<?= $user_profile->user_profile_foto_ktp ?>">
												</div>
												<p class="text-muted mb-0 mt-1 mt-sm-0">
													<small>Allowed JPG or PNG. Max size of 1 MB</small>
												</p>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="media">
											<a href="<?= $foto3; ?>" target="_blank">
												<img src="<?= $foto3; ?>" alt="profile-img" class="rounded mr-3" height="100" width="100">
											</a>
											<div class="media-body">
												<div class="col-12 d-flex flex-sm-row flex-column justify-content-start px-0 mb-sm-2">
													<label class="btn btn-sm bg-light-primary mb-sm-0" for="select-files">Foto Ijazah</label>
													<input type="file" disabled name="user_profile_foto_ijazah" id="select-files" hidden>
													<input type="hidden" name="old_image3" value="<?= $user_profile->user_profile_foto_ijazah ?>">
												</div>
												<p class="text-muted mb-0 mt-1 mt-sm-0">
													<small>Allowed JPG or PNG. Max size of 1 MB</small>
												</p>
											</div>
										</div>
									</div>

									<div class="col-12 col-md-6">
										<input type="hidden" class="form-control" name="user_profile_id" value="<?= 	$user_profile->user_profile_id;?>" >
										<div class="form-group">
											<div class="controls">
												<label>Nama Lengkap</label>
												<input type="text" name="user_profile_first_name" class="form-control" value="<?= $user_profile->user_profile_first_name;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>NIK</label>
												<input type="text" name="user_profile_nik" class="form-control" value="<?= $user_profile->user_profile_nik;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Tempat Lahir</label>
												<input type="text" name="user_profile_born_place" class="form-control" value="<?= $user_profile->user_profile_born_place;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Tanggal Lahir</label>
												<input type="date" name="user_profile_born_date" class="form-control" value="<?= $user_profile->user_profile_born_date;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Agama</label>
												<select class="form-control" name="user_profile_agama">
													<option disabled>Pilih</option>
													<option value="1" <?= ( ( $user_profile->user_profile_agama == '1' ) ? 'selected' : '' ) ;?>>Islam</option>
													<option value="2" <?= ( ( $user_profile->user_profile_agama == '2' ) ? 'selected' : '' ) ;?>>Protestan</option>
													<option value="3" <?= ( ( $user_profile->user_profile_agama == '3' ) ? 'selected' : '' ) ;?>>Katolik</option>
													<option value="4" <?= ( ( $user_profile->user_profile_agama == '4' ) ? 'selected' : '' ) ;?>>Hindu</option>
													<option value="5" <?= ( ( $user_profile->user_profile_agama == '5' ) ? 'selected' : '' ) ;?>>Buddha</option>
													<option value="6" <?= ( ( $user_profile->user_profile_agama == '6' ) ? 'selected' : '' ) ;?>>Khonghucu</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Jenis Kelamin</label>
												<select class="form-control" name="user_profile_gender">
													<option disabled>Pilih</option>
													<option value="1" <?= ( ( $user_profile->user_profile_gender == '1' ) ? 'selected' : '' ) ;?>>Laki - laki</option>
													<option value="2" <?= ( ( $user_profile->user_profile_gender == '2' ) ? 'selected' : '' ) ;?>>Perempuan</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Status Pernikahan</label>
												<select class="form-control" name="user_profile_status_nikah">
													<option disabled>Pilih</option>
													<option value="1" <?= ( ( $user_profile->user_profile_status_nikah == '1' ) ? 'selected' : '' ) ;?>>Belum Menikah</option>
													<option value="2" <?= ( ( $user_profile->user_profile_status_nikah == '2' ) ? 'selected' : '' ) ;?>>Menikah</option>
													<option value="3" <?= ( ( $user_profile->user_profile_status_nikah == '3' ) ? 'selected' : '' ) ;?>>Cerai Hidup</option>
													<option value="4" <?= ( ( $user_profile->user_profile_status_nikah == '4' ) ? 'selected' : '' ) ;?>>Cerai Mati</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Alamat</label>
												<input type="text" name="user_profile_address" class="form-control" value="<?= $user_profile->user_profile_address;?>" >
											</div>
										</div>
									</div>

									<div class="col-12 col-md-6">

										<div class="form-group">
											<div class="controls">
												<label>Nomor HP Alternatif</label>
												<input type="text" name="user_profile_no_hp" class="form-control" value="<?= $user_profile->user_profile_no_hp;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Email Aktif</label>
												<input type="text" name="user_profile_email_alternatif" class="form-control" value="<?= $user_profile->user_profile_email_alternatif;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Pendidikan Terakhir</label>
												<select class="form-control" name="user_profile_pendidikan_terakhir">
													<option disabled>Pilih</option>
													<option value="1" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '1' ) ? 'selected' : '' ) ;?>>SD/SDLB</option>
													<option value="2" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '2' ) ? 'selected' : '' ) ;?>>PAKET A</option>
													<option value="3" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '3' ) ? 'selected' : '' ) ;?>>M. IBTIDAIYAH</option>
													<option value="4" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '4' ) ? 'selected' : '' ) ;?>>SMP/SMPLB</option>
													<option value="5" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '5' ) ? 'selected' : '' ) ;?>>PAKET B</option>
													<option value="6" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '6' ) ? 'selected' : '' ) ;?>>M. TSANAWIYAH</option>
													<option value="7" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '7' ) ? 'selected' : '' ) ;?>>SMA/SMK/SMALB</option>
													<option value="8" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '8' ) ? 'selected' : '' ) ;?>>PAKET C</option>
													<option value="9" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '9' ) ? 'selected' : '' ) ;?>>M. ALIYAH</option>
													<option value="10" <?= ( ( $user_profile->user_profile_pendidikan_terakhir == '10' ) ? 'selected' : '' ) ;?>>PERGURUAN TINGGI</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Jurusan</label>
												<input type="text" name="user_profile_jurusan" class="form-control" value="<?= $user_profile->user_profile_jurusan;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Nama Institusi Pendidikan</label>
												<input type="text" name="user_profile_institusi_pendidikan" class="form-control" value="<?= $user_profile->user_profile_institusi_pendidikan;?>" >
											</div>
										</div>
										<div class="form-group">
											<div class="controls">
												<label>Tahun Lulus</label>
												<input type="text" name="user_profile_tahun_lulus" class="form-control" value="<?= $user_profile->user_profile_tahun_lulus;?>" >
											</div>
										</div>
									</div>

									<div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-3 mt-sm-2">
										<button type="submit" class="btn btn-primary mb-2 mb-sm-0 mr-sm-2" id="btn_form_profile">Simpan</button>
										<button type="reset" class="btn btn-secondary">Cancel</button>
									</div>
								</div>
							</form> <hr/>
							<!-- Account form ends -->
							</div>
						</div>

						<div class="tab-pane" id="tab9" aria-labelledby="base-tab19">
							<div class="table-responsive">
								<table class="table table-striped zero-configuration">
									<thead>
										<tr>
											<th>#</th>
											<th>Tahun Kerja</th>
											<th>Jabatan</th>
											<th>Nama Kegiatan</th>
											<th>Perusahaan</th>
											<th>Created On</th>
											<th>Hapus</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$no=1;
										foreach($user_kerja as $kerja) {
											$on = date("d-m-Y H:i:s",strtotime($kerja['created_on']));
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $kerja['tahun_kerja']; ?></td>
											<td><?php echo $kerja['jabatan']; ?></td>
											<td><?php echo $kerja['nama_kegiatan']; ?></td>
											<td><?php echo $kerja['perusahaan']; ?></td>
											<td><?php echo $on; ?> WIB</td>
											<td>
												<a
													href="<?php echo base_url('config/detail_user/hapus_pengalaman_kerja/' . $kerja['id']. '/'.$kerja['user_id'])?>"
													class="badge bg-light-danger" onclick="return confirm('Apakah Anda yakin ingin hapus data ini?')">Hapus
												</a>
											</td>
										</tr>
									<?php $no++; } ?>
									</tbody>
								</table>
								<button type="button" class="btn bg-light-secondary" data-toggle="modal" data-target="#border">Tambah Pengalaman</button>
								<!-- Modal tambah pengalaman kerja -->
								<div class="modal fade text-left" id="border" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<form method="POST" action="<?php echo base_url('config/user/simpan_pengalaman_kerja'); ?>">
											<div class="modal-header bg-secondary">
												<h4 class="modal-title" id="myModalLabel15"><i class="ft-bookmark mr-2"></i>Tambah Pengalaman Kerja</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
												</button>
											</div>
											<div class="modal-body">
												<input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
												<fieldset class="form-group">
													<label for="tahun_kerja">Tahun Kerja</label>
													<input minlength="4" class="form-control" maxlength="4" pattern=".{4,4}" title="Wajib tahun" id="tahun" name="tahun_kerja" required >
												</fieldset>
												<fieldset class="form-group">
													<label for="jabatan">Jabatan</label>
													<input type="text" class="form-control" name="jabatan" required />
												</fieldset>
												<fieldset class="form-group">
													<label for="nama_kegiatan">Nama Kegiatan</label>
													<input type="text" class="form-control" name="nama_kegiatan" required />
												</fieldset>
												<fieldset class="form-group">
													<label for="perusahaan">Perusahaan</label>
													<input type="text" class="form-control" name="perusahaan" required />
												</fieldset>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-secondary">Simpan</button>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab7" aria-labelledby="base-tab17">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div id="info-profile" class="col-md-12"></div>
									</div>
									<div class="row">
										<div class="col-md-12 form-group">
											<button id="copyToClipboard" type="button" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>&nbsp;Copy To Clipboard</button>
											<input id="clipboard" type="hidden" value="">
											<a href="<?php echo base_url('config/user/send_whatsapp/'). enc( [ 'user_id' => $user_detail->user_account_id ] );?>" type="button" class="btn btn-sm btn-success"><i class="fa fa-whatsapp"></i>&nbsp;Send WhatsApp</a>
											<?php
												if (in_array('root', $this->id['user_group']) == true || in_array('admin-junior', $this->id['user_group']) == true || in_array('p-i-c', $this->id['user_group']) == true) {
											?>
											<a href="<?php echo base_url('config/user/act_reset_android_id/').$user_id?>" class="btn btn-sm btn-warning" title="Reset Android ID" <?php echo ( ( empty( $user_detail->user_profile_android_id ) ) ? 'disabled' : null );?>><i class="ft-refresh-cw"></i> Reset Android ID</a>
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 form-group">
											<textarea id="account_information" class="form-control form-control-sm" readonly style="height: 300px;font-family: Consolas !important;"><?php
							$url = base_url();
	echo "*Informasi Account untuk akses APP MK-DTKS*

*Nama:* {$user_detail->user_profile_first_name}
*NIK:* {$user_detail->user_profile_nik}
*No. HP:* {$user_detail->user_profile_no_hp}
*Email Pribadi:* {$user_detail->user_account_email}

Username: {$user_detail->user_account_username}
Password: {$this->encryption->decrypt( $user_detail->user_account_password )}
Android ID: {$user_detail->user_profile_android_id}

*APP MK-DTKS* bisa diunduh di {$url}download/mkdtks.apk";
							?>
						</textarea>
					</div>
				</div>
			</div>
		</div>
						</div>
						<div class="tab-pane" id="tab8" aria-labelledby="base-tab18">
							<div class="row">
								<div class="col-md-12 form-group">
									<button id="copyToClipboard2" type="button" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>&nbsp;Copy To Clipboard</button>
									<input id="clipboard" type="hidden" value="">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 form-group">
									<textarea id="account_information2" class="form-control form-control-sm" readonly style="height: 300px;font-family: Consolas !important;">
<?php
$description = "No data.";
if ( !empty( $user_device->user_desciption ) ) {
	$description =
	$user_device->user_desciption;
}
echo $description;

?>
									</textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal get code db -->
<div class="modal fade text-left" id="modalFormRestore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="modalContentRestore">
			<div class="modal-header bg-secondary">
				<h5 class="modal-title" id="contohModalScrollableTitle">Restore DB Code</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group row align-items-center">
							<div class="col-lg-5 col-12">
								<label class="col-sm-12 col-form-label-sm">Challange Code:</label>
							</div>
							<div class="col-lg-7 col-12">
								<input type="text" id="challange_code" minlength="8" maxlength="8" pattern=".{8,8}" class="form-control form-control-sm"  >
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group row align-items-center">
							<div class="col-lg-5 col-12">
								<label class="col-sm-12 col-form-label-sm">Restore Code:</label>
							</div>
							<div class="col-lg-7 col-12">
								<input type="text" id="restore_code" class="form-control form-control-sm" >
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary bg-light-secondary submit">Get Code</button>
			</div>
			<script type="text/javascript">
				$(document).ready(function() {
				$(".submit").click(function(event) {
					event.preventDefault();
					var challange_code = $("#challange_code").val();

						if(challange_code.length!=8)
						{
							alert("Challange code harus 8 karakter.");
							return false;
						}
						jQuery.ajax({
							type: "POST",
							url:"<?php echo base_url( 'config/user' ); ?>/restore_db",
							dataType: 'json',
							data: {challange: challange_code},
							success: function(res) {
								$("#restore_code").val(res.hasil);
							}
						});
					});
				});
			</script>
		</div>
	</div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	$(document).ready( function(){
		$.noConflict();
		toasterOptions();
		get_data_treeview();
		response_edit_profile();
		response_wa();
		response_reset_id();
		response_kerja();
		response_kerja_hapus();

		// zero configuration
		$('.zero-configuration').DataTable( {
			"ordering": false
		});

		function response_edit_profile() {
			if ('<?=$this->session->flashdata('tab')?>' == 'profile') {
				$('#base-tab11').toggleClass('active');
				$('#tab1').toggleClass('active');
				$('#tab6').toggleClass('active');
				$('#base-tab16').toggleClass('active');
				if ('<?=$this->session->flashdata('status')?>' == '1') {
					toastr.info('Profil berhasi diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Profil gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_wa() {
			if ('<?=$this->session->flashdata('tab')?>' == 'wa') {
				$('#base-tab11').toggleClass('active');
				$('#tab1').toggleClass('active');
				$('#tab7').toggleClass('active');
				$('#base-tab17').toggleClass('active');
				if ('<?=$this->session->flashdata('status')?>' == '1') {
					toastr.info('Akun berhasil dikirim.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Akun gagal dikirim.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_reset_id() {
			if ('<?=$this->session->flashdata('tab')?>' == 'reset_id') {
				$('#base-tab11').toggleClass('active');
				$('#tab1').toggleClass('active');
				$('#tab7').toggleClass('active');
				$('#base-tab17').toggleClass('active');
				if ('<?=$this->session->flashdata('status')?>' == '1') {
					toastr.info('Android ID berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Android ID gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_kerja() {
			if ('<?=$this->session->flashdata('tab')?>' == 'kerja') {
				$('#base-tab11').toggleClass('active');
				$('#tab1').toggleClass('active');
				$('#tab9').toggleClass('active');
				$('#base-tab19').toggleClass('active');
				if ('<?=$this->session->flashdata('status')?>' == '1') {
					toastr.info('Data berhail disimpan.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal disimpan.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_kerja_hapus() {
			if ('<?=$this->session->flashdata('tab')?>' == 'kerja_hapus') {
				$('#base-tab11').toggleClass('active');
				$('#tab1').toggleClass('active');
				$('#tab9').toggleClass('active');
				$('#base-tab19').toggleClass('active');
				if ('<?=$this->session->flashdata('status')?>' == '1') {
					toastr.info('Data berhail dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		// table user location
		var table_user_location = $('#dt-table-location').DataTable( {
			"lengthChange": false,
			"processing": true,
			"language": {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
				lengthMenu: "Tampilkan _MENU_ baris per halaman",
				zeroRecords: "Data tidak ditemukan",
				info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
				infoEmpty: "Tidak ada data yang ditampilkan ",
				paginate: {
					next: "<i class='ft ft-chevrons-right'></i>",
					previous: "<i class='ft ft-chevrons-left'></i>",
				},
				select: {
					rows : "%d baris dipilih"
				}
			},
			"serverSide": true,
			"order": [[1, "desc" ]],
			"ajax": {
				"url": "<?= base_url('config/detail_user/show_user_location') ?>",
				"type": "POST",
				"data": function(d){
					d.s_user_id = $('#user_id_ud').val();
				},
			},
			"scrollY": 435,
			'columnDefs': [
				{
					"targets": 0,
					"orderable": false
				}
			],
			'select': {
				'style': 'multi'
			},
			"searching": false,
			"lengthMenu": [[20, 300, 500, 1000], [20, 300, 500, 1000]],
		} );

		// generate treeview
		function get_data_treeview() {
			var elem = '';
			var user_id = $('#user_id_ud').val();
			$.ajax({
				url: "<?= base_url('config/detail_user/get_data_treeview') ?>",
				type: "POST",
				data: {user_id:user_id},
				dataType: "json",
				success : function(data) {
					var ex = data.exists;
					$.each(data.lokasi, function(i, v) {
						var name = '';
						if (v.level == 2) {
							name = v.province_name;
						} else if (v.level == 3) {
							name = v.regency_name;
						} else if (v.level == 4) {
							name = v.district_name;
						} else {
							name = v.village_name;
						}
						check = ex.includes(Number(v.location_id)) ? 'checked' : '';
						elem += `
						<i class="arrow_tree ft ft-chevron-right" data-id="${v.location_id}"></i>
						<input type="checkbox" id="${v.location_id}_id" class="ck_location" ${check} value="${v.location_id}">
						<label for="${v.location_id}_id"> ${name}</label>
						<div id="child_tree_${v.location_id}"></div>
						`;
					})
					$('#my_treeview').append(elem);
				},
			});
		}

		// child treeview
		$(document).on('click', '.arrow_tree', function(e) {
			$(this).toggleClass('ft-chevron-down ft-chevron-right');
			let parent = $(this).attr("data-id");
			var user_id = $('#user_id_ud').val();
			var elem = '';
			if ($(this).hasClass('ft-chevron-down')) {
				$.ajax({
					url: "<?= base_url('config/detail_user/get_data_treeview_child') ?>",
					type: "POST",
					data: {parent:parent, user_id:user_id},
					dataType: "json",
					success : function(data) {
						var ex = data.exists;
						$.each(data.lokasi, function(i, v) {
							var name = '';
							if (v.level == 2) {
								name = v.province_name;
							} else if (v.level == 3) {
								name = v.regency_name;
							} else if (v.level == 4) {
								name = v.district_name;
							} else {
								name = v.village_name;
							}

							check = ex.includes(Number(v.location_id)) ? 'checked' : '';
							elem += `
							<div style="padding-left: 18px;">
							<i class="arrow_tree ft ft-chevron-right" data-id="${v.location_id}"></i>
							<input type="checkbox" id="${v.location_id}_id" class="ck_location" ${check} value="${v.location_id}">
							<label for="${v.location_id}_id"> ${name}</label>
							<div id="child_tree_${v.location_id}"></div>
							</div>
							`;
						})
						$('#child_tree_' + parent).append(elem);
					},
				});
			} else if ($(this).hasClass('ft-chevron-right')) {
				$('#child_tree_' + parent).html('<div id="child_tree_'+parent+'"></div>');
			}
		});

		// action user location
		$(document).on('click', '.ck_location', function(e) {
			var location_id = $(this).val();
			var user_id = $('#user_id_ud').val();
			$.ajax({
				url: "<?= base_url('config/detail_user/act_location_user') ?>",
				type: "POST",
				data: {
					user_id:user_id,
					location_id:location_id,
				},
				dataType: "json",
				success : function(data) {
					if (data.status) {
						toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Success!');
					} else {
						toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
					}
					refresh_table_user_location();
				},
			});
		});

		function refresh_table_user_location(){
			table_user_location.ajax.reload();
		}

		$('#base-tab13').click(function() {
			refresh_table_user_location();
		})

		// tab 1 - edit user account
		$('#save_account').click(function() {
			var name = $('input#name_ud').val();
			var pass = $('input#kata_sandi_ud').val();
			var mail = $('input#email_ud').val();
			var idus = $('input#user_id_ud').val()

			if (name == '') {
				toastr.error('Form Nama harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
			}
			if (pass == '') {
				toastr.error('Form Password harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
			}
			if (mail == '') {
				toastr.error('Form E-Mail harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
			}

			if (name != '' && pass != '' && mail != '') {
				$.ajax({
					url: "<?= base_url('config/detail_user/act_edit_userdata') ?>",
					type: "POST",
					data: {
						name:name,
						pass:pass,
						mail:mail,
						idus:idus,
					},
					dataType: "json",
					success : function(data) {
						if (data.status) {
							toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Success!');
						} else {
							toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
						}
					},
				});
			}
		})

		// tab 2 - user Group
		var table_user_group = $('#dt-table-group').DataTable( {
			"lengthChange": false,
			"processing": true,
			"language": {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
				lengthMenu: "Tampilkan _MENU_ baris per halaman",
				zeroRecords: "Data tidak ditemukan",
				info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
				infoEmpty: "Tidak ada data yang ditampilkan ",
				paginate: {
					next: "<i class='ft ft-chevrons-right'></i>",
					previous: "<i class='ft ft-chevrons-left'></i>",
				},
				select: {
					rows : "%d baris dipilih"
				}
			},
			"serverSide": true,
			"order": [[1, "desc" ]],
			"ajax": {
				"url": "<?= base_url('config/detail_user/show_user_group') ?>",
				"type": "POST",
				"data": function(d){
					d.s_user_id = $('#user_id_ud').val();
				},
			},
			"scrollY": 435,
			'columnDefs': [
				{
					"targets": 0,
					"orderable": false
				}
			],
			'select': {
				'style': 'multi'
			},
			"searching": false,
		} );

		function refresh_table_user_group(){
			table_user_group.ajax.reload();
		}

		$('#base-tab12').click(function() {
			refresh_table_user_group();
		})

		// act user group
		$('.ck').click(function() {
			var group_id = $(this).val();
			var user_id = $('#user_id_ud').val();
			$.ajax({
				url: "<?= base_url('config/detail_user/act_group_user') ?>",
				type: "POST",
				data: {
					user_id:user_id,
					group_id:group_id,
				},
				dataType: "json",
				success : function(data) {
					if (data.status) {
						toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Success!');
					} else {
						toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
					}
					refresh_table_user_group();
				},
			});
		});

		// copy clipboard
		$(document).on( 'click', 'button#copyToClipboard', function(){
			$( '#account_information' ).select();
			document.execCommand('copy');
			toastr.info('Informasi Akun berhasil dicopy.', '<i class="ft ft-check-square"></i> Success!');
		});

		$(document).on( 'click', 'button#copyToClipboard2', function(){
			$( '#account_information2' ).select();
			document.execCommand('copy');
			toastr.info('Informasi Device berhasil dicopy.', '<i class="ft ft-check-square"></i> Success!');
		});

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
    setInputFilter(document.getElementById("no_hp"), function(value) {
    return /^-?\d*$/.test(value); });
    setInputFilter(document.getElementById("value_nik"), function(value) {
    return /^-?\d*$/.test(value); });
	setInputFilter(document.getElementById("tahun"), function(value) {
    return /^-?\d*$/.test(value); });

</script>
