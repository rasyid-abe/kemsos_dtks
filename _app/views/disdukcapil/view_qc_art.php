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
                        <input type="text" id="nama_krt" class="form-control" value="" placeholder="Nama ART">
                    </div>
                    <div class="form-group col-sm-3">
                        <input type="text" id="alamat" class="form-control" value="" placeholder="Alamat">
                    </div>
                    <div class="form-group col-sm-3">
                        <select id="stereotype" name="stereotype" class="form-control" >
                            <option value="">Pilih Stereotype</option>
                            <option value="q1a">Q1a</option>
                            <option value="q1b">Q1b</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <select id="keb" name="keb" class="form-control" >
                            <option value="">Pilih Status Keberadaan</option>
                            <option value="1">Terkonfirmasi</option>
                            <option value="2">Tidak Terkonfirmasi</option>
                            <option value="3">Ganda</option>
                            <option value="4">Meninggal</option>
                            <option value="5">Tidak Memiliki/Belum tercatat dalam dokumen</option>
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
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-block btn-info" id="dt_export_act" name="button"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <div class="bg-light-info text-white" role="group">
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_approve" name="button"><i class="ft ft-trending-up"></i> Padan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_invalid" name="button"><i class="ft ft-trending-up"></i> Tidak Padan</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_copy" name="button"><i class="ft ft-copy"></i> Copy ID Prelist</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                        <button type="button" class="btn btn-sm bg-light-info" data-toggle="modal" data-target="#forecastexcel"><i class="ft ft-upload" ></i> Import Data</button>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                <thead>
                    <tr>
                        <th>detail</th>
                        <th>sts</th>
                        <th>id_prelist</th>
                        <th>nama art</th>
                        <th>provinsi</th>
                        <th>kabupaten/kota</th>
                        <th>kecamatan</th>
                        <th>kelurahan</th>
                        <th>status art</th>
                        <th>nik</th>
                        <th>gender</th>
                        <th>hub. kel</th>
                        <th>id detail</th>
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
<div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Excel</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo $base_url ?>importExcel">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Cari File</label>
                        <input type="file" class="form-control" name="ImportExcel" id="ImportExcel" accept=".xls,.xlsx" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Modal Ubah Detail -->
<div class="modal fade text-left" id="edit-data-nik" tabindex="-1" role="dialog" aria-labelledby="edit_detail" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title" id="edit_detail">Edit Data ART</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form action="<?php echo base_url('disdukcapil/qc_art/edit_nik_art')?>" method="POST">
                <div class="modal-body">
                    <div class="card-body row">
                        <div class="col">
                            <div class="alert bg-light-info mb-2" role="alert"><b>Informasi :</b> Silahkan perbaiki data.</div>
                            <div class="form-group row align-items-center">
                                <div class="col-6">
                                    <label class="col-form-label">Perbaikan Berdasarkan</label>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled mt-2">
                                        <li class="d-inline-block mr-2">
                                            <div class="radio">
                                                <input type="radio" value="1" name="basic-radio-1" id="radio1">
                                                <label for="radio1">NIK</label>
                                            </div>
                                        </li>
                                        <li class="d-inline-block mr-2">
                                            <div class="radio">
                                                <input type="radio" value="2" name="basic-radio-1" id="radio2">
                                                <label for="radio2">NAMA ART</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label for="basicInput">ID ART</label>
                                        <input type="text" class="form-control" id="id" name="id" required readonly="readonly">
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label for="disabledInput">NIK</label>
                                        <input minlength="16" class="form-control niks v2" maxlength="16" pattern=".{16,16}" title="Wajib 16 digit." id="nik" name="nik" placeholder="331121..." required>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nik">NAMA ART</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control v1" id="nama_art" name="nama_art" required>
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cek_dukcapil" name="button"></i> Cek Dukcapil</button>
                        <input class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin akan simpan dan padan data ini?')" type="submit" name="simpan_padan" value="Simpan Dan Padan" />
                        <input class="btn btn-info btn-sm" onclick="return confirm('Apakah Anda yakin ingin simpan data ini?')" type="submit" name="simpan" value="Simpan" />
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"> Batal</button>
                    </div>
                    <script>
                        var x = document.getElementsById("radio1").value;
                        var y = document.getElementsById("radio2").value;
                        if (x == 1) {
                            document.getElementsById('nik').removeAttribute('readonly');
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url( THEMES_BACKEND );?>new-assets/datatables/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
        // Untuk sunting
        $('#edit-data-nik').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget)
            var modal = $(this)

            modal.find('#id').attr("value",div.data('id'));
            modal.find('#nama_art').attr("value",div.data('nama_art'));
            modal.find('.niks').attr("value",div.data('nik'));
        });
    });
</script>

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
    response_import();
    response_edit_art();

    function response_edit_art() {
        if ('<?=$this->session->flashdata('tab')?>' == 'update_nik') {
            if ('<?=$this->session->flashdata('status')?>' == '1') {
                toastr.info('ART berhasi diperbarui.', '<i class="ft ft-check-square"></i> Success!');
            } else {
                toastr.error('ART gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
            }
        }
    }

    function response_import() {
        if ('<?=$this->session->flashdata('message')?>' != '') {
            toastr.info('<?=$this->session->flashdata('message')?>', '<i class="ft ft-check-square"></i> Success!');
        }
	}

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
                d.s_keb = $('#keb').val();
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

    // reset form cari
    $('#cek_dukcapil').click(function() {
        var cek_dukcapil = 'asd';
        var cek_nama = document.getElementById("nama_art").value;
        var nik = document.getElementById("nik").value;
        $.ajax({
            url: "<?php echo $base_url ?>edit_nik_art",
            type: "POST",
            data: {cek_nama:cek_nama,
                cek_dukcapil:cek_dukcapil,
                nik:nik},
            dataType: "json",
            beforeSend: function( xhr ) {
                $('#progres_bar').toggle('hidden');
            },
            success : function(data) {
                $('#progres_bar').toggle('hidden');
                alert(data.pesan);
            //    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
            },
        });

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

    // action approve padan
    $('#btn_dt_approve').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[12]
        });

        if (ids.length > 0) {
            c = confirm('Apakah Anda yakin APPROVE PADAN '+ids.length+' data?');
            if (c) {
                $.ajax({
                    url: "<?php echo $base_url ?>act_approve",
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
            toastr.error('Anda belum memilih data untuk diupdate.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

    // action approve tidak padan
    $('#btn_dt_invalid').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[12]
        });

        if (ids.length > 0) {
            c = confirm('Apakah Anda yakin APPROVE TIDAK PADAN '+ids.length+' data?');
            if (c) {
                $.ajax({
                    url: "<?php echo $base_url ?>act_invalid",
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
            toastr.error('Anda belum memilih data untuk diupdate.', '<i class="ft ft-alert-triangle"></i> Error!');
        }
    });

    // action Export
    $('#dt_export_act').click(function () {

        s_prov = $('#select-propinsi').val();
        s_regi = $('#select-kabupaten').val();
        s_dist = $('#select-kecamatan').val();
        s_vill = $('#select-kelurahan').val();


        var string = s_prov + '/' + s_regi + '/' + s_dist + '/' + s_vill ;

        window.open("<?php echo $base_url ?>export_data/" + string);
        return false;
        //window.open("<?php echo $base_url ?>export_data");

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
    setInputFilter(document.getElementById("nik"), function(value) {
    return /^-?\d*$/.test(value); });

});
</script>
