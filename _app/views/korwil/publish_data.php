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
                        <input type="text" id="stereotype" class="form-control" value="" placeholder="Status Data">
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
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_publish" name="button"><i class="ft ft-trending-up"></i> Publish</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_copy" name="button"><i class="ft ft-copy"></i> Copy ID Prelist</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>Sts</th>
                        <th>id_prelist</th>
                        <th>nama_krt</th>
                        <th>provinsi</th>
                        <th>kabupaten/kota</th>
                        <th>kecamatan</th>
                        <th>kelurahan</th>
                        <th>alamat</th>
                        <th>lastupdate</th>
                        <th>detail</th>
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

    $('#form_dt_search').slideToggle("slow");

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
    } );

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
            return item[1]
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

    // action publish
    $('#btn_dt_publish').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[1]
        });

        if (ids.length > 0) {
            c = confirm('Apakah Anda yakin PUBLISH '+ids.length+' data?');
            if (c) {
                $.ajax({
                    url: "<?php echo $base_url ?>act_publish",
                    type: "POST",
                    data: {ids:ids},
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
        } else {
            toastr.error('Anda belum memilih data untuk dipublish.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

});
</script>
