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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Foto Koordinasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Data Koordinasi</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab11">
                <div class="table-responsive">
                    <div class="form_dt_search hidden" id="form_dt_search">
                        <?php if ( isset( $cari ) ) { echo $cari; } ?>
                        <div class="row">
                            <input type="hidden" id="is_filter" class="form-control" value="0">
                            <div class="form-group col-md-3 col-sm-12">
                                <input type="text" id="usr" class="form-control" value="" placeholder="0812345xxxx">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <select id="jenis" name="jenis" class="form-control" >
                                    <option value="">Pilih Jenis</option>
                                    <option value="f-kn">F-KN</option>
                                    <option value="f-kl">F-KL</option>
                                    <option value="f-ba">F-BA</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="button" class="btn btn-block btn-warning" id="dt_cari_act" name="button"><i class="fa fa-search"></i>&nbsp;Proses</button>
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
                    <table class="table table-sm table-striped table-bordered" id="dt-table">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Nama File</th>
                                <th>Ukuran File</th>
                                <th>Jenis Foto</th>
                                <th>Dipublish Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
                <div class="table-responsive">
                    <div class="form_dt_search2 hidden" id="form_dt_search2">
                        <?php if ( isset( $cari2 ) ) { echo $cari2; } ?>
                        <div class="row">
                            <input type="hidden" id="is_filter2" class="form-control" value="0">                            
                            <div class="form-group col-md-3 col-sm-12">
                                <input type="text" id="kepdes" class="form-control" value="" placeholder="Kontak Kepala Desa">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <input type="text" id="operator" class="form-control" value="" placeholder="Kontak Operator">
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="button" class="btn btn-block btn-warning" id="dt_cari_act2" name="button"><i class="fa fa-search"></i>&nbsp;Proses</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-12">
                            <div class="bg-light-info text-white" role="group">
                                <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari2" name="button"><i class="ft ft-search"></i> Cari</button>
                                <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act2" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" id="dt-table2">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Kode Wilayah</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Kontak Kepala Desa</th>
                                <th>Kontak Operator</th>
                                <th>Last Update</th>
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

<!-- Modal Ubah Detail -->
<div class="modal fade text-left" id="detail-koor" tabindex="-1" role="dialog" aria-labelledby="detail-koors" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h4 class="modal-title" id="detail-koors">Detail Koordinasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="col-12 control-label">Kode Wilayah</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="bps_full_code" name="bps_full_code" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Jumlah ART Terkonfirmasi</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jml_art_terkonfirmasi" name="jml_art_terkonfirmasi" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Jumlah ART Tidak Terkonfirmasi</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jml_art_tidak_terkonfirmasi" name="jml_art_tidak_terkonfirmasi" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Jumlah ART Meninggal</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jml_art_meninggal" name="jml_art_meninggal" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Jumlah ART Ganda</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jml_art_ganda" name="jml_art_ganda" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="col-12 control-label">Jumlah ART No Dokumen</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jml_art_no_dokumen" name="jml_art_no_dokumen" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Total Hasil Perbaikan</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="total_art_hasil_perbaikan" name="total_art_hasil_perbaikan" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Latitude</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Longitude</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="longitude" name="=longitude" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-12 control-label">Last Update</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="lastupdate_on" name="lastupdate_on" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/dataTables.select.min.js"></script>

<script>
     $(document).ready(function() {
        // detail koordinasi
        $('#detail-koor').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget)
            var modal = $(this)

            modal.find('#bps_full_code').attr("value",div.data('bps_full_code'));
            modal.find('#jml_art_terkonfirmasi').attr("value",div.data('jml_art_terkonfirmasi'));
            modal.find('#jml_art_tidak_terkonfirmasi').attr("value",div.data('jml_art_tidak_terkonfirmasi'));
            modal.find('#jml_art_meninggal').attr("value",div.data('jml_art_meninggal'));
            modal.find('#jml_art_ganda').attr("value",div.data('jml_art_ganda'));
            modal.find('#jml_art_no_dokumen').attr("value",div.data('jml_art_no_dokumen'));
            modal.find('#total_art_hasil_perbaikan').attr("value",div.data('total_art_hasil_perbaikan'));
            modal.find('#latitude').attr("value",div.data('latitude'));
            modal.find('#longitude').attr("value",div.data('longitude'));
            modal.find('#lastupdate_on').attr("value",div.data('lastupdate_on'));
        });
    });
