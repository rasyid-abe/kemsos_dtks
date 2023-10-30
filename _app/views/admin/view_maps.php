<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/css/apexcharts.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/pages/charts-apex.css">
<link rel="stylesheet" href="<?= base_url( THEMES_BACKEND );?>app-assets/css/abe-style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin=""/>
<style media="screen">
#mapid { height: 480px; }
</style>
<!-- <div id="loader"> -->
    <div class="overlay"><div class="pg_body"><div class="cssload-thecube"><div class="cssload-cube cssload-c1"></div><div class="cssload-cube cssload-c2"></div><div class="cssload-cube cssload-c4"></div><div class="cssload-cube cssload-c3"></div></div></div></div>
<!-- </div> -->

<div class="row mt-3">
    <div class="col-12">
        <?php if ( isset( $cari ) ) { echo $cari; } ?>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Peta Sebaran Data</h4>
            </div>
            <div class="card-body">
                <div id="mapid"></div>
            </div>
        </div>
    </div>

</div>

<script src="<?= base_url( THEMES_BACKEND );?>app-assets/vendors/js/apexcharts.min.js"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
crossorigin=""></script>

<script type="text/javascript">
$(document).ready(function () {
    $('.select2').select2();
    // drowdown wilyah
    $('#select-propinsi').on("change.select2", function(e) {
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
            success : function(data) {
                let option = `<option value="0"> -- Pilih ${( ( params.title == "Kabupaten" ) ? "Kota/Kabupaten" : params.title )} -- </option>`;
                $.each( data, function(k,v) {
                    option += `<option value="${k}">${v}</option>`;
                });
                $("#select-" + params.title.toLowerCase() ).html( option );
            },
        });
    };

    function fnum(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    function set_maps(area) {
        f_location = [-0.7031073524364783, 117.46582031250001];
        zoom = 5;
        locations = [];

        $.ajax({
            url: "<?php echo $base_url ?>latlng_indo",
            type: "POST",
            data: {area:area},
            dataType: "json",
            async: false,
            success : function(e) {
                $('.overlay').toggle('hidden');
                $.each(e, function(i, v) {
                    arr_c = [v.wilayah + ' : ' + fnum(v.total) + ' ART', v.lat, v.long];
                    locations.push(arr_c);
                    if (area != 0) {
                        f_location = [v.lat, v.long];
                        if (area.length == 2) {
                            zoom = 6;
                        } else if (area.length == 4) {
                            zoom = 9;
                        } else if (area.length == 7) {
                            zoom = 12
                        }
                    }
                })
                console.log(locations);
            }
        })

        var container = L.DomUtil.get('mapid');
        if(container != null){
            container._leaflet_id = null;
        }
        var mymap = L.map('mapid').setView(f_location, zoom);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoicmF6eWlkNzIiLCJhIjoiY2s1Z2g1Z3NvMDc0YTNmcGVubmgzd2l5bCJ9.6jAMfgoFlE4HVP-BYqEFPw'
        }).addTo(mymap);

        for (var i = 0; i < locations.length; i++) {
            marker = new L.marker([locations[i][1], locations[i][2]])
            .bindPopup(locations[i][0])
            .addTo(mymap);
        }
    }

    // var locations = [
    //     ["LOCATION_1", 4.36855, 97.0253],
    //     ["LOCATION_2", 2.19235, 99.38122],
    // ];

    // marker.on('mouseover', function(e) {
    //     var popup = L.popup()
    //     .setLatLng(e.latlng)
    //     .setContent('Popup')
    //     .openOn(mymap);
    // });

    // mymap.on('click', function(e) {
    //     alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
    // });

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
        } else if (s_prov != 0 && s_regi != 0 && s_dist != 0) {
            area = s_prov + s_regi + s_dist;
        }

        set_maps(area);
    }

    if ('<?=$role?>' == 'korwil' || '<?=$role?>' == 'korkab') {
        filter_area ()
    } else {
        set_maps(area = '');
    }

    $('#filter_btn').on('click', function() {
        $('.overlay').toggle('hidden');
        filter_area();
    })

})
</script>
