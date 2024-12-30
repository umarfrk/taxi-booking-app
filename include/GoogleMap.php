<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqWRqLUwGDmDJBlxuVg6qImpxYl0mpnWc&libraries=places,geometry&callback=initMap" async defer></script>

<!-- 3. Fetching Current Location -->
<script>
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }

  function showPosition(position) {
    let lat = position.coords.latitude;
    let lng = position.coords.longitude;
    console.log("Latitude: " + lat + " Longitude: " + lng);
    // You can use these coordinates to set them on a map or make further requests.
  }

  // Call this function on page load or when necessary
  getLocation();
</script>





<!-- 4. Search for Locations (Places API) -->
<input id="searchBox" type="text" placeholder="Search for a place">
<script>
  let autocomplete;
  function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('searchBox'),
      { types: ['geocode'] }
    );

    autocomplete.addListener('place_changed', function() {
      let place = autocomplete.getPlace();
      console.log(place);
    });
  }
  
  // Initialize when Google Maps script is loaded
  google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>




<!-- 5. Setting Directions (Directions API) -->
<div id="map" style="height: 400px;"></div>
<script>
  function initMap() {
    let directionsService = new google.maps.DirectionsService();
    let directionsRenderer = new google.maps.DirectionsRenderer();
    let map = new google.maps.Map(document.getElementById("map"), {
      zoom: 7,
      center: { lat: 6.9271, lng: 79.8612 } // Example: Colombo, Sri Lanka
    });
    directionsRenderer.setMap(map);

    let request = {
      origin: 'Colombo, Sri Lanka', // Set your origin
      destination: 'Kandy, Sri Lanka', // Set your destination
      travelMode: 'DRIVING'
    };

    directionsService.route(request, function(result, status) {
      if (status === 'OK') {
        directionsRenderer.setDirections(result);
      } else {
        console.log("Error getting directions: " + status);
      }
    });
  }

  google.maps.event.addDomListener(window, 'load', initMap);
</script>


<!-- 6. Getting Distance and Estimated Time (Distance Matrix API) -->
<script>
  function getDistanceTime(origin, destination) {
    let service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
      {
        origins: [origin],
        destinations: [destination],
        travelMode: 'DRIVING',
      },
      function(response, status) {
        if (status === 'OK') {
          let results = response.rows[0].elements[0];
          let distance = results.distance.text;
          let duration = results.duration.text;
          console.log("Distance: " + distance + " Time: " + duration);
        } else {
          console.log("Error: " + status);
        }
      }
    );
  }

  // Example usage
  getDistanceTime('Colombo, Sri Lanka', 'Kandy, Sri Lanka');
</script>

