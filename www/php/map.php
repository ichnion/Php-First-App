<?php
session_start();
?>
<html>
<head>   
<style>
    *{
        margin:0;
        padding: 0;
    }
    
    #map {
        height:100%;
        width:100%;
        
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
</head>

<body>
<div id="map"> 
<script>
var map = L.map('map').setView([35.689487, 139.691711], 4);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var arrayLat = <?php echo json_encode($_SESSION['latitude']); ?>;
var arrayLng = <?php echo json_encode($_SESSION['longitude']); ?>;
var arrayTime = <?php echo json_encode($_SESSION['time']); ?>;
var arrayName = <?php echo json_encode($_SESSION['name']); ?>;
for (var iter = 0; iter < arrayLat.length; iter++) {
    var latlng = arrayLat[iter] +"," + arrayLng[iter];
    var date = new Date(arrayTime[iter]*1000).toLocaleString();
    L.marker(
        [arrayLat[iter] , arrayLng[iter]]).addTo(map).bindPopup(date + " | " +arrayName[iter])
    .openPopup();
}
</script>
</div>
</body>
</html>
