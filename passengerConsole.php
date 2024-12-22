<?php require "include/setting.php"; ?>

<?php
if(isset($_SESSION['userID']) && $_SESSION['userID']!=""){
  $reservation = new Reservation();



  if($_SESSION['type'] == '1'){
    //header("Location: passengerConsole.php");
  }elseif($_SESSION['type'] == '2'){
    header("Location: driverConsole.php");
  }elseif($_SESSION['type'] == '3'){
    header("Location: operatorConsole.php");
  }elseif($_SESSION['type'] == '4'){
    header("Location: adminConsole.php");
  }
}else{
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <title> Welcome to Passengers Console </title>

  <?php include "include/head.php"; ?>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->

  </div>

<?php
if(isset($_GET['code'])){
  if($_GET['code']!=""){
    
    $row = $reservation->getReservationByCode($_GET['code']);

    $pickupLocation = explode(",", $row['pickupLocation']);
    $dropoffLocation = explode(",", $row['dropoffLocation']);

    $pickupLat = $pickupLocation[0];
    $pickupLng = $pickupLocation[1];

    $dropoffLat = $dropoffLocation[0];
    $dropoffLng = $dropoffLocation[1];

    
  }else{
    header("Location: passengerConsole.php");
  }

}else{
  $reservation->checkReservation();
}
?>

          <?php
          if(isset($_POST['btnSubmitReservation'])){
            $reservation = new Reservation();

            $reservation->SystemReservation($_POST);
          }
          ?>
  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        
        <div class="col-md-6">
          <?php
          if(isset($_GET['code'])){
            ?>
            <table class="table table-sm">
            <tr>
              <td>Passenger</td>
              <td><?php echo $row['passengerName']; ?></td>
            </tr>
            <tr>
              <td>Phone</td>
              <td><?php echo $row['passengerPhone']; ?></td>
            </tr>
            <tr>
              <td>Vehicle</td>
              <td><?php echo $row['vehicleType']; ?></td>
            </tr>
            <tr>
              <td>Staus</td>
              <td><?php echo $row['status']; ?></td>
            </tr>
          </table>

          <table class="table table-sm" style="display: none;">
            <tr>
              <td><?php echo $pickupLat; ?></td>
              <td><?php echo $pickupLng; ?></td>
            </tr>
            <tr>
              <td><?php echo $dropoffLat; ?></td>
              <td><?php echo $dropoffLng; ?></td>
            </tr>
          </table>

            <?php
          }
          ?>
          <div id="map" style="width: 100%; height: 300px;"></div>
        </div>





        <?php
        if(!isset($_GET['code'])){
          ?>

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
              <select id="selected-payment-method" name="paymentMethod" class="form-control" style="display:none;">
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
              </select>
              <input type="text" id="selected-cardID" name="cardID" class="form-control" placeholder="Enter Card ID (if paying by card)" style="display:none;">
              <input type="hidden" name="distance" id="distance">
            </div>


            <div class="form-group">
              <button type="submit" name="btnSubmitReservation" class="form-control btn btn-sm btn-primary">Submit Reservation</button>
            </div>

          </form>
          

          

          

          
        </div>
          <?php
        }else{
          ?>
          <div class="col-md-6">
            

            <div class="form-group">
              <label for="pickup-location">From</label>
              <input class="form-control" id="pickup-location" disabled readonly></input>
            </div>
            <div class="form-group">
              <label for="dropoff-location">To</label>
              <input class="form-control" id="dropoff-location" disabled readonly></input>
            </div>

            <div class="form-group">
              <table class="table table-sm">
                <tr>
                  <td><div class="form-control" id="distance"></div></td>
                  <td><div class="form-control text-right" id="fare"></div></td>
                </tr>
              </table>
              

              
              <div id="reservation-status"></div>
            </div>

            <form action="" method="post">
              <div class="form-group">
                <input type="submit" name="btnCancelReservation" value="Cancel" class="form-control btn btn-danger">
              </div>
            </form>

            <?php
            if(isset($_POST['btnCancelReservation'])){
              $reservation->cancelReservationByCode($_GET['code']);
            }
            ?>

            <div class="form-group">
              <label>List of Available Drivers</label>
              <div id="nearby-drivers-list"></div>
              <br><img src="images/request.gif" id="requestGif" style="width: 250px; display: none;">
            </div>
          </div>
          <?php
        }
        ?>
        

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

$(document).ready(function() {
  $('#selected-payment-method').on('change', function() {
    if ($(this).val() === 'Card') {
      $('#selected-cardID').show();
    } else {
      $('#selected-cardID').hide();
    }
  });
});


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

<?php
if(isset($_GET['code'])){
  ?>
  <script>
    $(document).ready(function() {

      let intervalId; // Declare a variable to hold the interval ID

      function startInterval() {
          // Only start the interval if it's not already running
          if (!intervalId) {
              intervalId = setInterval(checkRequestStatus, 3000); // Start the interval
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


      initMap();
      var pickupLat = <?php echo $pickupLat; ?>;
      var pickupLng = <?php echo $pickupLng; ?>;

      updateLocationFromMap("Pickup", <?php echo $pickupLat; ?>, <?php echo $pickupLng; ?>);
      updateLocationFromMap("Dropoff", <?php echo $dropoffLat; ?>, <?php echo $dropoffLng; ?>);

      var ref = "getDriverList";
      $.ajax({
        url : "liveUpdate.php",
        method: "post",
        data: {ref:ref, pickupLat:pickupLat, pickupLng: pickupLng},
        success: function(data){
          //alert(data);
          $("#nearby-drivers-list").html(data);
        }
      });

      let requestedDriverID;

      $(document).on("click", ".driverList", function(){
          var reservationID = <?php echo $row['reservationID']; ?>;
          var driverID = $(this).attr("id");
          var token = $(this).attr("data-id");
          var amountText = $("#fare").text();
          var amount = parseFloat(amountText.replace("LKR", "").trim());
          var reservationCode = <?php echo $_GET['code']; ?>;
          
          var ref = "requestDriver";
          $.ajax({
            url: "liveUpdate.php",
            method: "post",
            data: {ref:ref, reservationID:reservationID, driverID:driverID, token:token, amount:amount, reservationCode:reservationCode},
            success: function(data){
              //alert(data);
              if(data.trim() === "True"){
                requestedDriverID = driverID;

                $("#nearby-drivers-list").hide();
                $("#requestGif").show();
                startInterval();
              }
            }
          });
      });


      function checkRequestStatus(){
        var reservationID = <?php echo $row['reservationID']; ?>;
        var note = <?php echo $_GET['code']; ?>;

        var ref = "checkRequestStatus";
        $.ajax({
          url: "liveUpdate.php",
          method: "post",
          data : {ref:ref, reservationID:reservationID, note:note},
          success: function(data){
            //alert(data);
            if(data.trim() === "Waiting"){
              $("#nearby-drivers-list").hide();
              $("#requestGif").show();
              startInterval();
            }else if(data.trim() === "Accepted"){
              window.location.replace("track.php?code=<?php echo $_GET['code']; ?>");
            }else{

              $("#"+requestedDriverID).remove();
              requestedDriverID = 0;
              $("#nearby-drivers-list").show();
              $("#requestGif").hide();
              stopInterval();
            }
          }
        });
      }



      checkRequestStatus();
    });
  </script>
  <?php
}
?>  
  
</html>
