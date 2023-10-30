<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<style>
    th { font-size: 13px; }
    td { font-size: 13px; }
</style>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
			<h5 class="card-title"><?= $title ?></h5><hr>
			<div class="form_dt_search hidden" id="form_dt_search">
                <?php
                    if ( isset( $cari ) ) {
                        echo $cari;
                    }
                ?>
                <div class="row">
					<div class="form-group col-sm-3">
                        <input type="text" id="user_id" class="form-control" value="" placeholder="User_id">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="username" class="form-control" value="" placeholder="0812456xxxx">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="nama_lengkap" class="form-control" value="" placeholder="Budi...">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="dt_cari_act" class="btn btn-block btn-warning" name="button"><i class="fa fa-search"></i>&nbsp;Refresh</button>
                    </div>
                </div><hr/>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <?php 
                            if (in_array('root', $this->id['user_group']) == true || in_array('admin-junior', $this->id['user_group']) == true || in_array('korwil', $this->id['user_group']) == true) {
                        ?>
                        <button type="button" class="btn btn-sm bg-light-info" data-toggle="modal" data-target="#modal_user" name="button"><i class="ft ft-plus-square"></i> Add</button>
                        <?php } ?>
                        <button type="button" onclick="return confirm('Apakah Anda yakin ingin aktifkan user ini?')" class="btn btn-sm bg-light-info" id="btn_dt_activate" name="button"><i class="fa fa-star"></i> Aktifkan</button>
                        <button type="button" onclick="return confirm('Apakah Anda yakin ingin non-aktifkan user ini?')" class="btn btn-sm bg-light-info" id="btn_dt_deactivate" name="button"><i class="fa fa-star-o"></i> Nonaktifkan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Search</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>                        
                        <?php 
                            if (in_array('root', $this->id['user_group']) == true || in_array('admin-junior', $this->id['user_group']) == true) {
                        ?>
                        <button type="button" class="btn btn-sm bg-light-success" id="dt_export_act" name="button"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>User ID</th>
						<th>Username</th>
						<th>Nama Lengkap</th>
                        <th>Group Name</th>
                        <th>Email</th>
                        <th>Created By</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal-Tambah-User-Baru -->
<div class="modal fade text-left" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="tambah_user" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="tambah_user">Tambah User Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url('config/user/simpan_user_baru'); ?>">
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label for="user_full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="user_full_name" placeholder="Budi..." required />
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="user_nik">NIK User</label>
                        <input minlength="16" class="form-control" maxlength="16" pattern=".{16,16}" title="Wajib 16 digit." id="value_nik" name="user_nik" placeholder="331121..." required >
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" class="form-control" name="user_email" placeholder="user@gmail..." required >
                    </fieldset>
                    <fieldset>
                        <label for="no_hp_user">Nomor HP User</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                            </div>
                            <input minlength="10" maxlength="12" id="no_hp" class="form-control" name="user_no_hp" placeholder="8134456..." required >
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="user_username">Username</label>
                        <input class="form-control" name="user_username" value="" required readonly style="padding-left:10px;">
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/dataTables.select.min.js"></script>

<script type="text/javascript">
    $(document).ready( function(){
        $.noConflict();
        toasterOptions();

        // action Export
        $('#dt_export_act').click(function () {  
            c = confirm('Apakah Anda yakin ekport data ini?');
            if (c) {          
                window.open("<?php echo $base_url ?>export_data/");
                return false;        
            }
        });

        $("#no_hp").on( "input", function(){
            $("input[name=\'user_username\']").val( "0" + $(this).val() );
        });

        // datatable config
        var table = $('#dt-table').DataTable( {
            "processing": true,
            "language": {
                processing: '<div class="overlay"><div class="pg_body"><div class="cssload-thecube"><div class="cssload-cube cssload-c1"></div><div class="cssload-cube cssload-c2"></div><div class="cssload-cube cssload-c4"></div><div class="cssload-cube cssload-c3"></div></div></div></div>',
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
            "order": [[3, "desc" ]],
            "ajax": {
                "url": "<?php echo $base_url ?>get_show_data",
                "type": "POST",
                "data": function(d){
                    d.s_user_id = $('#user_id').val();
                    d.s_username = $('#username').val();
                    d.s_nama = $('#nama_lengkap').val();
                },
            },
            "sScrollY": ($(window).height() - 100),
            'columnDefs': [
                {
                    "targets": 0,
                    "orderable": false
                }
            ],
            'select': {
                'style': 'multi'
            },
            "dom": '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
            "pagingType": "simple",
            "searching": false,
            "lengthMenu": [[50, 300, 500, 1000], [50, 300, 500, 1000]],
        } );

        $('#form_dt_search').slideToggle("slow");
        
        // show hide advance searching
        $('#btn_dt_cari').on('click', function() {
            $('#form_dt_search').slideToggle("slow");
        })

        // action cari
        $('#dt_cari_act').click(function() {
            table.ajax.reload();
        });

        // reset form cari
        $('#db_reset_act').click(function() {
            $('#user_id').val('');
            $('#username').val('');
            $('#nama_lengkap').val('');

            table.ajax.reload();
        });

        // action activation
        $('#btn_dt_activate').click(function () {
            var ids = $.map(table.rows('.selected').data(), function (item) {
                return item[1]
            });

            var url = 'act_active';
            if (ids.length > 0) {
                act_show([ids, 1], url)
            } else {
                toastr.error('Anda belum memilih data untuk diaktifkan.', '<i class="ft ft-alert-triangle"></i> Error!');
            }
        })

        // action deactivation
        $('#btn_dt_deactivate').click(function () {
            var ids = $.map(table.rows('.selected').data(), function (item) {
                return item[1]
            });

            var url = 'act_active';
            if (ids.length > 0) {
                act_show([ids, 0], url)
            } else {
                toastr.error('Anda belum memilih data untuk dinonaktifkan.', '<i class="ft ft-alert-triangle"></i> Error!');
            }
        })

        function act_show(params, url) {
            $.ajax({
                url: "<?php echo $base_url ?>" + url,
                type: "POST",
                data: {params:params},
                dataType: "json",
                beforeSend: function( xhr ) {
                    $('#progres_bar').toggle('hidden');
                },
                success : function(data) {
                    $('#progres_bar').toggle('hidden');
                    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
                    table.ajax.reload();
                },
            });
        }
    });

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

</script>
