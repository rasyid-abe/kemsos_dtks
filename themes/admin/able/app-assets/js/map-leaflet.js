$(document).ready(function () {
  $(".maps-leaflet-container").css("height", "450px");

  //-------------- Marker map --------------
  var mapsLeafletMarker = L.map('maps-leaflet-marker').setView([51.5, -0.09], 13);
  var marker = L.marker([51.5, -0.09]).addTo(mapsLeafletMarker);
  var circle = L.circle([51.508, -0.11], {
    color: 'red',
    fillColor: '#D23B48',
    fillOpacity: 0.5,
    radius: 500
  }).addTo(mapsLeafletMarker);
  var polygon = L.polygon([
    [51.509, -0.08],
    [51.503, -0.06],
    [51.51, -0.047]
  ]).addTo(mapsLeafletMarker);
  L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
    maxZoom: 18,
  }).addTo(mapsLeafletMarker);

  //-------------- Layer Groups and Layers Control map --------------
  var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.'),
    denver = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.'),
    aurora = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.'),
    golden = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.');
  var cities = L.layerGroup([littleton, denver, aurora, golden]);
  var street = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 18,
    }),
    watercolor = L.tileLayer('http://tile.stamen.com/watercolor/{z}/{x}/{y}.jpg', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 18,
    });
  var mapsLeafletGroupControl = L.map('maps-leaflet-groups-control', {
    center: [39.73, -104.99],
    zoom: 9,
    layers: [street, cities]
  });
  var baseMaps = {
    "Street": street,
    "Watercolor": watercolor
  };
  var overlayMaps = {
    "Cities": cities
  };
  L.control.layers(baseMaps, overlayMaps).addTo(mapsLeafletGroupControl);
  L.tileLayer('https://c.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
    maxZoom: 18,
  }).addTo(mapsLeafletGroupControl);
});
