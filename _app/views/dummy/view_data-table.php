<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <h5 class="card-title"><?= $title ?></h5><hr>
            <div class="form_dt_search hidden" id="form_dt_search">
                <?php
                if ( isset( $cari ) ) {
                    ?>
                    <?php echo $cari;?>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <input type="text" id="nama_krt" class="form-control" value="" placeholder="Nama KRT">
                    </div>
                    <div class="form-group col-sm-9">
                        <input type="text" id="alamat" class="form-control" value="" placeholder="Alamat">
                    </div>
                    <div class="form-group col-sm-5">
                        <input type="text" id="is_in_paste" class="form-control" value="" placeholder="IS IN Prelist">
                    </div>
                    <div class="form-group col-sm-5">
                        <input type="text" id="not_in_paste" class="form-control" value="" placeholder="NOT IN Prelist">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-block btn-warning dt_cari_act" name="button"><i class="fa fa-search"></i>&nbsp;Proses</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_tambah" name="button"><i class="ft ft-plus-square"></i> Tambah</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_hapus" name="button"><i class="ft ft-trash-2"></i> Hapus (alert)</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_approve" name="button"><i class="ft ft-user-check"></i> Approve</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_reject" name="button"><i class="ft ft-user-x"></i> Reject</button>
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
                        <th>province_name</th>
                        <th>regency_name</th>
                        <th>district_name</th>
                        <th>village_name</th>
                        <th>alamat</th>
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
    $.noConflict();
    toasterOptions();
    
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
                d.s_prov = $('#select-propinsi').val();
                d.s_regi = $('#select-kabupaten').val();
                d.s_dist = $('#select-kecamatan').val();
                d.s_vill = $('#select-kelurahan').val();
                d.s_nkrt = $('#nama_krt').val();
                d.s_addr = $('#alamat').val();
                d.s_isin = $('#is_in_paste').val();
                d.s_notin = $('#not_in_paste').val();
            },
        },
        "scrollY": 290,
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
        "lengthMenu": [[50, 100, 150, 200], [50, 100, 150, 200]],
    } );

    // action cari
    $('.dt_cari_act').click(function() {
        table.ajax.reload();
        $('#form_dt_search').slideToggle("slow");
    });

    // reset form cari
    $('#db_reset_act').click(function() {
        $('#select-propinsi').val('0');
        $('#select-kabupaten').val('0');
        $('#select-kecamatan').val('0');
        $('#select-kelurahan').val('0');
        $('#nama_krt').val('');
        $('#alamat').val('');
        $('#is_in_paste').val('');
        $('#not_in_paste').val('');

        table.ajax.reload();
    });

    // select all & Unselect
    $('#btn_dt_select').click(function () {
        $.map(table.rows().select());
    });
    $('#btn_dt_unselect').click(function () {
        $.map(table.rows().deselect());
    });

    $('#btn_dt_hapus').click(function () {
        //alert success
        toastr.success('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '<i class="ft ft-check-square"></i> Success!');

        // alert lainnya
        toastr.error('Success messages', '<i class="ft ft-alert-triangle"></i> Error!');
        toastr.warning('Success messages', '<i class="ft ft-alert-octagon"></i> Warning!');
        toastr.info('Success messages', '<i class="ft ft-message-square"></i> Info!');
    });

    $('#btn_dt_tambah').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[1]
        });
        console.log(ids)
        alert(table.rows('.selected').data().length + ' row(s) selected');
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

            toastr.info("ID PRELIST berikut berhasil di copy: \n\n"+prelist_id, '<i class="ft ft-check-square"></i> Success!');
        } else {
            toastr.error('Anda belum memilih data untuk dicopy.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

    // show hide advance searching
    $('#btn_dt_cari').on('click', function() {
        $('#form_dt_search').slideToggle("slow");
    })

    // show hide is in
    $('#btn_dt_is_in').on('click', function() {
        $('#form_dt_isin').slideToggle("slow");
    })

    // show hide is in
    $('#btn_dt_not_in').on('click', function() {
        $('#form_dt_notin').slideToggle("slow");
    })


    // drowdown wilyah
    $("#select-propinsi").on( "change", function(){
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

});
</script>
