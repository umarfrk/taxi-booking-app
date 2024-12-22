<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Reservation - QuickTrip</title>

  <?php include "include/head.php"; ?>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->

  </div>

  <!-- about section -->

  <section class=" layout_padding">
    <div class="container">
      <div class="row justify-content-center">
        
        <div class="col-md-12">

          <?php
          if(isset($_POST['btnSubmitTrip'])){

            //var_dump($_POST);
            //exit();
            $reservation = new Reservation();

            $reservation->Reserve($_POST);
            
          }

          
          
          ?>

          
          <div class="card">
            <div class="card-header">
                <h3 class="text-center">Trip Reservation</h3>
            </div>

            <div class="card-body">
              <form action="" method="post" id="frmTrip">
                <div class="row"> 
                  <div class="col "> 
                    <div class="form-group">
                      <label for="" class="label">Passenger Name	</label>
                      <input type="text" class="form-control" placeholder="Enter Passenger Name..." required name='passengerName'>
                    </div>

                    <div class="form-group">
                      <label for="passengerNIC" class="label">NIC No</label>
                      <input type="text" class="form-control" name='passengerNIC' placeholder="Enter Passenger NIC" required>
                    </div>

                    <div class="form-group">
                      <label for="passengerPhone" class="label">Contact No</label>
                      <input type="text" class="form-control" name='passengerPhone' placeholder="Enter Passenger Phone No" required>
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
                    <label for="amount" class="label">Amount</label>
                    <input type="text" class="form-control"  id ="amount" name='amount' placeholder="Enter the Trip amount" required>
                    <input type="text" class="form-control"  id ="distance" name='distance' placeholder="Enter the Trip distance" required>
                  </div>

                  </div>
                  <div class="col"> 
                          <input type="hidden" value="Passenger" name="type">
                        <div class="form-group">
                            <label for="pickupLocation" class="label">Pick-up Location</label>
                            <input type="text" class="form-control" id="pickupLocation" name="pickupLocation" placeholder="City, Airport, Station, etc" required>
                        </div>
                        <div class="form-group">
                            <label for="dropoffLocation" class="label">Drop-off Location</label>
                            <input type="text" class="form-control" id="dropoffLocation" name="dropoffLocation" placeholder="City, Airport, Station, etc" required>
                        </div>
                        
                        <div class="form-group mr-2">
                            <label for="scheduledDateTime" class="label">Scheduled Date&Time</label>
                            <input type="datetime-local" class="form-control" id="scheduledDateTime" name="scheduledDateTime" required>
                        </div>
                        
                        
                        <div class="mb-3">
                          <label for="note" class="form-label">Note</label>
                          <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter your message here"></textarea>
                        </div>
                        
                        

                        
                    
                  </div>
                </div>
                <div class="row justify-content-center"> 
                  <div class="col-6"> 
                    <div class="form-group">
                      <button class="form-control btn btn-primary" type="submit" name="btnSubmitTrip" id="btnSubmitTrip">Book Trip Now</button>
                    </div>
                  </div>
                 
                </div>
              </form>
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
    
  });
</script>

</html>