<!DOCTYPE html>
<html class="loading" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Data Terpadu Kesejahteraan Sosial</title>
    <link rel="shortcut icon" type="image/x-icon" href="themes/admin/able/app-assets/img/ico/favicon-kemsos.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/css/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/new-assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="themes/admin/able/app-assets/vendors/css/select2.min.css">
    <link rel="stylesheet" href="themes/admin/able/new-assets/datatables.net-bs/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="themes/admin/able/new-assets/datatables/css/select.dataTables.min.css">
    <link rel="stylesheet" href="themes/admin/able/app-assets/css/abe-style.css">

    <script src="themes/admin/able/new-assets/jquery/jquery.js"></script>
    <style media="screen">
        th {
            font-size: 12px;
        }

        td {
            font-size: 12px;
        }

        .breadcrumb {
            padding: 2px 15px !important;
        }

        .padd {
            padding: 7px
        }

        .anims {
            border-radius: 3px;
        }

        .trr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .trr {
            text-align: center
        }

        .p0 {
            padding: 4px 14px 4px 14px;
            background-color: #000000;
            color: #ffffff;
        }

        .p1 {
            padding: 4px 15px 4px 15px;
            background-color: #808080;
            color: #ffffff;
        }

        .p2 {
            padding: 4px 14px 4px 14px;
            background-color: #2f4f4f;
            color: #ffffff;
        }

        .p3 {
            padding: 4px 14px 4px 14px;
            background-color: #fdb347;
            color: #ffffff;
        }

        .p3a {
            padding: 4px 10px 4px 10px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .m1 {
            padding: 4px 14px 4px 14px;
            background-color: #56b2d3;
            color: #ffffff;
        }

        .m2 {
            padding: 4px 14px 4px 14px;
            background-color: #fdd835;
            color: #000000;
        }

        .m3 {
            padding: 4px 14px 4px 14px;
            background-color: #98c337;
            color: #ffffff;
        }

        .m4 {
            padding: 4px 13px 4px 13px;
            background-color: #006400;
            color: #ffffff;
        }

        .m4a {
            padding: 4px 8px 4px 8px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .c1 {
            padding: 4px 15px 4px 15px;
            background-color: #006400;
            color: #ffffff;
        }

        .c1a {
            padding: 4px 12px 4px 12px;
            background-color: #ff4500;
            color: #ffffff;
        }

        .c2 {
            padding: 4px 14px 4px 14px;
            background-color: #006400;
            color: #ffffff;
        }

        .c2a {
            padding: 4px 10px 4px 10px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .mk {
            padding: 4px 12px 4px 12px;
            background-color: #006400;
            color: #ffffff;
        }

        .mka {
            padding: 4px 8px 4px 8px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .mkb {
            padding: 4px 8px 4px 8px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .q1a {
            padding: 4px 12px 4px 12px;
            background-color: #ff4500;
            color: #ffffff;
        }

        .q1b {
            padding: 4px 12px 4px 12px;
            background-color: #ff4500;
            color: #ffffff;
        }

        .q2 {
            padding: 4px 15px 4px 15px;
            background-color: #006400;
            color: #ffffff;
        }

        .q2a {
            padding: 4px 12px 4px 12px;
            background-color: #df3c5e;
            color: #ffffff;
        }

        .q2b {
            padding: 4px 12px 4px 12px;
            background-color: #006400;
            color: #ffffff;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns navbar-sticky bg-default" data-menu="vertical-menu" data-col="2-columns">

    <nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed">
        <div class="container-fluid navbar-wrapper">
            <div class="navbar-header d-flex">
                <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
                <ul class="navbar-nav">
                    <li class="nav-item mr-2 d-none d-lg-block"><a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;"><i class="ft-maximize font-medium-3"></i></a></li>
                    <li class="nav-item mr-2 d-none d-lg-block animate__animated animate__lightSpeedInRight">
                        <img src="http://localhost/webdtks/themes/admin/able/logo-siksng.png" alt="" class="img-fluid animate__animated animate__slideInDown" width="100" height="38">
                    </li>
                    <li class="nav-item mr-2 d-none d-lg-block animate__animated animate__lightSpeedInRight">
                        <p style="font-size:12px;margin-bottom:-5px">Monitoring Kualitas</p>
                        <p style="font-size:12px;margin-bottom:-2px">Data Terpadu Kesejahteraan Sosial</p>
                    </li>
                </ul>
            </div>
            <div class="navbar-container">
                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="i18n-dropdown dropdown nav-item mr-2">
                            <a class="nav-link d-flex">

                            </a>
                        </li>
                        <li class="i18n-dropdown dropdown nav-item mr-2">
                            <a class="nav-link d-flex">
                                <span style="font-size:12px">Last Login : -</span>
                            </a>
                        </li>
                        <li class="dropdown nav-item mr-1">
                            <div class="nav-link dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                                <div class="user d-md-flex d-none mr-2">
                                    <span class="text-right">public</span><span class="text-right text-muted font-small-3">Public</span>
                                </div>
                                <img class="avatar" src="http://localhost/webdtks/assets/images/profile/default.png" alt="avatar" height="35" width="35">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <div class="app-sidebar menu-fixed" data-background-color="white" data-image="themes/admin/able//app-assets/img/sidebar-bg/06.jpg" data-scroll-to-active="true">
            <div class="sidebar-header">
                <div class="logo clearfix">
                    <a class="logo-text float-left" href="http://localhost/webdtks/">
                        <div class="logo-img">
                            <img src="themes/admin/able/app-assets/img/logo-nav-kemsos.png" width="35" height="35" alt="Logo" />
                        </div>
                        <span class="text" style="font-family:Tahoma, Geneva, sans-serif">MK-DTKS</span>
                    </a>
                    <a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a>
                    <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
                </div>
            </div>
            <div class="sidebar-content main-menu-content">
                <div class="nav-container">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                            <li class="nav-item  " title="">
                                <a href="<?= base_url('welcome') ?>" class="nav-link" data-toggle="tooltip" data-placement="right" title="Daftar Semua Data">
                                    <i class="ft-file-text text-info"></i>
                                    <span class="menu-title" data-i18n="Daftar Semua Data">Login Sistem</span>
                                </a>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>

        <div class="main-panel">
            <div class="main-content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-info" href="http://localhost/webdtks/"><i class="ft-home submenu-icon"></i> Home</a></li>
                            </ol>
                            <div class="float-right mr-2" style="margin-top: -39px">
                                <a href="#" data-toggle="modal" class="text-info" data-target="#info"><i class="ft-info submenu-icon"></i> Informasi Status</a>
                            </div>
                        </div>
                    </div>
                    <section id="configuration">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <h5 class="card-title"><?= $title ?></h5>
                                            <hr>
                                            <div class="form_dt_search hidden" id="form_dt_search">
                                                <?php
                                                if (isset($cari)) {
                                                ?>
                                                    <?php echo $cari; ?>
                                                <?php
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="form-group col-sm-3">
                                                        <input type="text" id="s_nama_art" class="form-control" value="" placeholder="Nama ART">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <select class="form-control" id="sterotype_q1">
                                                            <option value="">Pilih Stereotype</option>
                                                            <option value="Q1a">Q1a</option>
                                                            <option value="Q1q">Q1q</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <select class="form-control" id="sumber_data">
                                                            <option value="">Pilih Sumber Data</option>
                                                            <option value="1">1. KK</option>
                                                            <option value="2">2. Sumber Data Lain</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <select class="form-control" id="status_pengecekan">
                                                            <option value="">Pilih Status Pengecekan</option>
                                                            <option value="1">1. Sesuai Dengan Dok</option>
                                                            <option value="2">2. Tidak Sesuai Dengan Dok</option>
                                                            <option value="3">3. Dokumen Tidak Jelas/option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <input type="text" id="is_in_paste" class="form-control" value="" placeholder="IS IN Prelist">
                                                    </div>
                                                    <div class="form-group col-sm-3">
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
                                                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_select" name="button"><i class="ft ft-check-square"></i> Pilih Semua</button>
                                                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_unselect" name="button"><i class="ft ft-grid"></i> Batal Pilih</button>
                                                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_copy" name="button"><i class="ft ft-copy"></i> Copy ID Prelist</button>
                                                        <button type="button" class="btn btn-sm bg-light-info" id="btn_dt_cari" name="button"><i class="ft ft-search"></i> Cari</button>
                                                        <button type="button" class="btn btn-sm bg-light-info" id="db_reset_act" name="button"><i class="ft ft-refresh-ccw"></i> Reset Cari</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-sm table-striped table-bordered .file-export" id="dt-table">
                                                <thead>
                                                    <tr>
                                                        <td>DETAIL</td>
                                                        <td>stereotype</td>
                                                        <td>ID PRELIST</td>
                                                        <td>NAMA ART</td>
                                                        <td>NIK</td>
                                                        <td>SUMBER DATA</td>
                                                        <td>STATUS PENGECEKAN</td>
                                                        <td>PROVINSI</td>
                                                        <td>KABUPATEN/KOTA</td>
                                                        <td>KECAMATAN</td>
                                                        <td>KELURAHAN</td>
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
                            </div>
                        </div>
                </div>
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Detail Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Foto KK</td>
                                            <td>Form</td>
                                            <td>NOKK</td>
                                            <td>NOK</td>
                                            <td>Save</td>
                                        </tr>
                                    </thead>
                                    <tbody id=body_rekap></tbody>
                                </table>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="reset_modal" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Save changes</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- End-Modal -->
                <footer class="footer undefined undefined">
                    <p class="clearfix text-blue m-0"><span>Copyright &copy; 2020 &nbsp;</span><a href="#">MK-DTKS</a><span class="d-none d-sm-inline-block">, All rights reserved.</span></p>
                </footer>
                <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>

            </div>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <script src="themes/admin/able/new-assets/datatables/js/jquery.dataTables.min.js"></script>
        <script src="themes/admin/able/new-assets/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
        <script src="themes/admin/able/new-assets/datatables/js/dataTables.select.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.dt_cari_act').click(function() {
                    table.ajax.reload();
                });
                $('.select2').select2();

                // drowdown wilyah
                $('#select-propinsi').on("select2:select", function(e) {
                    // $("#select-propinsi").on( "change", function(){
                    let params = {
                        "bps_province_code": $(this).val(),
                        "stereotype": "REGENCY",
                        "title": "Kabupaten",
                    }
                    if ($(this).val() == "0") {
                        $("#select-kabupaten ").html("<option value=\'0\'> -- Pilih Kota/Kabupaten -- </option>");
                    } else {
                        get_location(params);
                    }
                    $("#select-kecamatan ").html("<option value=\'0\'> -- Pilih Kecamatan -- </option>");
                    $("#select-kelurahan ").html("<option value=\'0\'> -- Pilih Kelurahan -- </option>");
                });

                $("#select-kabupaten").on("change", function() {
                    let params = {
                        "bps_province_code": $("#select-propinsi").val(),
                        "bps_regency_code": $(this).val(),
                        "stereotype": "DISTRICT",
                        "title": "Kecamatan",
                    }
                    if ($(this).val() == "0") {
                        $("#select-kecamatan ").html("<option value=\'0\'> -- Pilih Kecamatan -- </option>");
                    } else {
                        get_location(params);
                    }
                    $("#select-kelurahan ").html("<option value=\'0\'> -- Pilih Kelurahan -- </option>");
                });

                $("#select-kecamatan").on("change", function() {
                    let params = {
                        "bps_province_code": $("#select-propinsi").val(),
                        "bps_regency_code": $("#select-kabupaten").val(),
                        "bps_district_code": $(this).val(),
                        "stereotype": "VILLAGE",
                        "title": "Kelurahan",
                    }
                    if ($(this).val() == "0") {
                        $("#select-kelurahan ").html("<option value=\'0\'> -- Pilih Kelurahan -- </option>");
                    } else {
                        get_location(params);
                    }
                });

                var get_location = (params) => {
                    console.log();
                    $.ajax({
                        url: "<?php echo $base_url ?>get_show_location",
                        type: "GET",
                        data: $.param(params),
                        dataType: "json",
                        beforeSend: function(xhr) {
                            // $("#modalLoader").modal("show");
                        },
                        success: function(data) {
                            let option = `<option value="0"> -- Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
                            $.each(data, function(k, v) {
                                option += `<option value="${k}">${v}</option>`;
                            });
                            $("#select-" + params.title.toLowerCase()).html(option);
                        },
                    });
                };

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
                            d.s_prov = $('#select-propinsi').val();
                            d.s_regi = $('#select-kabupaten').val();
                            d.s_dist = $('#select-kecamatan').val();
                            d.s_vill = $('#select-kelurahan').val();
                            d.s_isin = $('#is_in_paste').val();
                            d.s_notin = $('#not_in_paste').val();
                            d.s_sumber = $('#sumber_data').val();
                            d.s_pengecekan = $('#status_pengecekan').val();
                            d.s_art = $('#s_nama_art').val();
                            d.s_stereotype = $('#sterotype_q1').val();
                        },
                    },
                    "sScrollY": ($(window).height() - 100),
                    'columnDefs': [{
                        "targets": 0,
                        "orderable": false
                    }],
                    'select': {
                        'style': 'multi'
                    },
                    "dom": '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                    "pagingType": "simple",
                    "searching": false,
                    "lengthMenu": [
                        [50, 150, 200, 500, 1000],
                        ['50', '150', '200', '500', '1.000']
                    ],
                    "sScrollX": "100%",
                    "sScrollXInner": "150%",
                    "bScrollCollapse": true
                });

                $('#form_dt_search').slideToggle("slow");

                // show hide advance searching
                $('#btn_dt_cari').on('click', function() {
                    $('#form_dt_search').slideToggle("slow");
                })

                // reset form cari
                $('#db_reset_act').click(function() {
                    location.reload();
                });

                // action cari


                // reset form cari
                $('#cek_dukcapil').click(function() {
                    var cek_dukcapil = 'asd';
                    var cek_nama = document.getElementById("nama_art").value;
                    var nik = document.getElementById("nik").value;
                    $.ajax({
                        url: "<?php echo $base_url ?>edit_nik_art",
                        type: "POST",
                        data: {
                            cek_nama: cek_nama,
                            cek_dukcapil: cek_dukcapil,
                            nik: nik
                        },
                        dataType: "json",
                        beforeSend: function(xhr) {
                            $('#progres_bar').toggle('hidden');
                        },
                        success: function(data) {
                            $('#progres_bar').toggle('hidden');
                            alert(data.pesan);
                            //    toastr.info(data.pesan, '<i class="ft ft-check-square"></i> Info!');
                        },
                    });

                });

                // select all & Unselect
                $('#btn_dt_select').click(function() {
                    $.map(table.rows().select());
                });
                $('#btn_dt_unselect').click(function() {
                    $.map(table.rows().deselect());
                });

                // edir rekap
                $(document).on('click', '.edit_rekap', function() {
                    let id = $(this).data('id');
                    let proses_id = $(this).data('proses_id');
                    let body = '';
                    $.ajax({
                        url: "<?php echo $base_url ?>get_edit_rekap",
                        type: "POST",
                        data: {
                            id: id,
                            proses_id: proses_id
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            for (let i = 0; i < data.length; i++) {
                                console.log(data[i].nama_art);
                                if (i > 0) {
                                    art = data[i].nama_art == data[i - 1].nama_art ? '-' : '<input type="text" name="nama_art" value="' + data[i].nama_art + '">';
                                    nik = data[i].nik == data[i - 1].nik ? '-' : data[i].nik;
                                    sumber_data = data[i].sumber_data == data[i - 1].sumber_data ? '-' : data[i].sumber_data;
                                    status_pengecekan = data[i].status_pengecekan == data[i - 1].status_pengecekan ? '-' : data[i].status_pengecekan;
                                } else {
                                    art = data[i].nama_art;
                                    nik = data[i].nik;
                                    sumber_data = data[i].sumber_data;
                                    status_pengecekan = data[i].status_pengecekan;
                                }
                                body += `
                                <tr>
                                    <td class="text-left">${data[i].internal_filename}</td>
                                    <td class="text-left">
                                        <input class="form-control" type="text" id="art_tbl" value="${art}" ${art == '-' ? 'disabled' : ''}>
                                        <input class="form-control" type="number" id="nik_tbl" value="${nik}" ${nik == '-' ? 'disabled' : ''}>
                                        <select class="form-control" id="sumber_data_tbl" ${sumber_data == '-' ? 'disabled' : ''}>
                                            <option value="" ${sumber_data == '' ? 'selected' : ''}>Pilih Sumber Data</option>
                                            <option value="1" ${sumber_data == 1 ? 'selected' : ''}>1. KK</option>
                                            <option value="2" ${sumber_data == 2 ? 'selected' : ''}>2. Sumber Data Lain</option>
                                        </select>
                                        <select class="form-control" id="status_pengecekan_tbl" ${status_pengecekan == '-' ? 'disabled' : ''}>
                                            <option value="" ${status_pengecekan == '' ? 'selected' : ''}>Pilih Status Pengecekan</option>
                                            <option value="1" ${status_pengecekan == 1 ? 'selected' : ''}>1. Sesuai Dengan Dok</option>
                                            <option value="2" ${status_pengecekan == 2 ? 'selected' : ''}>2. Tidak Sesuai Dengan Dok</option>
                                            <option value="3" ${status_pengecekan == 3 ? 'selected' : ''}>3. Dokumen Tidak Jelas</option>
                                        </select>
                                    </td>
                                    <td class="text-left">${data[i].nokk}</td>
                                    <td class="text-left">${data[i].nuk}</td>
                                    <td>
                                    <input class="form-control" type="hidden" id="proses_id_tbl" value="${proses_id}" ${art == '-' ? 'disabled' : ''}>
                                    <input class="form-control" type="hidden" id="id_tbl" value="${id}" ${art == '-' ? 'disabled' : ''}>
                                    ${art != '-' ? ' <button type="submit" class="btn btn-sm btn-info save_rekap"><i class="fa fa-save"></i></button>' : ''}
                                    </td>
                                </tr>
                                `;
                            }
                            // $.each(data, function(i, v) {});
                            $('#body_rekap').html(body);
                            // $('#nik_f').val(data.nik);
                        },
                    });
                })

                // action edit rekap
                $(document).on('click', '.save_rekap', function() {
                    let nama_art = $('#art_tbl').val();
                    let nik = $('#nik_tbl').val();
                    let sumber_data = $('#sumber_data_tbl').val();
                    let status_pengecekan = $('#status_pengecekan_tbl').val();
                    let proses_id = $('#proses_id_tbl').val();
                    let id = $('#id_tbl').val();

                    let proses = false;
                    if (nama_art != '') {
                        proses = true;
                    } else {
                        toastr.warning('Nama ART Tidak Boleh Kosong.', '<i class="ft ft-alert-octagon"></i> Warning!');
                        return false;
                    }

                    if (sumber_data != '') {
                        proses = true;
                    } else {
                        toastr.warning('Sumber Data Harus Dipilih.', '<i class="ft ft-alert-octagon"></i> Warning!');
                        return false;
                    }

                    if (status_pengecekan != '') {
                        proses = true;
                    } else {
                        toastr.warning('Status Pengecekan Harus Dipilih.', '<i class="ft ft-alert-octagon"></i> Warning!');
                        return false;
                    }

                    if (nik != '') {
                        if (nik.length < 16 || nik.length > 20) {
                            toastr.warning('NIK Harus 16 sampai 20 Digit.', '<i class="ft ft-alert-octagon"></i> Warning!');
                            return false;
                        } else {
                            proses = true;
                        }
                    } else {
                        toastr.warning('NIK Tidak Boleh Kosong.', '<i class="ft ft-alert-octagon"></i> Warning!');
                        return false;
                    }

                    if (proses) {
                        $.ajax({
                            url: "<?php echo $base_url ?>act_edit_rekap",
                            type: "POST",
                            data: {
                                nama_art: nama_art,
                                nik: nik,
                                sumber_data: sumber_data,
                                status_pengecekan: status_pengecekan,
                                proses_id: proses_id,
                                id: id,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data) {
                                    toastr.info('Data berhasil diupdate', '<i class="ft ft-message-square"></i> Info!');
                                } else {
                                    toastr.warning('Data gagal diupdate', '<i class="ft ft-alert-octagon"></i> Warning!');
                                }
                                table.ajax.reload();
                            }
                        })
                    }
                })

                // action copy
                $('#btn_dt_copy').click(function() {
                    var ids = $.map(table.rows('.selected').data(), function(item) {
                        return item[2]
                    });
                    if (ids.length > 0) {
                        prelist_id = '';
                        data_where = '';
                        for (a = 0; a < ids.length; a++) {
                            row = ids[a];
                            data_where = data_where + '"' + row + '",';
                            prelist_id = prelist_id + row + "\n";
                        }

                        $('#clipboard').val(prelist_id);
                        var copyText = document.getElementById("clipboard");
                        copyText.select();
                        copyText.setSelectionRange(0, 99999)
                        document.execCommand("copy");

                        toastr.info("ID PRELIST berikut berhasil di copy: \n\n" + prelist_id, '<i class="ft ft-check-square"></i> Info!');
                    } else {
                        toastr.error('Anda belum memilih data untuk dicopy.', '<i class="ft ft-alert-triangle"></i> Error!');
                    }
                });
            });
        </script>
        <script src="themes/admin/able/app-assets/js/toastr/toastr.min.js"></script>
        <script src="themes/admin/able/app-assets/js/toastr/abe-toast.js"></script>
        <script src="themes/admin/able/app-assets/vendors/js/vendors.min.js"></script>
        <script src="themes/admin/able/app-assets/vendors/js/switchery.min.js"></script>
        <script src="themes/admin/able/app-assets/js/core/app-menu.js"></script>
        <script src="themes/admin/able/app-assets/js/core/app.js"></script>
        <script src="themes/admin/able/new-assets/js/scripts.js"></script>
        <script src="themes/admin/able/app-assets/js/components-modal.js"></script>
        <script src="themes/admin/able/app-assets/js/customizer.js"></script>

        <script src="themes/admin/able/app-assets/vendors/js/select2.full.min.js"></script>
</body>

</html>