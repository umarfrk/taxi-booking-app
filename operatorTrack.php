<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Welcome to Passenger Console</title>

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

  ?>

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        
        <div class="col-md-6">
          <div id="map" style="width: 100%; height: 300px;"></div>
        </div>

        <div class="col-md-6">

          <div class="form-group">
            <button class="btn btn-sm btn-primary" onclick="" id="btnGetLocation">GET Location</button>
          </div>

          <div class="form-group">
            <button class="btn btn-sm btn-info" onclick="SetInMap('Pickup')" id="btnSetPickupByClick">Set Pickup by Clicking Map</button>
            <button class="btn btn-sm btn-info" onclick="SetInMap('Dropoff')" id="btnSetDropoffByClick">Set Dropoff by Clicking Map</button>
          </div>

          <div class="form-group">
            <button class="btn btn-sm btn-warning" onclick="SetByTyping('Pickup')" id="btnSetPickupByType">Set Pickup by Typing</button>
            <button class="btn btn-sm btn-warning" onclick="SetByTyping('Dropoff')" id="btnSetDropoffByType">Set Dropoff by Typing</button>

          </div>

          <form action="" method="post" style="width: 100%;">
            <div class="form-group" style="display: none;">
              <input type="text" name="reservationType" value="System">
              <input type="text" name="reservedBy" value="<?php echo $_SESSION['userID']; ?>">
              <input type="text" name="passengerName" value="<?php echo $_SESSION['firstname']." ".$_SESSION['lastname']; ?>">
              <input type="text" name="passengerPhone" value="<?php echo $_SESSION['userphone']; ?>">
              <input type="text" name="passengerNIC" value="<?php echo $_SESSION['nic']; ?>">
            </div>


            <div class="form-group" style="display: none;">
              <input type="text" name="pickup_latitude" id="pickup_latitude" readonly>
              <input type="text" name="pickup_longitude" id="pickup_longitude" readonly><br>
              <input type="text" name="dropoff_latitude" id="dropoff_latitude" readonly>
              <input type="text" name="dropoff_longitude" id="dropoff_longitude" readonly>
            </div>

            <div class="form-group">
              <label for="pickup-location">From</label>
              <input type="text" name="pickup-location" id="pickup-location" class="form-control">
              <label for="dropoff-location">To</label>
              <input type="text" name="dropoff-location" id="dropoff-location" class="form-control">
            </div>

            <div class="form-group">
                <label for="vehicleType" class="label">Select Type</label>
                <select class="form-control " id="vehicleType" name="vehicleType" required>
                    <option value="" disabled selected>Select Vehicle Type</option>
                    <option value="Bike">Bike</option>
                    <option value="Tuk">Tuk</option>
                    <option value="Flex">Flex</option>
                    <option value="Mini">Mini</option>
                    <option value="Car">Car</option>
                    <option value="MiniVan">MiniVan</option>
                    <option value="Van">Van</option>
                </select>
            </div>

            <div class="form-group">
              <select id="selected-payment-method">
                  <option value="Cash">Cash</option>
                  <option value="Card">Card</option>
              </select>
              <input type="hidden" id="selected-cardID" placeholder="Enter Card ID (if paying by card)">
              <input type="hidden" name="distance" id="distance">
            </div>

            <div class="form-group">
              <button type="submit" name="btnSubmitReservation" class="form-control btn btn-sm btn-primary">Submit Reservation</button>
            </div>

          </form>
          

          

          

          <div class="form-group">
            <div id="fare"></div>
            <div id=""></div>

            

            <!-- Payment Information -->
            

            <!-- Reservation Status -->
            <div id="reservation-status"></div>
          </div>

          <div class="form-group">
            <label>List of Available Drivers</label>
            <ul id="nearby-drivers-list"></ul>
          </div>
        </div>

        

      </div>
    </div>
  </section>

  <!-- end about section -->


  


  <!-- footer section -->
  <?php include "include/footer.php"; ?>
  <!-- footer section -->


  <?php include "include/bottom.php"; ?>

</body>

<script>
$(document).ready(function(){
  $("#btnGetLocation").on("click", function(){
    SetByGPS('Pickup');
    $("#dropoff-location").focus();
  });

  $("#pickup-location").on("input", function(){
    SetByTyping('Pickup');
  });

  $("#dropoff-location").on("input", function(){
    SetByTyping('Dropoff');
  });
});
</script>

</html>