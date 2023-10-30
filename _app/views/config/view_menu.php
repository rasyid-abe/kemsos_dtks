<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<style>
    th { font-size: 12px; }
    td { font-size: 12px; }
</style>
<div class="hidden" id="progres_bar">
    <div class="overlay">
        <div class="progress pg_body">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <div id="content_bar"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_form_menu" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Form Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height: 450px; overflow-y: auto;">
                <input type="hidden" name="parent_menu_f" id="parent_menu_f" value="<?= isset($query_parent->menu_id) ? $query_parent->menu_id : ''?>">
                <input type="hidden" name="id_menu_edit" id="id_menu_edit" value="">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Parent</label>
                            <input type="text" class="form-control" value="<?= isset($query_parent->menu_name) ? $query_parent->menu_name : '-'?>"readonly>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">URL Menu</label>
                            <input type="text" class="form-control" name="menu_url_f" id="menu_url_f" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Nama Menu</label>
                            <input type="text" class="form-control" name="menu_name_f" id="menu_name_f" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Class</label>
                            <input type="text" class="form-control" name="menu_class_f" id="menu_class_f">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="menu_description_f" id="menu_description_f">
                </div>
                <div class="row" id="elem_menu_action">
                    <?php foreach ($query_action as $key => $value): ?>
                        <div class="col-4">
                            <div class="custom-control custom-checkbox">
                                <input name="menu_action[]" class="custom-control-input checkbox_val" type="checkbox" id="customCheckbox_<?= $value->menu_action_id; ?>" value="<?= $value->menu_action_name; ?>"  <?= $value->menu_action_name == 'show' ? 'checked disabled' : '' ?>>
                                <label for="customCheckbox_<?= $value->menu_action_id; ?>" class="custom-control-label"><?= $value->menu_action_title ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info" id="act_store" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <h5 class="card-title"><?= $title ?></h5><hr>
            <div class="form_dt_search hidden" id="form_dt_search">
                <?php if ( isset( $cari ) ) { echo $cari; } ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <input type="text" id="menu_name" class="form-control" value="" placeholder="Nama Menu">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="menu_url" class="form-control" value="" placeholder="URL Menu">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="menu_class" class="form-control" value="" placeholder="Class Menu">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-block btn-warning" id="dt_cari_act" name="button"><i class="fa fa-search"></i>&nbsp;Proses</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_add" data-toggle="modal" data-target=".modal_form_menu" name="button" data-backdrop="static" data-keyboard="false"><i class="ft ft-plus-square"></i> Tambah</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_activate" name="button"><i class="fa fa-star"></i> Aktifkan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_deactivate" name="button"><i class="fa fa-star-o"></i> Nonaktifkan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_delete" name="button"><i class="fa fa-trash"></i> Hapus</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th>menu_name</th>
                        <th>menu_slug</th>
                        <th>menu_sub</th>
                        <th>menu_url</th>
                        <th>menu_class</th>
                        <th>menu_description</th>
                        <th>menu_is_active</th>
                        <th>menu_id</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="menu_parent" value="<?= $menu_parent ;?>" id="menu_parent">
            <textarea value="Hello World" id="clipboard" readonly></textarea>
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
            "url": "<?php echo $base_url ?>get_data",
            "type": "POST",
            "data": function(d){
                d.s_par = $('#menu_parent').val();
                d.s_name = $('#menu_name').val();
                d.s_url = $('#menu_url').val();
                d.s_clas = $('#menu_class').val();
            },
        },
        "sScrollY": ($(window).height() - 100),
        'columnDefs': [
            {
                "targets": [8],
                "visible": false,
            },
            {
                "targets": [0, 3],
                "orderable": false
            }
        ],
        'select': {
            'style': 'multi'
        },
        "dom": '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        "pagingType": "simple",
        "searching": false,
        "lengthMenu": [[100, 150, 200, 500, 1000], ['100', '150', '200', '500', '1.000']],
    } );

    $('#form_dt_search').slideToggle("slow");
    
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
        $('#menu_name').val('');
        $('#menu_url').val('');
        $('#menu_class').val('');

        table.ajax.reload();
    });

    // select all & Unselect
    $('#btn_dt_select').click(function () {
        $.map(table.rows().select());
    });
    $('#btn_dt_unselect').click(function () {
        $.map(table.rows().deselect());
    });

    // action activation
    $('#btn_dt_activate').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[8]
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
            return item[8]
        });

        var url = 'act_active';
        if (ids.length > 0) {
            act_show([ids, 0], url)
        } else {
            toastr.error('Anda belum memilih data untuk dinonaktifkan.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    })

    // action delete
    $('#btn_dt_delete').click(function() {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[8]
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

    // add menu
    $('#act_store').click(function(e) {
        e.preventDefault();
        var searchIDs = $(".custom-checkbox input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        store_menu(searchIDs);
    })

    function store_menu(searchIDs) {
        var menu_name = $('#menu_name_f').val();
        var menu_url = $('#menu_url_f').val();
        var menu_class = $('#menu_class_f').val();

        if (menu_name == '') {
            toastr.error('Form Nama Menu harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
        }
        if (menu_url == '') {
            toastr.error('Form Menu URL harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
        }
        if (menu_class == '') {
            toastr.error('Form Menu Class harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
        }

        if (menu_name != '' && menu_url != '' && menu_class != '') {
            $.ajax({
                url: "<?php echo $base_url ?>store_menu",
                type: "POST",
                data: {
                    menu_id:$('#id_menu_edit').val(),
                    parent_menu:$('#parent_menu_f').val(),
                    menu_name:$('#menu_name_f').val(),
                    menu_url:$('#menu_url_f').val(),
                    menu_class:$('#menu_class_f').val(),
                    menu_description:$('#menu_description_f').val(),
                    menu_action:searchIDs,
                },
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
    }

    // edit menu
    $("#dt-table").on("click", ".modal_em", function() {
        $('#modal_title').html('Form Ubah Menu');
        $('.modal-footer button[type=submit]').html('Ubah');

        const id = $(this).data('id');
        var elem_action = '';
        $.ajax({
            url: "<?php echo $base_url ?>data_edit",
            type: "POST",
            data: {id:id},
            dataType: "json",
            success : function(res) {
                console.log(res);
                action = JSON.parse(res.data.menu_action);
                act = res.action;

                for (var i = 0; i < act.length; i++) {
                    var chk = '';
                    if (action.includes(act[i].menu_action_name)) {
                        chk = 'checked';
                    } else if (act[i].menu_action_name == 'show') {
                        chk = 'checked disabled';
                    } else {
                        chk = '';
                    }

                    elem_action += `
                    <div class="col-4">
                        <div class="custom-control custom-checkbox">
                            <input name="menu_action[]" class="custom-control-input checkbox_val" type="checkbox" id="customCheckbox_${act[i].menu_action_id}" value="${act[i].menu_action_name}"  ${chk}>
                            <label for="customCheckbox_${act[i].menu_action_id}" class="custom-control-label">${act[i].menu_action_title}</label>
                        </div>
                    </div>
                    `;
                }

                $('#elem_menu_action').html(elem_action);
                $('#parent_menu_f').val(res.data.menu_parent_menu_id);
                $('#menu_name_f').val(res.data.menu_name);
                $('#menu_url_f').val(res.data.menu_url);
                $('#menu_class_f').val(res.data.menu_class);
                $('#menu_description_f').val(res.data.menu_description);
                $('#id_menu_edit').val(res.data.menu_id);

            },
        })
    })

});
</script>
