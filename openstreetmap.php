<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title> Blank </title>

  <?php include "include/head.php"; ?>

  <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->

  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <h3>OpenStreetMap with PHP</h3>
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Initialize the map and set its view
        var map = L.map('map').setView([7.8731, 80.7718], 8);

        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Check if Geolocation is available in the browser
        if (navigator.geolocation) {
            // Get the user's current position
            navigator.geolocation.getCurrentPosition(function(position) {
                // Get latitude and longitude from the position
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // Update the map view to the user's current location
                map.setView([lat, lng], 15);

                // Add a marker to the user's current location
                var marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup("<b>Your Location</b><br />Latitude: " + lat + "<br />Longitude: " + lng).openPopup();
            }, function(error) {
                // Handle any errors if Geolocation fails
                alert("Geolocation failed: " + error.message);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
        
        // Add a marker to the map
        /*var marker1 = L.marker([7.8731, 80.7718]).addTo(map);
        var marker2 = L.marker([7.8731, 79.7718]).addTo(map);
        marker1.bindPopup("<b>Hello!</b><br />This is a marker on OpenStreetMap.").openPopup();
        marker2.bindPopup("<b>Hello!</b><br />This is a marker on OpenStreetMap.").openPopup();*/
    </script>
      </div>
    </div>
  </section>

  <!-- end about section -->


  


  <!-- footer section -->
  <?php include "include/footer.php"; ?>
  <!-- footer section -->


  <?php include "include/bottom.php"; ?>

</body>

</html>