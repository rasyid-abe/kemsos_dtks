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
					<div class="form-group col-3">
                        <input type="text" id="ver_app" class="form-control" value="" placeholder="Version App">
                    </div>

                    <div class="col-3">
                        <button type="button" id="dt_cari_act" class="btn btn-block btn-warning" name="button"><i class="fa fa-search"></i>&nbsp;Refresh</button>
                    </div>
                </div><hr/>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" data-toggle="modal" data-target="#modal_ver" name="button"><i class="ft ft-plus-square"></i> Add</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_delete" name="button"><i class="fa fa-trash"></i> Hapus</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Search</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered" id="dt-table">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>ID</th>
                        <th>App Version</th>
                        <th>Version Code</th>
                        <th>Update After</th>
                        <th>Description</th>
                        <th>Nama File</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal-Tambah-Version-App -->
<div class="modal fade text-left" id="modal_ver" tabindex="-1" role="dialog" aria-labelledby="tambah_ver" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="tambah_ver">Tambah Version Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" id="myform" enctype="multipart/form-data">
                    <input type="hidden" name="id_version" id="id_version" value="">
                    <fieldset class="form-group">
                        <label for="group_full_name">App Version</label>
                        <input type="text" class="form-control" id="app_version" name="app_version" required />
                        <small class="text-danger" id="v_app_version"></small>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="group_full_name">App Version Code</label>
                        <input type="text" class="form-control" id="app_version_code" name="app_version_code" required />
                        <small class="text-danger" id="v_app_version_code"></small>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="group_full_name">Update After</label>
                        <input type="date" class="form-control" id="force_update_after" name="force_update_after" required />
                        <small class="text-danger" id="v_force_update_after"></small>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="group_full_name">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required />
                        <small class="text-danger" id="v_description"></small>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="group_full_name">Nama File</label>
                        <input type="file" class="form-control" id="nama_file" name="nama_file"/>
                        <small class="text-danger" id="v_nama_file"></small>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger" id="btn_g_submit" data-dismiss="modal">Simpan</button>
            </div>
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

        // datatable config
        var table = $('#dt-table').DataTable( {
            "processing": true,
            "serverSide": true,
            "order": [[3, "desc" ]],
            "ajax": {
                "url": "<?php echo $base_url ?>get_show_data",
                "type": "POST",
                "data": function(d){
                    d.s_app = $('#ver_app').val();
                },
            },
            "sScrollY": ($(window).height() - 100),
            'columnDefs': [
                {
                    "targets": [1],
                    "visible": false,
                },
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
        });

        // show hide advance searching
        $('#btn_dt_cari').on('click', function() {
            $('#form_dt_search').slideToggle("slow");
        })

        // action cari
        $('#dt_cari_act').click(function() {
            table.ajax.reload();
            $('#form_dt_search').slideToggle("slow");
        });

        // reset form cari
        $('#db_reset_act').click(function() {
            location.reload();
        });

        // select all & Unselect
        $('#btn_dt_select').click(function () {
            $.map(table.rows().select());
        });

        $('#btn_dt_unselect').click(function () {
            $.map(table.rows().deselect());
        });

        //action store group
        $('#btn_g_submit').click(function() {
            var app_version = $('#app_version').val()
            var app_version_code = $('#app_version_code').val()
            var force_update_after = $('#force_update_after').val()
            var description = $('#description').val()
            var nama_file = $('#nama_file').val()
            var id_version = $('#id_version').val()

            if (app_version == '') {
                toastr.error('Form app_version harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }
            if (app_version_code == '') {
                toastr.error('Form app_version_code harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }
            if (force_update_after == '') {
                toastr.error('Form force_update_after harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }
            if (description == '') {
                toastr.error('Form description harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }

            if (app_version != '' || app_version_code != '' || force_update_after != '' || description != '' || nama_file != '') {
                $.ajax({
                    url: "<?php echo $base_url ?>store_version",
                    type: "POST",
                    data: {
                        app_version:app_version,
                        app_version_code:app_version_code,
                        force_update_after:force_update_after,
                        description:description,
                        nama_file:nama_file,
                        id_version:id_version,
                    },
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        $('#progres_bar').toggle('hidden');
                    },
                    success : function(data) {
                        if (data.status) {
                            toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
                            table.ajax.reload();
                        } else {
                            toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
                        }
                        $('#progres_bar').toggle('hidden');
                    },
                });
            }

        })

        // action edit
        $("#dt-table").on("click", ".md_edit", function() {
            $('#tambah_ver').html('Ubah Data');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= $base_url . 'store_version' ?>');

            const id_version = $(this).data('id_version');
            $.ajax({
                url: "<?php echo $base_url ?>data_edit",
                type: "POST",
                data: {id_version:id_version},
                dataType: "json",
                success : function(data) {
                    $('#app_version').val(data.app_version)
                    $('#app_version_code').val(data.app_version_code)
                    $('#force_update_after').val(data.force_update_after)
                    $('#description').val(data.description)
                    $('#nama_file').val(data.nama_file)
                    $('#id_version').val(id_version)
                },
            });
        })

        // action delete
        $('#btn_dt_delete').click(function() {
            var ids = $.map(table.rows('.selected').data(), function (item) {
                return item[1]
            });

            var url = 'act_delete';
            if (ids.length > 0) {
                if (confirm('Are you sure to delete this data?')) {
                    act_show([ids], url)
                }
            } else {
                toastr.error('Anda belum memilih data untuk dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
            }
        })
    });

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
    
</script>
