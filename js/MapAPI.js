let map, marker, directionsService, directionsRenderer;

let dropoffAutocomplete, pickupAutocomplete;
let passengerLatitude, passengerLongitude, PricePerKm, TripDistanceInKm, TripFare, Fee;
let passengerPickUpLatitude, passengerPickUpLongitude, passengerDropOffLatitude, passengerDropOffLongitude;
let PickUpMarker, dropoffMarker;
let checkReservationInterval;

// Initiate Map
function initMap() {
    // Initialize the map
    map = new google.maps.Map($('#map')[0], {
        center: { lat: 7.8731, lng: 80.7718 }, // Coordinates for Sri Lanka
        zoom: 8
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();

    directionsRenderer.setMap(map);

    // Initialize autocomplete
    pickupAutocomplete = new google.maps.places.Autocomplete($('#pickup-location')[0]);
    dropoffAutocomplete = new google.maps.places.Autocomplete($('#dropoff-location')[0]);
}

function clearDriverSelectionAndFare() {
    // Clear driver selection list
    $('#nearby-drivers-list').html('');
    // Clear fare display
    $('#fare').html('');
}

// Pickup / Dropoff
function SetByGPS(location) {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            updateLocationFromMap(location, latitude, longitude);
        }, function () {
            alert('Failed to fetch GPS location.');
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function SetInMap(location) {
    google.maps.event.clearListeners(map, 'click');
    google.maps.event.addListener(map, 'click', function (event) {
        const latitude = event.latLng.lat();
        const longitude = event.latLng.lng();

        updateLocationFromMap(location, latitude, longitude);
    });
}

function SetByTyping(location) {
    const inputField = location === "Pickup" ? "pickup-location" : "dropoff-location";

    // Enable typing by re-enabling the input field
    $('#' + inputField).prop('disabled', false).focus();

    // Set up Google Places Autocomplete for manual typing
    const autocomplete = new google.maps.places.Autocomplete($('#' + inputField)[0]);
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
            return; // If no place is selected, exit
        }

        const latitude = place.geometry.location.lat();
        const longitude = place.geometry.location.lng();

        // Reuse the updateLocationFromMap function to handle map updates and markers
        updateLocationFromMap(location, latitude, longitude);

        if(location == "Pickup"){
            $("#pickup_latitude").val(passengerPickUpLatitude);
            $("#pickup_longitude").val(passengerPickUpLongitude);
        }else if(location == "Dropoff"){
            $("#Dropoff_latitude").val(passengerDropoffLatitude);
            $("#Dropoff_longitude").val(passengerDropoffLongitude);
        }
    });
}

function updateLocationFromMap(location, latitude, longitude) {
    const geocoder = new google.maps.Geocoder();
    const latLng = { lat: latitude, lng: longitude };

    if (location == "Pickup") {
        passengerPickUpLatitude = latitude;
        passengerPickUpLongitude = longitude;

        if (PickUpMarker) {
            PickUpMarker.setMap(null); // Remove previous marker from map
        }

        PickUpMarker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: "Pick-up Location",
        });

        map.setCenter(latLng);
        map.setZoom(15);

        $("#pickup_latitude").val(passengerPickUpLatitude);
        $("#pickup_longitude").val(passengerPickUpLongitude);
    } else if (location == "Dropoff") {
        passengerDropOffLatitude = latitude;
        passengerDropOffLongitude = longitude;

        if (dropoffMarker) {
            dropoffMarker.setMap(null); // Remove previous marker from map
        }

        dropoffMarker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: "Drop-off Location",
        });

        map.setCenter(latLng);
        map.setZoom(15);

        $("#dropoff_latitude").val(passengerDropOffLatitude);
        $("#dropoff_longitude").val(passengerDropOffLongitude);
    }

    geocoder.geocode({ location: latLng }, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                if (location == "Pickup") {
                    $('#pickup-location').val(results[0].formatted_address).prop('disabled', false);
                } else if (location == "Dropoff") {
                    $('#dropoff-location').val(results[0].formatted_address).prop('disabled', false);
                }
            }
        } else {
            alert("Geocoding failed: " + status);
        }
    });

    if (passengerPickUpLatitude != null && passengerPickUpLongitude != null && passengerDropOffLatitude != null && passengerDropOffLongitude != null) {
        const dropoffLocation = { lat: passengerDropOffLatitude, lng: passengerDropOffLongitude };
        calculateRoute(passengerPickUpLatitude, passengerPickUpLongitude, dropoffLocation);
    }

    google.maps.event.clearListeners(map, 'click');
}

// Fetch nearby drivers by vehicle type
function fetchNearbyDrivers(vehicleType) {
    clearDriverSelectionAndFare();
    const radiusKm = 10; // Set your desired radius in kilometers

    $.getJSON(`/Passenger/GetNearbyDriversByVehicleType?latitude=${passengerPickUpLatitude}&longitude=${passengerPickUpLongitude}&vehicleType=${vehicleType}&radiusKm=${radiusKm}`)
        .done(function (data) {
            updateNearbyDrivers(data.nearbyDrivers);
        })
        .fail(function (error) {
            console.error('Error fetching nearby drivers:', error);
        });
}

