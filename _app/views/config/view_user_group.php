<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/abe-style.css">
<style>
    th {
        font-size: 13px;
    }

    td {
        font-size: 13px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <h5 class="card-title"><?= $title ?></h5>
            <hr>
            <div class="form_dt_search hidden" id="form_dt_search">
                <?php
                if (isset($cari)) {
                    echo $cari;
                }
                ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <input type="text" id="user_g" class="form-control" value="" placeholder="Group Name">
                    </div>

                    <div class="col-sm-2">
                        <button type="button" id="dt_cari_act" class="btn btn-block btn-warning" name="button"><i class="fa fa-search"></i>&nbsp;Refresh</button>
                    </div>
                </div>
                <hr />
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" data-toggle="modal" data-target="#modal_group" name="button"><i class="ft ft-plus-square"></i> Add</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_activate" name="button"><i class="fa fa-star"></i> Aktifkan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_deactivate" name="button"><i class="fa fa-star-o"></i> Nonaktifkan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_delete" name="button"><i class="fa fa-trash"></i> Hapus</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Search</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Group ID</th>
                        <th>Group Title</th>
                        <th>Group Name</th>
                        <th>Group Description</th>
                        <th>Active</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal-Tambah-User-Baru -->
<div class="modal fade text-left" id="modal_group" tabindex="-1" role="dialog" aria-labelledby="tambah_group" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="tambah_group">Tambah Group Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" id="myform">
                    <input type="hidden" name="id_group" id="id_group">
                    <fieldset class="form-group">
                        <label for="group_full_name">Nama Group</label>
                        <input type="text" class="form-control" id="nama_group" name="nama_group" required />
                        <small class="text-danger" id="v_nama_group"></small>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="group_desk">Description</label>
                        <input class="form-control" id="deskripsi" name="deskripsi" required>
                        <small class="text-danger" id="v_deskripsi"></small>
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

<!-- Modal-Tambah-User-Baru -->
<div class="modal fade text-left" id="modal_role_menu" tabindex="-1" role="dialog" aria-labelledby="tambah_group" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h4 class="modal-title" id="title_role_menu">Konfigurasi Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body" style="height: 450px; overflow-y: auto;">
                <div id="body_config_role"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url(THEMES_BACKEND); ?>new-assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(THEMES_BACKEND); ?>new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(THEMES_BACKEND); ?>new-assets/datatables/js/dataTables.select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.noConflict();
        toasterOptions();

        // datatable config
        var table = $('#dt-table').DataTable({
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
                    rows: "%d baris dipilih"
                }
            },
            "serverSide": true,
            "order": [
                [3, "desc"]
            ],
            "ajax": {
                "url": "<?php echo $base_url ?>get_show_data",
                "type": "POST",
                "data": function(d) {
                    d.s_user_g = $('#user_g').val();
                },
            },
            "sScrollY": ($(window).height() - 100),
            'columnDefs': [{
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
            "lengthMenu": [
                [50, 300, 500, 1000],
                [50, 300, 500, 1000]
            ],
        });

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
            $('#user_g').val('');

            table.ajax.reload();
        });

        // select all & Unselect
        $('#btn_dt_select').click(function() {
            $.map(table.rows().select());
        });
        $('#btn_dt_unselect').click(function() {
            $.map(table.rows().deselect());
        });

        //action store group
        $('#btn_g_submit').click(function() {
            var name = $('#nama_group').val()
            var deskripsi = $('#deskripsi').val()
            var id = $('#id_group').val()

            if (deskripsi == '') {
                toastr.error('Form Deskripsi harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }
            if (name == '') {
                toastr.error('Form Nama harus diisi!', '<i class="ft ft-alert-triangle"></i> Error!');
            }

            if (name != '' && deskripsi != '') {
                $.ajax({
                    url: "<?php echo $base_url ?>store_group",
                    type: "POST",
                    data: {
                        name: name,
                        deskripsi: deskripsi,
                        id: id,
                    },
                    dataType: "json",
                    beforeSend: function(xhr) {
                        $('#progres_bar').toggle('hidden');
                    },
                    success: function(data) {
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
            $('#tambah_group').html('Ubah Data');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= $base_url . 'act_edit' ?>');

            const id = $(this).data('id');

            $.ajax({
                url: "<?php echo $base_url ?>data_edit",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    $('#nama_group').val(data.user_group_title)
                    $('#deskripsi').val(data.user_group_description)
                    $('#id_group').val(id)
                    // console.log(data);
                },
            });
        })

        // action activation
        $('#btn_dt_activate').click(function() {
            var ids = $.map(table.rows('.selected').data(), function(item) {
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
        $('#btn_dt_deactivate').click(function() {
            var ids = $.map(table.rows('.selected').data(), function(item) {
                return item[1]
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
            var ids = $.map(table.rows('.selected').data(), function(item) {
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

        function act_show(params, url) {
            $.ajax({
                url: "<?php echo $base_url ?>" + url,
                type: "POST",
                data: {
                    params: params
                },
                dataType: "json",
                beforeSend: function(xhr) {
                    $('#progres_bar').toggle('hidden');
                },
                success: function(data) {
                    $('#progres_bar').toggle('hidden');
                    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
                    table.ajax.reload();
                },
            });
        }

        // config Role
        $("#dt-table").on("click", ".config_role", function() {
            const role = $(this).data('id');
            var config_elem = '';

            $.ajax({
                url: "<?php echo $base_url ?>data_config",
                type: "POST",
                data: {
                    role: role,
                    parent: ''
                },
                dataType: "json",
                success: function(res) {
                    var menu = res.menu;
                    var menu_id = res.menu_id;
                    var chk_menu = chk_menu_act = '';

                    $.each(menu, function(i, v) {
                        if (menu_id.includes(v.menu_id)) {
                            chk_menu = 'checked';
                        } else {
                            chk_menu = '';
                        }

                        config_elem += `
    					<i class="arrow ft ft-chevron-right" data-parent="${v.menu_id}" data-role="${role}"></i>
    					<input type="checkbox" class="ck_location" ${chk_menu}  onclick="store_role(${role}, ${v.menu_id}, 'parent')" value="${v.menu_id}">
    					<label for="vehicle1"> ${v.menu_name}</label>
    					<div id="tree_${v.menu_id}"></div>
    					`;
                    })
                    $('#body_config_role').html(config_elem)
                }
            })
        })

        $(document).on('click', '.arrow', function(e) {
            $(this).toggleClass('ft-chevron-down ft-chevron-right');
            let parent = $(this).attr("data-parent");
            let role = $(this).attr("data-role");
            let config_elem = '';
            if ($(this).hasClass('ft-chevron-down')) {
                $.ajax({
                    url: "<?php echo $base_url ?>data_config",
                    type: "POST",
                    data: {
                        role: role,
                        parent: parent
                    },
                    dataType: "json",
                    success: function(res) {
                        var menu = res.menu;
                        var menu_id = res.menu_id;
                        var act_menu_id = res.act_menu_id;
                        var has_child = res.has_child;
                        var chk_menu = chk_menu_act = '';

                        let l = 0;
                        $.each(menu, function(i, v) {
                            if (menu_id.includes(v.menu_id)) {
                                chk_menu = 'checked';
                            } else {
                                chk_menu = '';
                            }

                            act_elem = el_act = '';
                            act = JSON.parse(v.menu_action);
                            console.log(act);
                            if (act.length > 0) {

                                for (var i = 0; i < act.length; i++) {
                                    if (act_menu_id.includes(v.menu_id + act[i])) {
                                        chk_menu_act = 'checked';
                                    } else {
                                        chk_menu_act = '';
                                    }
                                    if (act[i] != 'show') {
                                        act_elem += `
                                        <div class="col-3" style="padding-left:30px;">
                                        <div class="custom-control custom-checkbox_act">
                                        <input class="form-check-input" onclick="store_role(${role}, ${v.menu_id}, '${act[i]}')" type="checkbox" ${chk_menu_act} id="menu_${v.menu_id}_${act[i]}">
                                        <label class="form-check-label" for="menu_${v.menu_id}_${act[i]}">
                                        ${act[i]}
                                        </label>
                                        </div>
                                        </div>
                                        `;
                                    }
                                }
                            }

                            if (has_child[l] > 0) {
                                config_elem += `
                                <div style="padding-left:15px;">
                                <i class="arrow_tree ft ft-chevron-right" data-parent="${v.menu_id}" data-role="${role}"></i>
                                <input type="checkbox" class="ck_location" ${chk_menu}  onclick="store_role(${role}, ${v.menu_id}, 'parent')" value="${v.menu_id}">
                                <label for="vehicle1"> ${v.menu_name}</label>
                                <div id="child_tree_${v.menu_id}"></div>
                                </div>
                                `;
                            } else {
                                config_elem += `
                                <div style="padding-left:34px;">
                                <input type="checkbox" class="ck_location" ${chk_menu}  onclick="store_role(${role}, ${v.menu_id}, 'parent')" value="${v.menu_id}">
                                <label for="vehicle1"> ${v.menu_name}</label>
                                <div class="row">${act_elem}</div>
                                </div>
                                `;
                            }



                            l++;
                        })
                        $('#tree_' + parent).html(config_elem)
                    }
                })

            } else if ($(this).hasClass('ft-chevron-right')) {
                $('#tree_' + parent).html('<div id="tree_' + parent + '"></div>');
            }
        })


        $(document).on('click', '.arrow_tree', function(e) {
            $(this).toggleClass('ft-chevron-down ft-chevron-right');
            let parent = $(this).attr("data-parent");
            let role = $(this).attr("data-role");

            let config_elem = '';
            if ($(this).hasClass('ft-chevron-down')) {
                $.ajax({
                    url: "<?php echo $base_url ?>data_config",
                    type: "POST",
                    data: {
                        parent: parent,
                        role: role
                    },
                    dataType: "json",
                    success: function(res) {
                        var menu = res.menu;
                        var menu_id = res.menu_id;
                        var act_menu_id = res.act_menu_id;
                        var has_child = res.has_child;
                        var chk_menu = chk_menu_act = '';

                        let l = 0;
                        $.each(menu, function(i, v) {
                            if (menu_id.includes(v.menu_id)) {
                                chk_menu = 'checked';
                            } else {
                                chk_menu = '';
                            }

                            act_elem = el_act = '';
                            act = JSON.parse(v.menu_action);
                            if (act.length > 0) {

                                for (var i = 0; i < act.length; i++) {
                                    if (act_menu_id.includes(v.menu_id + act[i])) {
                                        chk_menu_act = 'checked';
                                    } else {
                                        chk_menu_act = '';
                                    }
                                    if (act[i] != 'show') {
                                        act_elem += `
                                        <div class="col-3" style="padding-left:30px;">
                                        <div class="custom-control custom-checkbox_act">
                                        <input class="form-check-input" onclick="store_role(${role}, ${v.menu_id}, '${act[i]}')" type="checkbox" ${chk_menu_act} id="menu_${v.menu_id}_${act[i]}">
                                        <label class="form-check-label" for="menu_${v.menu_id}_${act[i]}">
                                        ${act[i]}
                                        </label>
                                        </div>
                                        </div>
                                        `;
                                    }
                                }
                            }

                            if (has_child[l] > 0) {
                                config_elem += `
                                <div style="padding-left:15px;">
                                <i class="arrow_tree ft ft-chevron-right" data-parent="${v.menu_id}" data-role="${role}"></i>
                                <input type="checkbox" class="ck_location" ${chk_menu}  onclick="store_role(${role}, ${v.menu_id}, 'parent')" value="${v.menu_id}">
                                <label for="vehicle1"> ${v.menu_name}</label>
                                <div id="child_tree_${v.menu_id}"></div>
                                </div>
                                `;
                            } else {
                                config_elem += `
                                <div style="padding-left:34px;">
                                <input type="checkbox" class="ck_location" ${chk_menu}  onclick="store_role(${role}, ${v.menu_id}, 'parent')" value="${v.menu_id}">
                                <label for="vehicle1"> ${v.menu_name}</label>
                                <div class="row">${act_elem}</div>
                                </div>
                                `;
                            }

                            l++;
                        })
                        $('#child_tree_' + parent).html(config_elem)
                    },
                });
            } else if ($(this).hasClass('ft-chevron-right')) {
                $('#child_tree_' + parent).html('<div id="child_tree_' + parent + '"></div>');
            }
        })

    });

    function store_role(group, menu, action) {

        if (action == '') {
            act = 'show';
        } else if (action == 'parent') {
            act = '';
        } else {
            act = action;
        }

        $.ajax({
            url: "<?php echo $base_url ?>act_store_role",
            type: "POST",
            data: {
                group: group,
                menu: menu,
                action: act,
            },
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
                }
            },
        });
    }
</script>