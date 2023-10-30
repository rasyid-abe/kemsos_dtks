<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/apexcharts.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/pages/charts-apex.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/abe-style.css">
<style media="screen">
    table {
        font-size: 9pt;
    }
</style>
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
        <?php if (isset($cari)) {
            echo $cari;
        } ?>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-inverse bg-info">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="card-text" id="ruta_c">memuat...</h3>
                            <span>Total Progres Ruta</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-user float-right" style="font-size:40px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-inverse bg-warning">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="card-text" id="art_c">memuat...</h3>
                            <span>Total Progres ART</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-users float-right" style="font-size:40px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-inverse bg-danger">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="card-text" id="art_today_c">memuat...</h3>
                            <span>Progres ART Hari Ini</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-trending-up float-right" style="font-size:30px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-inverse bg-success">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="card-text" id="art_percent">memuat...</h3>
                            <span>Persentase ART</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-percent float-right" style="font-size:40px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-head p-3">
                    <h5 style="display: inline;">REALISASI PENCAPAIAN MONITORING</h5>
                    <button class="btn-info btn float-right" id="show_dtl_tbl">DETAIL PROGRES</button>
                </div>
                <div class="card-body">
                    <div id="line-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="show_detail" class="hidden">
    <div class="card">
        <div class="card-header">
            <h4>Table Progres</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered" id="dt-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">WILAYAH</th>
                            <th colspan="3" class="text-center">PROGRES KOORDINASI (DESA)</th>
                            <th rowspan="2" class="text-center">TARGET ART</th>
                            <th colspan="4" class="text-center">REKAP HASIL KONFIRMASI</th>
                            <th colspan="4" class="text-center">REKAP HASIL PEMADANAN</th>
                        </tr>
                        <tr>
                            <th class="text-center">TARGET</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center">%</th>
                            <th class="text-center">TERKONFIRMASI</th>
                            <th class="text-center">%</th>
                            <th class="text-center">TIDAK TERKONFIRMASI</th>
                            <th class="text-center">%</th>
                            <th class="text-center">PADAN</th>
                            <th class="text-center">%</th>
                            <th class="text-center">TIDAK PADAN</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody id="body_tbl"></tbody>
                    <tfoot id="foot_tbl"></tfoot>
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
                        <div id="bar_art"></div>
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
        var themeColors = [$primary, $success, $info, $warning, $danger];

        function header_count(area) {
            $.ajax({
                url: "<?= base_url('dashboard/eksekutif/header_count') ?>",
                type: "POST",
                data: {
                    area: area
                },
                dataType: "json",
                success: function(data) {
                    $('#art_percent').html(data.precent);
                    $('#art_today_c').html(fnum(data.art_today));
                    $('#art_c').html(fnum(data.art));
                    $('#ruta_c').html(fnum(data.ruta));
                }
            })
        }

        function chart_art(area, lo) {
            $.ajax({
                url: "<?= base_url('dashboard/eksekutif/get_data_chart') ?>",
                type: "POST",
                data: {
                    area: area
                },
                dataType: "json",
                success: function(data) {
                    $('#line-chart').html('');
                    generate_chart(data)
                    console.log(lo);
                    if (lo != 1) {
                        $('.overlay').addClass('hidden');
                    }
                },
            });
        }

        function generate_chart(data) {
            lineChartOptions = {
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                colors: themeColors,
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                series: [{
                    name: 'Target',
                    data: data.target
                }, {
                    name: 'Realisasi',
                    data: data.real
                }],
                grid: {
                    row: {
                        colors: ['#F5F5F5', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: data.tgl,
                },
                yaxis: {
                    tickAmount: 10,
                    labels: {
                        formatter: function(value) {
                            return fnum(value);
                        }
                    },
                }
            }

            var lineChart = new ApexCharts(
                document.querySelector("#line-chart"),
                lineChartOptions
            );
            lineChart.render();
        }

        function table_data(area) {
            var body = '';
            $.ajax({
                url: "<?= base_url('dashboard/eksekutif/get_table_data') ?>",
                type: "POST",
                data: {
                    area: area
                },
                dataType: "json",
                success: function(data) {
                    var wilayah = [];
                    var desa_target = [];
                    var desa_realisasi_kl = [];
                    var art_target = [];
                    var art_real_terkonfirmasi = [];
                    var art_real_tdk_terkonfirmasi = [];
                    var art_real_padan = [];
                    var art_real_tdk_padan = [];

                    var tot_tar_desa = tot_real_desa_kl = tot_tar_art = tot_art_padan = tot_art_tdk_padan = tot_art_terkonfirmasi = tot_art_tdk_terkonfirmasi = tot_percent_art_padan = tot_percent_art_tdk_padan = tot_percent_art_terkonfirmasi = tot_percent_art_tdk_terkonfirmasi = 0;

                    $.each(data, function(i, v) {
                        wilayah.push(v.wilayah);
                        desa_target.push(v.tar_desa);
                        desa_realisasi_kl.push(v.tot_desa_kl);
                        art_target.push(v.tar_art);
                        art_real_terkonfirmasi.push(v.art_terkonfirmasi);
                        art_real_tdk_terkonfirmasi.push(v.art_tdk_terkonfirmasi);
                        art_real_padan.push(v.art_padan);
                        art_real_tdk_padan.push(v.art_tdk_padan);


                        if (v.percent_desa_kl < 20) {
                            text_d = "danger";
                        } else if (v.percent_desa_kl >= 20 && v.percent_desa_kl < 40) {
                            text_d = "warning";
                        } else if (v.percent_desa_kl >= 40 && v.percent_desa_kl < 60) {
                            text_d = "info";
                        } else if (v.percent_desa_kl >= 60 && v.percent_desa_kl < 80) {
                            text_d = "primary";
                        } else if (v.percent_desa_kl >= 80) {
                            text_d = "success";
                        }

                        if (v.percent_art_terkonfirmasi < 20) {
                            text_t = "danger";
                        } else if (v.percent_art_terkonfirmasi >= 20 && v.percent_art_terkonfirmasi < 40) {
                            text_t = "warning";
                        } else if (v.percent_art_terkonfirmasi >= 40 && v.percent_art_terkonfirmasi < 60) {
                            text_t = "info";
                        } else if (v.percent_art_terkonfirmasi >= 60 && v.percent_art_terkonfirmasi < 80) {
                            text_t = "primary";
                        } else if (v.percent_art_terkonfirmasi >= 80) {
                            text_t = "success";
                        }

                        if (v.percent_art_tdk_terkonfirmasi < 20) {
                            text_tt = "danger";
                        } else if (v.percent_art_tdk_terkonfirmasi >= 20 && v.percent_art_tdk_terkonfirmasi < 40) {
                            text_tt = "warning";
                        } else if (v.percent_art_tdk_terkonfirmasi >= 40 && v.percent_art_tdk_terkonfirmasi < 60) {
                            text_tt = "info";
                        } else if (v.percent_art_tdk_terkonfirmasi >= 60 && v.percent_art_tdk_terkonfirmasi < 80) {
                            text_tt = "primary";
                        } else if (v.percent_art_tdk_terkonfirmasi >= 80) {
                            text_tt = "success";
                        }

                        if (v.percent_art_padan < 20) {
                            text_p = "danger";
                        } else if (v.percent_art_padan >= 20 && v.percent_art_padan < 40) {
                            text_p = "warning";
                        } else if (v.percent_art_padan >= 40 && v.percent_art_padan < 60) {
                            text_p = "info";
                        } else if (v.percent_art_padan >= 60 && v.percent_art_padan < 80) {
                            text_p = "primary";
                        } else if (v.percent_art_padan >= 80) {
                            text_p = "success";
                        }

                        if (v.percent_art_tdk_padan < 20) {
                            text_tp = "danger";
                        } else if (v.percent_art_tdk_padan >= 20 && v.percent_art_tdk_padan < 40) {
                            text_tp = "warning";
                        } else if (v.percent_art_tdk_padan >= 40 && v.percent_art_tdk_padan < 60) {
                            text_tp = "info";
                        } else if (v.percent_art_tdk_padan >= 60 && v.percent_art_tdk_padan < 80) {
                            text_tp = "primary";
                        } else if (v.percent_art_tdk_padan >= 80) {
                            text_tp = "success";
                        }

                        body += `
                    <tr>
                    <td class="text-left">${v.wilayah}</td>
                    <td class="text-right">${fnum(v.tar_desa)}</td>
                    <td class="text-right">${fnum(v.tot_desa_kl)}</td>
                    <td class="text-right">${v.percent_desa_kl.toFixed(2)}<i class="fa fa-check text-${text_d}"></i></td>
                    <td class="text-right">${fnum(v.tar_art)}</td>
                    <td class="text-right">${fnum(v.art_terkonfirmasi)}</td>
                    <td class="text-right">${v.percent_art_terkonfirmasi.toFixed(2)}<i class="fa fa-check text-${text_t}"></i></td>
                    <td class="text-right">${fnum(v.art_tdk_terkonfirmasi)}</td>
                    <td class="text-right">${v.percent_art_tdk_terkonfirmasi.toFixed(2)}<i class="fa fa-check text-${text_tt}"></i></td>
                    <td class="text-right">${fnum(v.art_padan)}</td>
                    <td class="text-right">${v.percent_art_padan.toFixed(2)}<i class="fa fa-check text-${text_p}"></i></td>
                    <td class="text-right">${fnum(v.art_tdk_padan)}</td>
                    <td class="text-right">${v.percent_art_tdk_padan.toFixed(2)}<i class="fa fa-check text-${text_tp}"></i></td>
                    </tr>
                    `;

                        tot_tar_desa += v.tar_desa;
                        tot_real_desa_kl += v.tot_desa_kl;
                        tot_tar_art += v.tar_art;
                        tot_art_padan += v.art_padan;
                        tot_art_tdk_padan += v.art_tdk_padan;
                        tot_art_terkonfirmasi += v.art_terkonfirmasi;
                        tot_art_tdk_terkonfirmasi += v.art_tdk_terkonfirmasi;
                    });

                    generate_chart_desa(wilayah, desa_target, desa_realisasi_kl);
                    generate_chart_art_konfirmasi(wilayah, art_target, art_real_terkonfirmasi, art_real_tdk_terkonfirmasi);
                    generate_chart_art_padan(wilayah, art_target, art_real_padan, art_real_tdk_padan);

                    tot_percent_desa_kl = tot_real_desa_kl / tot_tar_desa * 100;
                    tot_percent_art_padan += tot_art_padan / tot_tar_art * 100;
                    tot_percent_art_tdk_padan += tot_art_tdk_padan / tot_tar_art * 100;
                    tot_percent_art_terkonfirmasi += tot_art_terkonfirmasi / tot_tar_art * 100;
                    tot_percent_art_tdk_terkonfirmasi += tot_art_tdk_terkonfirmasi / tot_tar_art * 100;

                    if (tot_percent_desa_kl < 20) {
                        tot_text_d = "danger";
                    } else if (tot_percent_desa_kl >= 20 && tot_percent_desa_kl < 40) {
                        tot_text_d = "warning";
                    } else if (tot_percent_desa_kl >= 40 && tot_percent_desa_kl < 60) {
                        tot_text_d = "info";
                    } else if (tot_percent_desa_kl >= 60 && tot_percent_desa_kl < 80) {
                        tot_text_d = "primary";
                    } else if (tot_percent_desa_kl >= 80) {
                        tot_text_d = "success";
                    }

                    if (tot_percent_art_terkonfirmasi < 20) {
                        tot_text_t = "danger";
                    } else if (tot_percent_art_terkonfirmasi >= 20 && tot_percent_art_terkonfirmasi < 40) {
                        tot_text_t = "warning";
                    } else if (tot_percent_art_terkonfirmasi >= 40 && tot_percent_art_terkonfirmasi < 60) {
                        tot_text_t = "info";
                    } else if (tot_percent_art_terkonfirmasi >= 60 && tot_percent_art_terkonfirmasi < 80) {
                        tot_text_t = "primary";
                    } else if (tot_percent_art_terkonfirmasi >= 80) {
                        tot_text_t = "success";
                    }

                    if (tot_percent_art_tdk_terkonfirmasi < 20) {
                        tot_text_tt = "danger";
                    } else if (tot_percent_art_tdk_terkonfirmasi >= 20 && tot_percent_art_tdk_terkonfirmasi < 40) {
                        tot_text_tt = "warning";
                    } else if (tot_percent_art_tdk_terkonfirmasi >= 40 && tot_percent_art_tdk_terkonfirmasi < 60) {
                        tot_text_tt = "info";
                    } else if (tot_percent_art_tdk_terkonfirmasi >= 60 && tot_percent_art_tdk_terkonfirmasi < 80) {
                        tot_text_tt = "primary";
                    } else if (tot_percent_art_tdk_terkonfirmasi >= 80) {
                        tot_text_tt = "success";
                    }

                    if (tot_percent_art_padan < 20) {
                        tot_text_p = "danger";
                    } else if (tot_percent_art_padan >= 20 && tot_percent_art_padan < 40) {
                        tot_text_p = "warning";
                    } else if (tot_percent_art_padan >= 40 && tot_percent_art_padan < 60) {
                        tot_text_p = "info";
                    } else if (tot_percent_art_padan >= 60 && tot_percent_art_padan < 80) {
                        tot_text_p = "primary";
                    } else if (tot_percent_art_padan >= 80) {
                        tot_text_p = "success";
                    }

                    if (tot_percent_art_tdk_padan < 20) {
                        tot_text_tp = "danger";
                    } else if (tot_percent_art_tdk_padan >= 20 && tot_percent_art_tdk_padan < 40) {
                        tot_text_tp = "warning";
                    } else if (tot_percent_art_tdk_padan >= 40 && tot_percent_art_tdk_padan < 60) {
                        tot_text_tp = "info";
                    } else if (tot_percent_art_tdk_padan >= 60 && tot_percent_art_tdk_padan < 80) {
                        tot_text_tp = "primary";
                    } else if (tot_percent_art_tdk_padan >= 80) {
                        tot_text_tp = "success";
                    }

                    var foot = `
                <tr>
                <th class="text-center">TOTAL</th>
                <th class="text-right">${fnum(tot_tar_desa)}</th>
                <th class="text-right">${fnum(tot_real_desa_kl)}</th>
                <th class="text-right">${tot_percent_desa_kl.toFixed(2)}<i class="fa fa-check text-${tot_text_d}"></i></th>
                <th class="text-right">${fnum(tot_tar_art)}</th>
                <th class="text-right">${fnum(tot_art_terkonfirmasi)}</th>
                <th class="text-right">${tot_percent_art_terkonfirmasi.toFixed(2)}<i class="fa fa-check text-${tot_text_t}"></i></th>
                <th class="text-right">${fnum(tot_art_tdk_terkonfirmasi)}</th>
                <th class="text-right">${tot_percent_art_tdk_terkonfirmasi.toFixed(2)}<i class="fa fa-check text-${tot_text_tt}"></i></th>
                <th class="text-right">${fnum(tot_art_padan)}</th>
                <th class="text-right">${tot_percent_art_padan.toFixed(2)}<i class="fa fa-check text-${tot_text_p}"></i></th>
                <th class="text-right">${fnum(tot_art_tdk_padan)}</th>
                <th class="text-right">${tot_percent_art_tdk_padan.toFixed(2)}<i class="fa fa-check text-${tot_text_tp}"></i></th>
                </tr>
                `;

                    $('#body_tbl').html(body);
                    $('#foot_tbl').html(foot);
                    $('.overlay').addClass('hidden');
                }
            })
        }

        function generate_chart_desa(wilayah, desa_target, desa_realisasi_kl) {
            $('#bar_desa').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: desa_target
                }, {
                    name: 'Koordinasi',
                    data: desa_realisasi_kl
                }],
                chart: {
                    type: 'bar',
                    height: 800
                },
                colors: ['#105688', '#feb64b', '#fde53c', '#9ac539'],
                title: {
                    text: 'PROGRES KORDINASI DESA',
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

        function generate_chart_art_konfirmasi(wilayah, art_target, art_real_terkonfirmasi, art_real_tdk_terkonfirmasi) {
            $('#bar_art').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: art_target
                }, {
                    name: 'Terkonfimasi',
                    data: art_real_terkonfirmasi
                }, {
                    name: 'Tidak Terkonfimasi',
                    data: art_real_tdk_terkonfirmasi
                }],
                chart: {
                    type: 'bar',
                    height: 1000
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

            var chart = new ApexCharts(document.querySelector("#bar_art"), options);
            chart.render();
        }

        function generate_chart_art_padan(wilayah, art_target, art_real_padan, art_real_tdk_padan) {
            $('#bar_art_padan').html('');
            var options = {
                series: [{
                    name: 'Target',
                    data: art_target
                }, {
                    name: 'Padan',
                    data: art_real_padan
                }, {
                    name: 'Tidak Padan',
                    data: art_real_tdk_padan
                }],
                chart: {
                    type: 'bar',
                    height: 1000
                },
                colors: themeColors,
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

        function filter_area(e) {
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


            lo = e != 0 ? 1 : 0;
            if (e != 0) {
                table_data(area);
            } else {
                chart_art(area, lo);
                header_count(area);

            }
        }

        // if ('<?= $role ?>' == 'korwil' || '<?= $role ?>' == 'korkab') {
        //     filter_area(0)
        // } else {
        //     header_count(area = '');
        //     chart_art(area = '', 0);
        //     // table_data(area = '');
        // }
        $('.overlay').addClass('hidden');

        $('#filter_btn').on('click', function() {
            $('#show_detail').addClass('hidden');
            filter_area(0);
            $('.overlay').removeClass('hidden');
        })

        $('#show_dtl_tbl').on('click', function() {
            filter_area(1);
            $('#show_detail').removeClass('hidden');
            $('.overlay').removeClass('hidden');
        })

    })
</script>