// Update the list of nearby drivers
function updateNearbyDrivers(drivers) {
    const nearbyDriversList = $('#nearby-drivers-list');
    nearbyDriversList.html(''); // Clear the previous list

    drivers.forEach(driver => {
        // Calculate distance between passenger's location and the driver's location
        const driverLocation = new google.maps.LatLng(driver.latitude, driver.longitude);
        PricePerKm = driver.pricePerKM;
        const passengerLocation = new google.maps.LatLng(passengerPickUpLatitude, passengerPickUpLongitude);
        const distanceInMeters = google.maps.geometry.spherical.computeDistanceBetween(passengerLocation, driverLocation);
        const DriverDistanceInKm = (distanceInMeters / 1000).toFixed(2); // Convert to kilometers and round to 2 decimal places

        // Create the list item with driver information and calculated distance
        const li = `<li><input type="radio" name="driver" value="${driver.driverID}|${driver.vehicleID}|${DriverDistanceInKm}">
            Driver: ${driver.firstName} ${driver.lastName},
            Price: ${PricePerKm},
            Distance: ${DriverDistanceInKm} km away</li>`;
        nearbyDriversList.append(li);
    });
}

// By Theesan
function ListNearbyDrivers(){}

$('#nearby-drivers-list').on('change', 'input[name="driver"]', (event) => {
    // Calculate fare when a driver is selected
    const dropoffLocation = $('#dropoff-location').val();
    if (dropoffLocation) {
        const selectedDriver = $(event.target).val();
        const [driverId, vehicleId, driverDistanceInKm] = selectedDriver.split('|');
        calculateTripFare(TripDistanceInKm, driverDistanceInKm, PricePerKm);
    }
});

// Calculate and display the fare after selecting a vehicle type and valid route
function calculateTripFare(TripDistanceInKm, driverDistanceInKm, PricePerKm) {
    if (TripDistanceInKm && driverDistanceInKm && PricePerKm) {
        TripFare = (parseFloat(TripDistanceInKm) + parseFloat(driverDistanceInKm)) * parseFloat(PricePerKm);
        $('#fare').text(`Total Fare: LKR ${TripFare.toFixed(2)}`);
    }
}

// Calculate the route from pickup (current location) to drop-off
function calculateRoute(pickupLat, pickupLng, dropoffLocation) {
    const request = {
        origin: new google.maps.LatLng(pickupLat, pickupLng),
        destination: dropoffLocation,
        travelMode: google.maps.TravelMode.DRIVING,
    };

    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);

            // Calculate the distance and display it
            TripDistanceInKm = result.routes[0].legs[0].distance.text;
            $('#distance').text("Distance: " + TripDistanceInKm);
            $('#distance').val(TripDistanceInKm);
            //$('#distance').text(TripDistanceInKm);

            Fee = 100*parseFloat(TripDistanceInKm);

            $('#fare').text("LKR "+ Fee.toFixed(2));
        } else {
            alert("Directions request failed due to " + status);
        }
    });
}

function submitData() {
    const selectedDriver = $('input[name="driver"]:checked').val();

    if (!selectedDriver) {
        alert("Please select a driver.");
        return;
    }

    const [driverId, vehicleId, driverDistanceInKm] = selectedDriver.split('|');

    if (!passengerPickUpLatitude || !passengerPickUpLongitude) {
        alert("Please provide a valid pickup location.");
        return;
    }

    if (!passengerDropOffLatitude || !passengerDropOffLongitude) {
        alert("Please provide a valid dropoff location.");
        return;
    }

    const cardID = $('#selected-cardID').val();
    const paymentType = $('#selected-payment-method').val();

    if (!paymentType || (!cardID && paymentType !== 'Cash')) {
        alert("Please select a valid payment method.");
        return;
    }

    if (!TripDistanceInKm || !TripFare) {
        alert("Trip distance and fare are missing.");
        return;
    }

    const pickupLocation = `${passengerPickUpLatitude},${passengerPickUpLongitude}`;
    const dropoffLocation = `${passengerDropOffLatitude},${passengerDropOffLongitude}`;

    const data = {
        driverId: driverId,
        vehicleId: vehicleId,
        passengerLatitude: passengerPickUpLatitude,
        passengerLongitude: passengerPickUpLongitude,
        pickupLocation: pickupLocation,
        dropoffLocation: dropoffLocation,
        tripDistanceInKm: TripDistanceInKm,
        tripFare: TripFare,
        paymentType: paymentType,
        cardID: cardID
    };

    $.ajax({
        type: "POST",
        url: "/Passenger/CreateTaxiReservation",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function (result) {
            if (result.success) {
                $('#reservation-status').html('<div class="alert alert-success">Reservation created successfully.</div>');
                checkReservationStatus(result.reservationId);
            } else {
                $('#reservation-status').html('<div class="alert alert-danger">' + result.error + '</div>');
            }
        },
        error: function (error) {
            console.error('Error creating reservation:', error);
        }
    });
}

function checkReservationStatus(reservationId) {
    checkReservationInterval = setInterval(function () {
        $.getJSON(`/Passenger/GetReservationStatus?reservationId=${reservationId}`)
            .done(function (response) {
                if (response.success) {
                    if (response.status === "Accepted") {
                        $('#reservation-status').html('<div class="alert alert-success">Your reservation has been accepted.</div>');
                        clearInterval(checkReservationInterval);
                    }
                } else {
                    $('#reservation-status').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            })
            .fail(function (error) {
                console.error('Error checking reservation status:', error);
            });
    }, 5000); // Check every 5 seconds
}
