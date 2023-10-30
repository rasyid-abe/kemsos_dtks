<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/vendors/css/apexcharts.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/pages/charts-apex.css">
<link rel="stylesheet" href="<?= base_url(THEMES_BACKEND); ?>app-assets/css/abe-style.css">

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
    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h5>A. STATUS PROSES RUTA</h5>
                <hr>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="margin-top:-15px">
                    <table class="table table-sm table-striped table-bordered" id="dt-table">
                        <thead>
                            <tr>
                                <th colspan="5">Status Rumah Tangga (RUTA)</th>
                            </tr>
                            <tr>
                                <th class="text-center">KODE</th>
                                <th>STATUS PRELIST</th>
                                <th>PRELIST_AWAL</th>
                                <th>PROSES</th>
                                <th>SELESAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><span class="p0" style="font-size:10px">P0</span></td>
                                <td>Prelist Awal</td>
                                <td class="text-right" id="p0_1">0</td>
                                <td></td>
                                <td class="text-right" id="p0_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="p1" style="font-size:10px">P1</span></td>
                                <td>Publish Korwil</td>
                                <td></td>
                                <td class="text-right" id="p1_1">0</td>
                                <td class="text-right" id="p1_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="p2" style="font-size:10px">P2</span></td>
                                <td>Publish Korkab</td>
                                <td></td>
                                <td class="text-right" id="p2_1">0</td>
                                <td class="text-right" id="p2_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="p3" style="font-size:10px">P3</span></td>
                                <td>Publish Petugas</td>
                                <td></td>
                                <td class="text-right" id="p3_1">0</td>
                                <td class="text-right" id="p3_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="m1" style="font-size:10px">M1</span></td>
                                <td>Simpan Pengumpul</td>
                                <td></td>
                                <td class="text-right" id="m1_1">0</td>
                                <td class="text-right" id="m1_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="m2" style="font-size:10px">M2</span></td>
                                <td>Proses MK</td>
                                <td></td>
                                <td class="text-right" id="m2_1">0</td>
                                <td class="text-right" id="m2_2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="m4" style="font-size:10px">M4</span></td>
                                <td>Ruta Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="m4_1">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="m4" style="font-size:10px">M4a</span></td>
                                <td>Ruta Tidak Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="m4a_1">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Total Hasil Konfimrasi NIK</th>
                                <th></th>
                                <th></th>
                                <th class="text-right" id="tot_nik"></th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-sm table-striped table-bordered" id="dt-table">
                        <thead>
                            <tr>
                                <th colspan="4">Status ART Hasil MK Desa/Kelurahan</th>
                            </tr>
                            <tr>
                                <th>KODE</th>
                                <th>STATUS ART</th>
                                <th>PRELIST AWAL</th>
                                <th>JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Prelist Awal</td>
                                <td class="text-right" id="pre_awal_a">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>1</strong></td>
                                <td>Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="terkonfirmasi">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>2</strong></td>
                                <td>Tidak Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="tidak_terkonfirmasi">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>3</strong></td>
                                <td>Ganda</td>
                                <td></td>
                                <td class="text-right" id="ganda">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>4</strong></td>
                                <td>Meninggal</td>
                                <td></td>
                                <td class="text-right" id="meninggal">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>5</strong></td>
                                <td>Tidak Memiliki Dokumen Kependudukan</td>
                                <td></td>
                                <td class="text-right" id="no_cokumen">0</td>
                            </tr>
                            <tr>
                                <th class="text-left" colspan="3">Total Proses ART Hasil MK Desa</th>
                                <th class="text-right" id="total_mkdesa">0</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="ch_status_a"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="ch_status_art"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h5>B. STATUS PROSES ART</h5>
                <hr>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="margin-top:-15px">
                    <table class="table table-sm table-striped table-bordered" id="dt-table">
                        <thead>
                            <tr>
                                <th colspan="4">Status Proses Pemadanan ART</th>
                            </tr>
                            <tr>
                                <th class="text-center">KODE</th>
                                <th class="text-left">STATUS ART</th>
                                <th class="text-center">AWAL</th>
                                <th class="text-center">PROSES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Prelist Awal</td>
                                <td class="text-right" id="pre_awal_b">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="mk" style="font-size:10px">MK</span></td>
                                <td>Terkonfirmasi Padan</td>
                                <td></td>
                                <td class="text-right" id="mk">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="mka" style="font-size:10px">MKa</span></td>
                                <td>Terkonfirmasi Tidak Padan</td>
                                <td></td>
                                <td class="text-right" id="mka">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="mkb" style="font-size:10px">MKb</span></td>
                                <td>Tidak Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="mkb">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q1a" style="font-size:10px">Q1</span></td>
                                <td>Tidak Padan Dalam Perbaikan</td>
                                <td></td>
                                <td class="text-right" id="q1">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q1a" style="font-size:10px">Q1a</span></td>
                                <td>Tidak Terkonfirmasi Dalam Perbaikan</td>
                                <td></td>
                                <td class="text-right" id="q1a">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q1a" style="font-size:10px">Q1b</span></td>
                                <td>Lolos QC Korkab Tidak Terkonfirmasi</td>
                                <td></td>
                                <td class="text-right" id="q1b">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q2" style="font-size:10px">Q2</span></td>
                                <td>Padan</td>
                                <td></td>
                                <td class="text-right" id="q2">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q2a" style="font-size:10px">Q2a</span></td>
                                <td>Tidak Padan</td>
                                <td></td>
                                <td class="text-right" id="q2a">0</td>
                            </tr>
                            <tr>
                                <td class="text-center"><span class="q2b" style="font-size:10px">Q2b</span></td>
                                <td>Tidak Terkonfirmasi Padan</td>
                                <td></td>
                                <td class="text-right" id="q2b">0</td>
                            </tr>
                            <tr>Lolos QC Korkab Tidak Terkonfirmasi
                                <th class="text-left" colspan="3">Total Proses Pemadanan ART</th>
                                <th class="text-right" id="total_pemadanan_art">0</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="ch_status_b"></div>
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

        function status_ruta(area) {
            $.ajax({
                url: "<?= base_url('dashboard/status_proses/get_status_ruta') ?>",
                type: "POST",
                data: {
                    area: area
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#p0_1').html(fnum(data.status_art.jumlah_data));
                    $('#p1_1').html(fnum(data.p1 < 0 ? 0 : data.p1));
                    $('#p2_1').html(fnum(data.p2 < 0 ? 0 : data.p2));
                    $('#p3_1').html(fnum(data.p3 < 0 ? 0 : data.p3));
                    $('#m1_1').html(fnum(data.m1 < 0 ? 0 : data.m1));
                    $('#m2_1').html(fnum(data.m2 < 0 ? 0 : data.m2));
                    $('#m4_1').html(fnum(data.m4 < 0 ? 0 : data.m4));
                    $('#m4a_1').html(fnum(data.m4a < 0 ? 0 : data.m4a));

                    p0_2 = data.status_art.jumlah_data - 0;
                    p1_2 = p0_2 - data.p1;
                    p2_2 = p1_2 - data.p2;
                    p3_2 = p2_2 - data.p3;
                    m1_2 = p3_2 - data.m1;
                    m2_2 = m1_2 - data.m2;
                    tot_nik = data.m4 + data.m4a;

                    $('#p0_2').html(fnum(p0_2));
                    $('#p1_2').html(fnum(p1_2));
                    $('#p2_2').html(fnum(p2_2));
                    $('#p3_2').html(fnum(p3_2));
                    $('#m1_2').html(fnum(m1_2));
                    $('#m2_2').html(fnum(m2_2));
                    $('#tot_nik').html(fnum(tot_nik));

                    $('#pre_awal_a').html(fnum(data.status_art.jumlah_data));
                    $('#terkonfirmasi').html(fnum(data.status_art.terkonfirmasi));
                    $('#tidak_terkonfirmasi').html(fnum(data.status_art.tidak_terkonfirmasi));
                    $('#ganda').html(fnum(data.status_art.ganda));
                    $('#meninggal').html(fnum(data.status_art.meninggal));
                    $('#no_cokumen').html(fnum(data.status_art.no_doc));
                    $('#total_mkdesa').html(fnum(data.status_art.no_doc + data.status_art.meninggal + data.status_art.ganda + data.status_art.tidak_terkonfirmasi + data.status_art.terkonfirmasi));

                    $('#pre_awal_b').html(fnum(data.status_art.jumlah_data));
                    $('#mk').html(fnum(data.mk));
                    $('#mka').html(fnum(data.mka));
                    $('#mkb').html(fnum(data.mkb));
                    $('#q1').html(fnum(data.q1));
                    $('#q1a').html(fnum(data.q1a));
                    $('#q1b').html(fnum(data.q1b));
                    $('#q2').html(fnum(data.q2));
                    $('#q2a').html(fnum(data.q2a));
                    $('#q2b').html(fnum(data.q2b));
                    $('#total_pemadanan_art').html(fnum(data.q2b + data.q2a + data.q2 + data.q1a + data.q1b + data.q1 + data.mkb + data.mka + data.mk));

                    arr_ruta = [
                        data.p1,
                        data.p2,
                        data.p3,
                        data.m1,
                        data.m2,
                        data.m4,
                        data.m4a
                    ];

                    arr_konfirmasi = [
                        data.status_art.terkonfirmasi,
                        data.status_art.tidak_terkonfirmasi,
                        data.status_art.ganda,
                        data.status_art.meninggal,
                        data.status_art.no_doc
                    ];

                    arr_pemadanan = [
                        data.mk,
                        data.mka,
                        data.mkb,
                        data.q1,
                        data.q1a,
                        data.q2,
                        data.q2a,
                        data.q2b
                    ];

                    chart_status_konfirmasi(arr_konfirmasi);
                    chart_status_ruta(arr_ruta);
                    chart_status_pemadanan(arr_pemadanan);

                    $('.overlay').addClass('hidden');
                }
            });
        }

        function chart_status_ruta(data) {
            $('#ch_status_a').html('');
            var options = {
                series: [{
                    name: 'Total',
                    data: data
                }],
                chart: {
                    height: 408,
                    type: 'bar',
                },
                title: {
                    text: 'CHART STATUS RUTA',
                    align: 'center'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return fnum(val);
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: ["P1", "P2", "P3", "M1", "M2", "M4", "M4a"],
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        formatter: function(val) {
                            return fnum(val);
                        }
                    }

                },
            };

            var chart = new ApexCharts(document.querySelector("#ch_status_a"), options);
            chart.render();
        }

        function chart_status_konfirmasi(data) {
            $('#ch_status_art').html('');
            var options = {
                dataLables: {
                    enabled: true,
                    formatter: function(val) {
                        return fnum(val);
                    }
                },
                series: data,
                title: {
                    text: 'CHART STATUS ART HASIL MK DESA',
                    align: 'center'
                },
                chart: {
                    width: 435,
                    type: 'pie',
                },
                labels: ['Terkonfirmasi', 'Tidak Terkonfirmasi', 'Data Ganda', 'Meninggal', 'Tidak Ada Dokumen'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#ch_status_art"), options);
            chart.render();
        }

        function chart_status_pemadanan(data) {
            $('#ch_status_b').html('');
            var options = {
                series: [{
                    name: 'Total',
                    data: data
                }],
                title: {
                    text: 'CHART STATUS PROSES PEMADANAN ART',
                    align: 'center'
                },
                chart: {
                    type: 'bar',
                    height: 523
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return fnum(val);
                    },
                    position: 'left',
                    offsetX: 20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: ['MK', 'MKa', 'MKb', 'Q1', 'Q1a', 'Q2', 'Q2a', 'Q2b'],
                    labels: {
                        show: true,
                        formatter: function(val) {
                            return fnum(val);
                        }
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#ch_status_b"), options);
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

            status_ruta(area);
        }

        if ('<?= $role ?>' == 'korwil' || '<?= $role ?>' == 'korkab') {
            filter_area()
        } else {
            status_ruta(area = '');
        }

        $('#filter_btn').on('click', function() {
            filter_area();
            $('.overlay').removeClass('hidden');
        })

    })
</script>