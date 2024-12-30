
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqWRqLUwGDmDJBlxuVg6qImpxYl0mpnWc&libraries=places,geometry&callback=initMap" async defer></script> -->

	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqWRqLUwGDmDJBlxuVg6qImpxYl0mpnWc&libraries=places,geometry&callback=initMap" async defer></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqWRqLUwGDmDJBlxuVg6qImpxYl0mpnWc&libraries=places,geometry&callback=initMap" async defer></script>

</head>
<body>
	<!-- <p>Your Location: <span id="location"></span></p> -->
    <div id="map" style="height: 300px; width: 100%;"></div>

</body>
<script>
$(document).ready(function(){
	//alert("hi");
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showLocation);
    }else{ 
        $('#location').html('Geolocation is not supported by this browser.');
    }
});

function showLocation(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
        type:'POST',
        url:'getLocation.php',
        data:'latitude='+latitude+'&longitude='+longitude,
        success:function(msg){
            if(msg){
               $("#location").html(msg);
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}


function initMap() {
    // Initialize the map
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 7.8731, lng: 80.7718 }, // Coordinates for Sri Lanka
        zoom: 8
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();

    directionsRenderer.setMap(map);

    // Initialize autocomplete
    //pickupAutocomplete = new google.maps.places.Autocomplete(document.getElementById('pickup-location'));
    //dropoffAutocomplete = new google.maps.places.Autocomplete(document.getElementById('dropoff-location'));
}
</script>
</html>