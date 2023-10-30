<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<style>
    th { font-size: 12px; }
    td { font-size: 12px; }
</style>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <h5 class="card-title"><?= $title ?></h5><hr>
            <div class="form_dt_search hidden" id="form_dt_search">
                <input type="hidden" id="is_filter" class="form-control" value="0">
                <?php if ( isset( $cari ) ) { echo $cari; } ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <input type="text" id="kprov" class="form-control" value="" placeholder="Kode Provinsi">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="kkab" class="form-control" value="" placeholder="Kode Kabupaten">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="kkec" class="form-control" value="" placeholder="Kode Kecamatan">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="kkel" class="form-control" value="" placeholder="Kode Kelurahan">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <input type="text" id="loc" class="form-control" value="" placeholder="Location ID">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="bps" class="form-control" value="" placeholder="BPS Full Code">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-block btn-warning" id="dt_cari_act" name="button"><i class="fa fa-search"></i>&nbsp;Refresh</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                    <thead>
                        <tr>
                            <th>Location ID</th>
                            <th>Full Code</th>
                            <th>Kode Provinsi</th>
                            <th>Kode Kabupaten</th>
                            <th>Kode Kecamatan</th>
                            <th>Kode Kelurahan</th>
                            <th>Nama Provinsi</th>
                            <th>Nama Kabupaten</th>
                            <th>Nama Kecamatan</th>
                            <th>Nama Kelurahan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
                d.s_kprov = $('#kprov').val();
                d.s_kkab = $('#kkab').val();
                d.s_kkec = $('#kkec').val();
                d.s_kkel = $('#kkel').val();
                d.s_loc = $('#loc').val();
                d.s_bps = $('#bps').val();
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
        "lengthMenu": [[50, 150, 200, 500, 1000], ['50', '150', '200', '500', '1.000']],
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true
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
        table.ajax.reload();
    });

});
</script>
