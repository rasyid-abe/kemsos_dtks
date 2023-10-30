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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <h5 class="card-title"><?= $title ?></h5><hr>
            <div class="form_dt_search hidden" id="form_dt_search">
                <?php if ( isset( $cari ) ) { echo $cari; } ?>
                <div class="row">
                    <input type="hidden" id="is_filter" class="form-control" value="0">
                    <div class="form-group col-sm-3">
                        <input type="text" id="nama_krt" class="form-control" value="" placeholder="Nama KRT">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="alamat" class="form-control" value="" placeholder="Alamat">
                    </div>
                    <div class="form-group col-sm-3">
                        <select id="stereotype" name="stereotype" class="form-control" >
                            <option value="">Pilih Stereotype</option>
                            <option value="m4">M4</option>
                            <option value="m4a">M4a</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="is_in_paste" class="form-control" value="" placeholder="IS IN Prelist">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="not_in_paste" class="form-control" value="" placeholder="NOT IN Prelist">
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
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" data-toggle="modal" data-target="#inlineForm" name="button"><i class="ft ft-corner-left-down"></i> Reject</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_copy" name="button"><i class="ft ft-copy"></i> Copy ID Prelist</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>action</th>
                        <th>Sts</th>
                        <th>id_prelist</th>
                        <th>nama_krt</th>
                        <th>provinsi</th>
                        <th>kabupaten/kota</th>
                        <th>kecamatan</th>
                        <th>kelurahan</th>
                        <th>alamat</th>
                        <th>proses_id</th>
                        <th>lastupdate</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="hide_clipboard"></div>
            <textarea value="Hello World" id="clipboard" readonly></textarea>
        </div>
    </div>
</div>