</script>

<script type="text/javascript">
$(document).ready( function(){
    $('.select2').select2();

    // drowdown wilyah1 ===================================================================================
    $('#select-propinsi').on("select2:select", function(e) {
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

    // drowdown wilyah2 =====================================================================================
    $('#select-propinsi2').on("select2:select", function(e) {
        let params2 = {
            "bps_province_code": $(this).val(),
            "stereotype": "REGENCY",
            "title": "Kabupaten",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kabupaten2 ").html( "<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>" );
        } else {
            get_location2(params2);
        }
        $( "#select-kecamatan2 ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
        $( "#select-kelurahan2 ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
    });

    $("#select-kabupaten2").on( "change", function(){
        let params2 = {
            "bps_province_code": $("#select-propinsi2").val(),
            "bps_regency_code": $(this).val(),
            "stereotype": "DISTRICT",
            "title": "Kecamatan",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kecamatan2 ").html( "<option value=\'0\'> -- Pilih Kecamatan -- </option>" );
        } else {
            get_location2(params2);
        }
        $( "#select-kelurahan2 ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
    });

    $("#select-kecamatan2").on( "change", function(){
        let params2 = {
            "bps_province_code": $("#select-propinsi2").val(),
            "bps_regency_code": $("#select-kabupaten2").val(),
            "bps_district_code": $(this).val(),
            "stereotype": "VILLAGE",
            "title": "Kelurahan",
        }
        if ( $(this).val() == "0" ) {
            $( "#select-kelurahan2 ").html( "<option value=\'0\'> -- Pilih Kelurahan -- </option>" );
        } else {
            get_location2(params2);
        }
    });

    var get_location2 = ( params2 ) => {
        $.ajax({
            url: "<?php echo $base_url ?>get_show_location2",
            type: "GET",
            data: $.param(params2),
            dataType: "json",
            beforeSend: function( xhr ) {
                // $("#modalLoader").modal("show");
            },
            success : function(data) {
                console.log(data);
                let option = `<option value="0"> -- Pilih ${( ( params2.title == "Kabupaten" ) ? "Kota/Kabupaten" : params2.title )} -- </option>`;
                $.each( data, function(k,v) {
                    option += `<option value="${k}">${v}</option>`;
                });
                $("#select-" + params2.title.toLowerCase() + "2" ).html( option );
            },
        });
    };

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
            "url": "<?php echo $base_url ?>get_show_data",
            "type": "POST",
            "data": function(d){
                d.s_fill = $('#is_filter').val();
                d.s_prov = $('#select-propinsi').val();
                d.s_regi = $('#select-kabupaten').val();
                d.s_dist = $('#select-kecamatan').val();
                d.s_vill = $('#select-kelurahan').val();
                d.s_usr = $('#usr').val();
                d.s_jns = $('#jenis').val();
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

     // datatable config 2
     var table2 = $('#dt-table2').DataTable( {
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
            "url": "<?php echo $base_url ?>get_show_dataK",
            "type": "POST",
            "data": function(d){
                d.s_fill = $('#is_filter2').val();
                d.s_prov = $('#select-propinsi2').val();
                d.s_regi = $('#select-kabupaten2').val();
                d.s_dist = $('#select-kecamatan2').val();
                d.s_vill = $('#select-kelurahan2').val();
                d.s_kepdes = $('#kepdes').val();
                d.s_operator = $('#operator').val();
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
        "sScrollXInner": "150%",
        "bScrollCollapse": true
    } );

    $('#form_dt_search').slideToggle("slow");

    $('#form_dt_search2').slideToggle("slow");

    // show hide advance searching
    $('#btn_dt_cari').on('click', function() {
        $('#form_dt_search').slideToggle("slow");
    })

    $('#btn_dt_cari2').on('click', function() {
        $('#form_dt_search2').slideToggle("slow");
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

    $('#dt_cari_act2').click(function() {
        if ('<?php echo $pic != 0 ?>' || '<?php echo $qc != 0 ?>') {
            if ($('#select-propinsi2').val() == 0) {
                toastr.error('Anda harus memilih Provinsi terlebih dahulu!');
                return false;
            }
        }
        $('#is_filter2').val(1);
        table2.ajax.reload();
    });

    // reset form cari
    $('#db_reset_act').click(function() {
        location.reload();
    });

    $('#db_reset_act2').click(function() {
        location.reload();
    });

});
</script>
