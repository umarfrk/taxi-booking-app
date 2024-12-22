<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>QuickTrip</title>

  <?php include "include/head.php"; ?>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->

  </div>

  <!-- about section -->
  <?php
    $code = htmlspecialchars(strip_tags($_GET['code']));

    $Trips = new Trips();
    $Trips->getTripByCode($code);

    $Reservation = new Reservation();
    $Reservation->getReservationByCode($code);

    $Drivers = new Drivers();
    $DriverRec = $Drivers->getDriverByID($Trips->driverID);

    if(isset($_POST['btnArrived'])){
      $Trips->updateTripStatus($_POST);
    }

    if(isset($_POST['btnPickup'])){
      $Trips->updateTripStatus($_POST);
    }

    if(isset($_POST['btnDropoff'])){
      $Trips->updateTripStatus($_POST);
    }

    if(isset($_POST['btnReceivePayment'])){
      $Payment = new Payment();
      $Payment->makePayment($_POST);
    }
  ?>

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-6">
            <?php
            if($_SESSION['type'] == "1"){
              ## Passenger
              ?>
                <h6 class="text-center"><b>Driver Details</b></h6>
                <p class="text-center">
                  <?php echo $DriverRec['firstname']." ".$DriverRec['lastname']; ?> | 
                  <a href="tel:<?php echo $Reservation->passengerPhone; ?>" class="btn btn-sm btn-success">Call Driver</a>
                </p>
              <?php
            }elseif($_SESSION['type'] == "2"){
              ## Driver
              ?>
              
                <h6 class="text-center"><b>Passenger Details</b></h6>
                <p class="text-center">
                  <?php echo $Reservation->passengerName; ?> | 
                  <a href="tel:<?php echo $Reservation->passengerPhone; ?>" class="btn btn-sm btn-warning">Call Passenger</a>
                </p>
              
              <?php
            }
            ?>
            
            
              <?php
              function getAddressFromCoordinates($latitude, $longitude, $apiKey) {
                  // Geocoding API endpoint
                  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";

                  // Initialize a cURL session
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                  // Execute cURL and fetch response
                  $response = curl_exec($ch);
                  curl_close($ch);

                  // Decode JSON response
                  $response = json_decode($response, true);

                  // Check for a successful response
                  if (isset($response['results'][0])) {
                      return $response['results'][0]['formatted_address'];
                  } else {
                      return "Address not found";
                  }
              }



              function getDistance($originLat, $originLng, $destLat, $destLng, $apiKey) {
                  $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$originLat,$originLng&destinations=$destLat,$destLng&key=$apiKey";

                  // Initialize a cURL session
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                  // Execute and decode the response
                  $response = curl_exec($ch);
                  curl_close($ch);

                  $data = json_decode($response, true);

                  // Check if the request was successful
                  if ($data['status'] === 'OK' && $data['rows'][0]['elements'][0]['status'] === 'OK') {
                      $distance = $data['rows'][0]['elements'][0]['distance']['text'];
                      return $distance; // Distance in human-readable format (e.g., "15 km")
                  } else {
                      return "Distance not available";
                  }
              }

              

              

              // Example usage
              $pickupLoc = explode(",", $Reservation->pickupLocation);
              $dropoffLoc = explode(",", $Reservation->dropoffLocation);

              $pickupLat = $pickupLoc[0];
              $pickupLng = $pickupLoc[1];

              $dropoffLat = $dropoffLoc[0];
              $dropoffLng = $dropoffLoc[1];

              ?>

              <hr>
            <p><i class="fa fa-circle text-success"></i> <?php echo getAddressFromCoordinates($pickupLat, $pickupLng, $mapApiKey); ?></p>
            <p><i class="fa fa-circle text-danger"></i> <?php echo getAddressFromCoordinates($dropoffLat, $dropoffLng, $mapApiKey); ?></p>
            <p><i class="fa fa-road text-primay"></i> <?php echo getDistance($pickupLat, $pickupLng, $dropoffLat, $dropoffLng, $mapApiKey); ?></p>

            <p><i class="fa fa-money text-primay"></i> <?php echo $Trips->amount; ?> LKR</p>

          </div>
      </div>






      <div class="row justify-content-center">
        <div class="col-md-6" id="statusBox">
          
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <?php
          if($_SESSION['type'] == '2'){
            echo $Trips->status;
            if($Trips->status == "Accepted"){
              ?>
              <form action="" method="post">
                <div class="form-group">
                  <input type="hidden" name="tripID" value="<?php echo $Trips->tripID; ?>">
                  <input type="hidden" name="note" value="<?php echo $Trips->note; ?>">
                  <input type="hidden" name="status" value="Arrived">
                  <button class="form-control btn btn-primary" name="btnArrived" onclick="return confirm('Are you sure?')">Arrived</button>
                </div>
              </form>
              <?php
            }elseif($Trips->status == "Arrived"){
              ?>
              <form action="" method="post">
                <div class="form-group">
                  <input type="hidden" name="tripID" value="<?php echo $Trips->tripID; ?>">
                  <input type="hidden" name="note" value="<?php echo $Trips->note; ?>">
                  <input type="hidden" name="status" value="PickedUp">
                  <button class="form-control btn btn-warning" name="btnPickup" onclick="return confirm('Are you sure?')">Pickup</button>
                </div>
              </form>
              <?php
            }elseif($Trips->status == "PickedUp"){
              ?>
              <form action="" method="post">
                <div class="form-group">
                  <input type="hidden" name="tripID" value="<?php echo $Trips->tripID; ?>">
                  <input type="hidden" name="note" value="<?php echo $Trips->note; ?>">
                  <input type="hidden" name="status" value="DroppedOff">
                  <button class="form-control btn btn-warning" name="btnDropoff" onclick="return confirm('Are you sure?')">Drop Off</button>
                </div>
              </form>
              <?php
            }elseif($Trips->status == "DroppedOff"){
              ?>
              <form action="" method="post">
                <div class="form-group">
                  <input type="hidden" name="tripID" value="<?php echo $Trips->tripID; ?>">
                  <input type="hidden" name="paidBy" value="<?php echo $Reservation->reservedBy; ?>">
                  <input type="hidden" name="driverID" value="<?php echo $Trips->driverID; ?>">
                  <input type="hidden" name="code" value="<?php echo $Trips->note; ?>">
                  <input type="hidden" name="status" value="Finished">
                  <input type="text" name="amount" value="<?php echo $Trips->amount; ?>" class="form-control text-center" readonly>
                  <button class="form-control btn btn-success" name="btnReceivePayment" onclick="return confirm('Are you sure?')">Payment Received</button>
                </div>
              </form>
              <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->


  


  <!-- footer section -->
  <?php include "include/footer.php"; ?>
  <!-- footer section -->


  <?php include "include/bottom.php"; ?>

  <?php
  if($_SESSION['type']=="1" || $_SESSION['type'] == "3"){
    ?>
    <script>
      $(document).ready(function(){
        let intervalId; // Declare a variable to hold the interval ID

        function startInterval() {
            // Only start the interval if it's not already running
            if (!intervalId) {
                intervalId = setInterval(checkDriverStatus, 3000); // Start the interval
                console.log("Interval started.");
            }
        }

        function stopInterval() {
            if (intervalId) {
                clearInterval(intervalId); // Stop the interval
                intervalId = null; // Reset the interval ID to indicate it's stopped
                console.log("Interval stopped.");
            }
        }


        function checkDriverStatus(){
          var code = <?php echo $Trips->note; ?>;
          var ref = "checkDriverStatus";

          $.ajax({
            url: "liveUpdate.php",
            method: "post",
            data: {ref:ref, code:code},
            success: function(data){
              if(data.trim() === "Accepted"){
                $("#statusBox").html('<div class="alert alert-info" role="alert"><h5 style="text-align: center;"><b>Accepted.</b> Driver in On the Way</h5></div>');
              }else if(data.trim() === "Arrived"){
                $("#statusBox").html('<div class="alert alert-primary" role="alert"><h5 style="text-align: center;"><b>Arrived.</b></h5></div>');
              }else if(data.trim() === "PickedUp"){
                $("#statusBox").html('<div class="alert alert-warning" role="alert"><h5 style="text-align: center;"><b>Picked Up.</b></h5></div>');
              }else if(data.trim() === "DroppedOff"){
                $("#statusBox").html('<div class="alert alert-warning" role="alert"><h5 style="text-align: center;"><b>Dropped Off.</b></h5></div><div class="alert alert-success" role="alert"><h5 style="text-align: center;"><b>Make Payment of LKR '+<?php echo $Trips->amount; ?>+'</b></h5></div>');
              }else if(data.trim() === "Paid"){
                $("#statusBox").html('<div class="alert alert-success" role="alert"><h5 style="text-align: center;"><b>Dropped Off.</b></h5></div><div class="alert alert-success" role="alert"><h5 style="text-align: center;"><b>Payment Successfull. Please Rate the Driver</b></h5></div>');

                window.location.replace("rate.php?code="+<?php echo $_GET['code']; ?>);
              }
            }
          });
        }


        startInterval();
      });
    </script>
    <?php
  }elseif($_SESSION['type']=="2"){
    ?>
    <?php
  }
  ?>
</body>

</html>