<!-- modal-edit-art -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Edit ART (Reject)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="tblFirst"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal revoke note -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Catatan Reject</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="revoke_note" placeholder="Catatan reject prelist.." class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="btn_dt_reject" data-dismiss="modal">Reject</button>
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
    $('.select2').select2();

    // drowdown wilyah
    $('#select-propinsi').on("select2:select", function(e) {
    // $("#select-propinsi").on( "change", function(){
        let params = {
            "bps_province_code": $(this).val(),
            "stereotype": "REGENCY",
            "title": "Kabupaten",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kabupaten ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
        } else {
            get_location(params);
        }
        $( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
        $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
    });

    $("#select-kabupaten").on( "change", function(){
        let params = {
            "bps_province_code": $("#select-propinsi").val(),
            "bps_regency_code": $(this).val(),
            "stereotype": "DISTRICT",
            "title": "Kecamatan",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kecamatan ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
        } else {
            get_location(params);
        }
        $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
    });

    $("#select-kecamatan").on( "change", function(){
        let params = {
            "bps_province_code": $("#select-propinsi").val(),
            "bps_regency_code": $("#select-kabupaten").val(),
            "bps_district_code": $(this).val(),
            "stereotype": "VILLAGE",
            "title": "Kelurahan",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kelurahan ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
        } else {
            get_location(params);
        }
    });

    var get_location = ( params ) => {
        $.ajax({
            url: "<?php echo $base_url ?>get_show_location",
            type: "GET",
            data: $.param(params),
            dataType: "json",
            beforeSend: function( xhr ) {
                // $("#modalLoader").modal("show");
            },
            success : function(data) {
                let option = `<option value="0"> -- Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
                $.each( data, function(k,v) {
                    option += `<option value="${k}">${v}</option>`;
                });
                $("#select-" + params.title.toLowerCase() ).html( option );
            },
        });
    };

    $.noConflict();
    toasterOptions();

    // datatable config
    table = $('#dt-table').DataTable( {
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
                d.s_fill = $('#is_filter').val();
                d.s_prov = $('#select-propinsi').val();
                d.s_regi = $('#select-kabupaten').val();
                d.s_dist = $('#select-kecamatan').val();
                d.s_vill = $('#select-kelurahan').val();
                d.s_nkrt = $('#nama_krt').val();
                d.s_addr = $('#alamat').val();
                d.s_isin = $('#is_in_paste').val();
                d.s_notin = $('#not_in_paste').val();
                d.s_stereo = $('#stereotype').val();
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
        "lengthMenu": [[100, 150, 200, 500, 1000], ['100', '150', '200', '500', '1.000']],
        "sScrollX": "100%",
        "sScrollXInner": "150%",
        "bScrollCollapse": true
    } );

    // act can edit ART
    $("#dt-table").on("click", ".can_edit_art", function() {
        const proses_id = $(this).data('proses-id');
        var config_elem = '';

        $.ajax({
            url: "<?php echo $base_url ?>get_detail_art",
            type: "POST",
            data: {proses_id:proses_id},
            dataType: "json",
            success : function(res) {
                var no = 1;
                var hubkel = '';
                var status = '';
                $.each(res, function(i, v) {
                    //status_art
                    if (v.keberadaan_art == 1) {
                        status = "Terkonfirmasi";
                    } else if (v.keberadaan_art == 2) {
                        status = "Tidak Terkonfirmasi";
                    } else if (v.keberadaan_art == 3) {
                        status = "Ganda";
                    } else if (v.keberadaan_art == 4) {
                        status = "Meninggal";
                    } else if (v.keberadaan_art == 5) {
                        status = "Tidak Memiliki/Belum tercatat dalam dokumen kependudukan";
                    }

                    //hubkel
                    if (v.hubungan_kepkel == 1) {
                        hubkel = "Kepala Keluarga";
                    } else if (v.hubungan_kepkel == 2) {
                        hubkel = "Istri/Suami";
                    } else if (v.hubungan_kepkel == 3) {
                        hubkel = "Anak";
                    } else if (v.hubungan_kepkel == 4) {
                        hubkel = "Menantu";
                    } else if (v.hubungan_kepkel == 5) {
                        hubkel = "Cucu";
                    } else if (v.hubungan_kepkel == 6) {
                        hubkel = "Orang Tua/Mertua";
                    } else if (v.hubungan_kepkel == 7) {
                        hubkel = "Pembantu Rumah Tangga";
                    } else if (v.hubungan_kepkel == 8) {
                        hubkel = "Lainnya";
                    }
                    config_elem += `
                    <tr>
                        <td>${no}</td>
                        <td><span class="${v.css}">${v.stereotype}</span></td>
                        <td>${v.nama_art}</td>
                        <td>${status}</td>
                        <td>${v.nik}</td>
                        <td>${hubkel}</td>
                        <td>
                            <input class="can_edit_detail" type="radio" data-id="${v.id}" id="det_${v.proses_id}" name="act_edit_${v.id}" value=1 ${v.status_edit == 1 ? 'checked' : ''}>
                            <label for="det_${v.proses_id}">Ya</label>
                            <input class="can_edit_detail" type="radio" data-id="${v.id}" id="det_${v.proses_id}" name="act_edit_${v.id}" value=0 ${v.status_edit == 0 ? 'checked' : ''}>
                            <label for="det_${v.proses_id}">Tidak</label>
                        </td>
                    </tr>
                    `;
                    no++;
                })
                generate_table(config_elem);
            }
        })

    })

    function generate_table(body) {
        table = `
        <table class="table table-striped table-sm act" id="det_act_edit">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Status Padan</th>
                    <th>Nama ART</th>
                    <th>Status ART</th>
                    <th>NIK</th>
                    <th>Hub. Kel</th>
                    <th>Aksi Edit</th>
                </tr>
            </thead>
            <tbody>
                ${body}
            </tbody>
        </table>
        `;

        $("#tblFirst").html(table);
    }

    $(document).on('click', '.can_edit_detail', function() {
        let value = $(this).val();
        let id =  $(this).attr("data-id");

        $.ajax({
            url: "<?php echo $base_url ?>act_can_edit",
            type: "POST",
            data: {id:id, value:value},
            dataType: "json",
            success : function(data) {
                if (data.status) {
                    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error(data.pesan, '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        })
    });

    $('#form_dt_search').slideToggle("slow");

    // show hide advance searching
    $('#btn_dt_cari').on('click', function() {
        $('#form_dt_search').slideToggle("slow");
    })

    // action cari
    $('#dt_cari_act').click(function() {
        if ('<?php echo $pic != 0 ?>' || '<?php echo $qc != 0 ?>') {
            if ($('#select-propinsi').val() == 0) {
                toastr.error('Anda harus memilih Provinsi terlebih dahulu!');
                return false;
            }
        }
        $('#is_filter').val(1);
        table.ajax.reload();
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

    // action copy
    $('#btn_dt_copy').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[2]
        });
        if (ids.length > 0) {
            prelist_id = '';
            data_where = '';
            for(a=0;a<ids.length;a++)
            {
                row = ids[a];
                data_where = data_where + '"' + row + '",';
                prelist_id = prelist_id + row + "\n";
            }

            $('#clipboard').val(prelist_id);
            var copyText = document.getElementById("clipboard");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");

            toastr.info("ID PRELIST berikut berhasil di copy: \n\n"+prelist_id, '<i class="ft ft-check-square"></i> Info!');
        } else {
            toastr.error('Anda belum memilih data untuk dicopy.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

    // action reject
    $('#btn_dt_reject').click(function () {
        var ids = $.map($('#dt-table').DataTable().rows('.selected').data(), function (item) {
            return item[9]
        });

        if (ids.length > 0) {
            var note = document.getElementById("revoke_note").value;
            c = confirm('Apakah Anda yakin REJECT '+ids.length+' data?');
            if (c) {
                $.ajax({
                    url: "<?php echo $base_url ?>act_reject",
                    type: "POST",
                    data: {ids:ids, note:note},
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        $('#progres_bar').toggle('hidden');
                    },
                    success : function(data) {
                        $('#progres_bar').toggle('hidden');
                        toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
                        $('#dt-table').DataTable().ajax.reload();
                    },
                });
            }
        } else {
            toastr.error('Anda belum memilih data untuk direject.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

});
</script>
