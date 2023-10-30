<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/apexcharts.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/pages/charts-apex.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/abe-style.css">
<style media="screen">
    table {
        font-size: 9pt;
    }
</style>

<!-- <div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Import Excel</h4>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo base_url('dashboard/table_progres/import_excel') ?>">
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
</div> -->

<div class="overlay">
    <div class="pg_body">
        <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <!-- <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#forecastexcel"><i class='fa fa-plus'></i> Import Excel</button> -->
        <?php if (isset($cari)) {
            echo $cari;
        } ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered" id="dt-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">WILAYAH</th>
                        <th colspan="7" class="text-center">REALISASI MK DESA/KEL</th>
                        <th colspan="7" class="text-center">REKAP HASIL PEMADANAN</th>
                    </tr>
                    <tr>
                        <th class="text-center">Target Desa</th>
                        <th class="text-center">Koordinasi</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Pemeriksaan</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Perbaikan</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Target ART</th>
                        <th class="text-center">Padan</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Tidak Padan</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody id="body_tbl"></tbody>
                <tfoot id="foot_tbl"></tfoot>
            </table>
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">WILAYAH</th>
                        <th rowspan="2" class="text-center">TARGET ART</th>
                        <th colspan="12" class="text-center">REKAP HASIL KONFIRMASI</th>
                    </tr>
                    <tr>
                        <th class="text-center">Terkonfirmasi</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Tidak Terkonfirmasi</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Ganda</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Meninggal</th>
                        <th class="text-center">%</th>
                        <th class="text-center">No Dokumen</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody id="body_tbl_t"></tbody>
                <tfoot id="foot_tbl_t"></tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="bar_desa"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="bar_art_padan"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="bar_art_konfir"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/js/apexcharts.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        // drowdown wilyah
        $('#select-propinsi').on("change.select2", function(e) {
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

        function fnum(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        var $primary = "#975AFF",
            $success = "#40C057",
            $info = "#2F8BE6",
            $warning = "#F77E17",
            $danger = "#F55252",
            $label_color_light = "#E6EAEE";
        var themeColors = [$primary, $warning, $success, $danger, $info];

        function table_data(area) {
            var body = '';
            $.ajax({
                url: "<?= base_url('dashboard/table_progres/get_table_data') ?>",
                type: "POST",
                data: {
                    area: area
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    tabel_konfirmasi(data);

                    var wilayah = [];
                    var desa_target = [];
                    var desa_realisasi = [];
                    var desa_realisasi_kl = [];
                    var desa_realisasi_ba = [];
                    var art_target = [];
                    var art_padan = [];
                    var art_tdk_padan = [];
                    var art_konfir = [];
                    var art_tdk_konfir = [];
                    var art_ganda = [];
                    var art_meninggal = [];
                    var art_no_doc = [];

                    var tot_tar_desa = tot_desa_kl = tot_percent_desa_kl = tot_desa_ba = tot_percent_desa_ba = tot_desa_art = tot_percent_desa_art = tot_tar_art = tot_art_padan = tot_percent_art_padan = tot_art_tdk_padan = tot_percent_art_tdk_padan = tot_pemadanan = tot_percent_pemadanan = 0;

                    $.each(data, function(i, v) {
                        wilayah.push(v.wilayah);
                        desa_target.push(v.tar_desa);
                        desa_realisasi.push(v.desa_art);
                        desa_realisasi_ba.push(v.desa_ba);
                        desa_realisasi_kl.push(v.desa_kl);
                        art_target.push(v.tar_art);
                        art_padan.push(v.art_padan);
                        art_tdk_padan.push(v.art_tdk_padan);
                        art_konfir.push(v.terkonfirmasi);
                        art_tdk_konfir.push(v.tdk_terkonfirmasi);
                        art_ganda.push(v.ganda);
                        art_meninggal.push(v.meninggal);
                        art_no_doc.push(v.no_doc);

                        if (v.percent_desa_kl < 20) {
                            text_kl = "danger";
                        } else if (v.percent_desa_kl >= 20 && v.percent_desa_kl < 40) {
                            text_kl = "warning";
                        } else if (v.percent_desa_kl >= 40 && v.percent_desa_kl < 60) {
                            text_kl = "info";
                        } else if (v.percent_desa_kl >= 60 && v.percent_desa_kl < 80) {
                            text_kl = "primary";
                        } else if (v.percent_desa_kl >= 80) {
                            text_kl = "success";
                        }

                        if (v.percent_desa_ba < 20) {
                            text_ba = "danger";
                        } else if (v.percent_desa_ba >= 20 && v.percent_desa_ba < 40) {
                            text_ba = "warning";
                        } else if (v.percent_desa_ba >= 40 && v.percent_desa_ba < 60) {
                            text_ba = "info";
                        } else if (v.percent_desa_ba >= 60 && v.percent_desa_ba < 80) {
                            text_ba = "primary";
                        } else if (v.percent_desa_ba >= 80) {
                            text_ba = "success";
                        }

                        if (v.percent_desa_art < 20) {
                            text_art = "danger";
                        } else if (v.percent_desa_art >= 20 && v.percent_desa_art < 40) {
                            text_art = "warning";
                        } else if (v.percent_desa_art >= 40 && v.percent_desa_art < 60) {
                            text_art = "info";
                        } else if (v.percent_desa_art >= 60 && v.percent_desa_art < 80) {
                            text_art = "primary";
                        } else if (v.percent_desa_art >= 80) {
                            text_art = "success";
                        }

                        if (v.percent_pemadanan < 20) {
                            text_pem = "danger";
                        } else if (v.percent_pemadanan >= 20 && v.percent_pemadanan < 40) {
                            text_pem = "warning";
                        } else if (v.percent_pemadanan >= 40 && v.percent_pemadanan < 60) {
                            text_pem = "info";
                        } else if (v.percent_pemadanan >= 60 && v.percent_pemadanan < 80) {
                            text_pem = "primary";
                        } else if (v.percent_pemadanan >= 80) {
                            text_pem = "success";
                        }

                        body += `
                        <tr>
                            <td class="text-left">${v.wilayah}</td>
                            <td class="text-right">${fnum(v.tar_desa)}</td>
                            <td class="text-right">${fnum(v.desa_kl)}</td>
                            <td class="text-right">${v.percent_desa_kl.toFixed(2)}<i class="fa fa-check text-${text_kl}"></i></td>
                            <td class="text-right">${fnum(v.desa_ba)}</td>
                            <td class="text-right">${v.percent_desa_ba.toFixed(2)}<i class="fa fa-check text-${text_ba}"></i></td>
                            <td class="text-right">${fnum(v.desa_art)}</td>
                            <td class="text-right">${v.percent_desa_art.toFixed(2)}<i class="fa fa-check text-${text_art}"></i></td>
                            <td class="text-right">${fnum(v.tar_art)}</td>
                            <td class="text-right">${fnum(v.art_padan)}</td>
                            <td class="text-right">${v.percent_art_padan.toFixed(2)}</td>
                            <td class="text-right">${fnum(v.art_tdk_padan)}</td>
                            <td class="text-right">${v.percent_art_tdk_padan.toFixed(2)}</td>
                            <td class="text-right">${fnum(v.pemadanan)}</td>
                            <td class="text-right">${v.percent_pemadanan.toFixed(2)}<i class="fa fa-check text-${text_pem}"></i></td>
                        </tr>
                    `;


                        tot_tar_desa += v.tar_desa;
                        tot_desa_kl += v.desa_kl;
                        tot_desa_ba += v.desa_ba;
                        tot_desa_art += v.desa_art;
                        tot_tar_art += v.tar_art;
                        tot_art_padan += v.art_padan;
                        tot_art_tdk_padan += v.art_tdk_padan;
                        tot_pemadanan += v.pemadanan;
                    });

                    generate_chart_desa(wilayah, desa_target, desa_realisasi, desa_realisasi_ba, desa_realisasi_kl);
                    generate_chart_art_padan(wilayah, art_target, art_padan, art_tdk_padan);
                    generate_chart_konfirmasi(wilayah, art_target, art_konfir, art_tdk_konfir, art_ganda, art_meninggal, art_no_doc)

                    tot_percent_desa_kl += tot_desa_kl / tot_tar_desa * 100;
                    tot_percent_desa_ba += tot_desa_ba / tot_tar_desa * 100;
                    tot_percent_desa_art += tot_desa_art / tot_tar_desa * 100;
                    tot_percent_art_padan += tot_art_padan / tot_tar_art * 100;
                    tot_percent_art_tdk_padan += tot_art_tdk_padan / tot_tar_art * 100;
                    tot_percent_pemadanan += tot_pemadanan / tot_tar_art * 100;

                    if (tot_percent_desa_kl < 20) {
                        t_text_kl = "danger";
                    } else if (tot_percent_desa_kl >= 20 && tot_percent_desa_kl < 40) {
                        t_text_kl = "warning";
                    } else if (tot_percent_desa_kl >= 40 && tot_percent_desa_kl < 60) {
                        t_text_kl = "info";
                    } else if (tot_percent_desa_kl >= 60 && tot_percent_desa_kl < 80) {
                        t_text_kl = "primary";
                    } else if (tot_percent_desa_kl >= 80) {
                        t_text_kl = "success";
                    }

                    if (tot_percent_desa_ba < 20) {
                        t_text_ba = "danger";
                    } else if (tot_percent_desa_ba >= 20 && tot_percent_desa_ba < 40) {
                        t_text_ba = "warning";
                    } else if (tot_percent_desa_ba >= 40 && tot_percent_desa_ba < 60) {
                        t_text_ba = "info";
                    } else if (tot_percent_desa_ba >= 60 && tot_percent_desa_ba < 80) {
                        t_text_ba = "primary";
                    } else if (tot_percent_desa_ba >= 80) {
                        t_text_ba = "success";
                    }

                    if (tot_percent_desa_art < 20) {
                        t_text_art = "danger";
                    } else if (tot_percent_desa_art >= 20 && tot_percent_desa_art < 40) {
                        t_text_art = "warning";
                    } else if (tot_percent_desa_art >= 40 && tot_percent_desa_art < 60) {
                        t_text_art = "info";
                    } else if (tot_percent_desa_art >= 60 && tot_percent_desa_art < 80) {
                        t_text_art = "primary";
                    } else if (tot_percent_desa_art >= 80) {
                        t_text_art = "success";
                    }

                    if (tot_percent_pemadanan < 20) {
                        t_text_pem = "danger";
                    } else if (tot_percent_pemadanan >= 20 && tot_percent_pemadanan < 40) {
                        t_text_pem = "warning";
                    } else if (tot_percent_pemadanan >= 40 && tot_percent_pemadanan < 60) {
                        t_text_pem = "info";
                    } else if (tot_percent_pemadanan >= 60 && tot_percent_pemadanan < 80) {
                        t_text_pem = "primary";
                    } else if (tot_percent_pemadanan >= 80) {
                        t_text_pem = "success";
                    }

                    var foot = `
                    <tr>
                        <th class="text-center">TOTAL</th>
                        <th class="text-right">${fnum(tot_tar_desa)}</th>
                        <th class="text-right">${fnum(tot_desa_kl)}</th>
                        <th class="text-right">${tot_percent_desa_kl.toFixed(2)}<i class="fa fa-check text-${t_text_kl}"></i></th>
                        <th class="text-right">${fnum(tot_desa_ba)}</th>
                        <th class="text-right">${tot_percent_desa_ba.toFixed(2)}<i class="fa fa-check text-${t_text_ba}"></i></th>
                        <th class="text-right">${fnum(tot_desa_art)}</th>
                        <th class="text-right">${tot_percent_desa_art.toFixed(2)}<i class="fa fa-check text-${t_text_art}"></i></th>
                        <th class="text-right">${fnum(tot_tar_art)}</th>
                        <th class="text-right">${fnum(tot_art_padan)}</th>
                        <th class="text-right">${tot_percent_art_padan.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_art_tdk_padan)}</th>
                        <th class="text-right">${tot_percent_art_tdk_padan.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_pemadanan)}</th>
                        <th class="text-right">${tot_percent_pemadanan.toFixed(2)}<i class="fa fa-check text-${t_text_pem}"></i></th>
                    </tr>
                `;

                    $('#body_tbl').html(body);
                    $('#foot_tbl').html(foot);
                    $('.overlay').addClass('hidden');
                }
            })
        }

        function tabel_konfirmasi(e) {
            let body = "";
            var tot_tar_art = tot_terkonfirmasi = tot_tdk_terkonfirmasi = tot_ganda = tot_meninggal = tot_no_doc = tot_per_terkonfirmasi = tot_per_tdk_terkonfirmasi = tot_per_ganda = tot_per_meninggal = tot_per_no_doc = tot_konfirmasi = tot_per_konfirmasi = 0
            $.each(e, function(i, v) {
                body += `
                    <tr>
                        <td class="text-left">${v.wilayah}</td>
                        <td class="text-right">${fnum(v.tar_art)}</td>
                        <td class="text-right">${fnum(v.terkonfirmasi)}</td>
                        <td class="text-right">${v.percent_art_terkonfirmasi.toFixed(2)}</td>
                        <td class="text-right">${fnum(v.tdk_terkonfirmasi)}</td>
                        <td class="text-right">${v.percent_art_tdk_terkonfirmasi.toFixed(2)}</td>
                        <td class="text-right">${fnum(v.ganda)}</td>
                        <td class="text-right">${v.percent_art_ganda.toFixed(2)}</td>
                        <td class="text-right">${fnum(v.meninggal)}</td>
                        <td class="text-right">${v.percent_art_meninggal.toFixed(2)}</td>
                        <td class="text-right">${fnum(v.no_doc)}</td>
                        <td class="text-right">${v.percent_art_no_doc.toFixed(2)}</td>
                        <td class="text-right">${fnum(v.konfirmasi)}</td>
                        <td class="text-right">${v.precent_konfirmasi.toFixed(2)}</td>
                    </tr>
                `;

                tot_tar_art += v.tar_art;
                tot_terkonfirmasi += v.terkonfirmasi;
                tot_tdk_terkonfirmasi += v.tdk_terkonfirmasi;
                tot_ganda += v.ganda;
                tot_meninggal += v.meninggal;
                tot_no_doc += v.no_doc;
                tot_konfirmasi += v.konfirmasi;
            })

            tot_per_terkonfirmasi = tot_terkonfirmasi / tot_tar_art * 100;
            tot_per_tdk_terkonfirmasi = tot_tdk_terkonfirmasi / tot_tar_art * 100;
            tot_per_ganda = tot_ganda / tot_tar_art * 100;
            tot_per_meninggal = tot_meninggal / tot_tar_art * 100;
            tot_per_no_doc = tot_no_doc / tot_tar_art * 100;
            tot_per_no_doc = tot_no_doc / tot_tar_art * 100;
            tot_per_konfirmasi = tot_konfirmasi / tot_tar_art * 100;

            var foot = `
                    <tr>
                        <th class="text-center">TOTAL</th>
                        <th class="text-right">${fnum(tot_tar_art)}</th>
                        <th class="text-right">${fnum(tot_terkonfirmasi)}</th>
                        <th class="text-right">${tot_per_terkonfirmasi.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_tdk_terkonfirmasi)}</th>
                        <th class="text-right">${tot_per_tdk_terkonfirmasi.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_ganda)}</th>
                        <th class="text-right">${tot_per_ganda.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_meninggal)}</th>
                        <th class="text-right">${tot_per_meninggal.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_no_doc)}</th>
                        <th class="text-right">${tot_per_no_doc.toFixed(2)}</th>
                        <th class="text-right">${fnum(tot_konfirmasi)}</th>
                        <th class="text-right">${tot_per_konfirmasi.toFixed(2)}</th>
                    </tr>
                `;

            $('#body_tbl_t').html(body);
            $('#foot_tbl_t').html(foot);
        }

        function generate_chart_desa(wilayah, desa_target, desa_realisasi, desa_realisasi_ba, desa_realisasi_kl) {
            $('#bar_desa').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: desa_target
                }, {
                    name: 'Koordinasi',
                    data: desa_realisasi_kl
                }, {
                    name: 'Pemeriksaan',
                    data: desa_realisasi_ba
                }, {
                    name: 'Perbaikan',
                    data: desa_realisasi
                }],
                chart: {
                    type: 'bar',
                    height: 1000
                },
                colors: ['#105688', '#feb64b', '#fde53c', '#9ac539'],
                title: {
                    text: 'CHART PENCAPAIAN PROGRES DESA',
                    align: 'center'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: false,
                    // offsetX: -6,
                    // style: {
                    //     labels: {
                    //         formatter: function (value) {
                    //             return fnum(value);
                    //         }
                    //     },
                    //     fontSize: '12px',
                    //     colors: ['#fff']
                    // }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: wilayah,
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#bar_desa"), options);
            chart.render();
        }

        function generate_chart_art_padan(wilayah, art_target, art_padan, art_tdk_padan) {
            $('#bar_art_padan').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: art_target
                }, {
                    name: 'Padan',
                    data: art_padan
                }, {
                    name: 'Tidak Padan',
                    data: art_tdk_padan
                }],
                chart: {
                    type: 'bar',
                    height: 900
                },
                title: {
                    text: 'CHART REKAP HASIL PEMADANAN',
                    align: 'center'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: false,
                    // offsetX: -6,
                    // style: {
                    //     fontSize: '12px',
                    //     colors: ['#fff']
                    // }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: wilayah,
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#bar_art_padan"), options);
            chart.render();
        }

        function generate_chart_konfirmasi(wilayah, art_target, art_konfir, art_tdk_konfir, art_ganda, art_meninggal, art_no_doc) {
            $('#bar_art_konfir').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: art_target
                }, {
                    name: 'Terkonfirmasi',
                    data: art_konfir
                }, {
                    name: 'Tidak Terkonfirmasi',
                    data: art_tdk_konfir
                }, {
                    name: 'Ganda',
                    data: art_ganda
                }, {
                    name: 'Meninggal',
                    data: art_meninggal
                }, {
                    name: 'Tidak Ada Dokumen',
                    data: art_no_doc
                }],
                chart: {
                    type: 'bar',
                    height: 1600
                },
                title: {
                    text: 'CHART REKAP HASIL KONFIRMASI',
                    align: 'center'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: false,
                    // offsetX: -6,
                    // style: {
                    //     fontSize: '12px',
                    //     colors: ['#fff']
                    // }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: wilayah,
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#bar_art_konfir"), options);
            chart.render();
        }

        function filter_area() {
            var area = '';
            s_prov = $('#select-propinsi').val();
            s_regi = $('#select-kabupaten').val();
            s_dist = $('#select-kecamatan').val();
            if (s_prov == 0 && s_regi == 0 && s_dist == 0) {
                area = '';
            } else if (s_prov != 0 && s_regi == 0 && s_dist == 0) {
                area = s_prov;
            } else if (s_prov != 0 && s_regi != 0 && s_dist == 0) {
                area = s_prov + s_regi;
            } else {
                area = s_prov + s_regi + s_dist;
            }

            table_data(area);
        }

        if ('<?= $role ?>' == 'korwil' || '<?= $role ?>' == 'korkab') {
            filter_area()
        } else {
            table_data(area = '');
        }

        $('#filter_btn').on('click', function() {
            filter_area();
            $('.overlay').removeClass('hidden');
        })

    })
</script>