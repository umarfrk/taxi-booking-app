<?php require "include/setting.php"; ?>

<?php
if(!isset($_SESSION['userID']) || $_SESSION['type']!="3"){
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Operator Console</title>

  <?php include "include/head.php"; ?>
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
        <div class="col-md-12">

          <?php
          $reservation = new Reservation();

          if(isset($_POST['btnSubmitTrip'])){
            $reservation->Reserve($_POST);
          }

          if(isset($_GET['edit'])){
            if($_GET['edit']!=""){
              $record = $reservation->getReservationByID($_GET['edit']);
              //var_dump($record);
            }else{
              header("Location: operatorConsole.php");
            }
          }
          
          ?>

          
          <div class="card">
            <?php
                if(isset($_GET['success'])){
                  ?>
                  <div class="alert alert-success" role="alert">
                      <h5 style="text-align: center;"><b>The record added successfully.</b></h5>
                  </div>
                  <?php
                }
                ?>
            <div class="card-header">
                <h3 class="text-center">Trip Reservation

                <?php
                if(!isset($_GET['new'])){
                  ?>
                  <a href="operatorConsole.php?new" class="btn btn-sm btn-primary float-right">+ NEW</a>
                  <?php
                }
                ?>
                </h3>
            </div>

            <?php
            if(isset($_GET['new']) || isset($_GET['edit'])){
              ?>

            <div class="card-body">
              <form action="" method="post" id="frmTrip">
                <div class="row"> 
                  <div class="col "> 
                    <div class="form-group">
                      <label for="" class="label">Passenger Name  </label>
                      <input type="text" class="form-control" placeholder="Enter Passenger Name..." required name='passengerName' value="<?php if(isset($_GET['edit'])) { echo $record['passengerName']; } ?>">
                    </div>

                    <div class="form-group">
                      <label for="passengerNIC" class="label">NIC No</label>
                      <input type="text" class="form-control" name='passengerNIC' placeholder="Enter Passenger NIC" required value="<?php if(isset($_GET['edit'])) { echo $record['passengerNIC']; } ?>">
                    </div>

                    <div class="form-group">
                      <label for="passengerPhone" class="label">Contact No</label>
                      <input type="text" class="form-control" name='passengerPhone' placeholder="Enter Passenger Phone No" required value="<?php if(isset($_GET['edit'])) { echo $record['passengerPhone']; } ?>">
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
                    <input type="text" class="form-control"  id ="amount" name='amount' placeholder="Enter the Trip amount" required value="<?php if(isset($_GET['edit'])) { echo $record['amount']; } ?>">
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
                    <div class="form-group text-center">
                      <?php
                      if(isset($_GET['edit'])){
                        ?>
                        <button class=" btn btn-success" type="submit" name="btnUpdate" id="btnSubmitTrip">Update Record</button>

                        <a href="operatorConsole.php" class="btn btn-secondary ">NEW</a>
                        <?php
                      }else{
                        ?>
                        <button class="form-control btn btn-primary" type="submit" name="btnSubmitTrip" id="btnSubmitTrip">Book Trip Now</button>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                 
                </div>
              </form>
            </div>
            <?php
            }
            ?>
        </div>



        <!-- View Data -->
        <hr>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Type</th>
              <th>By</th>
              <th>Name</th>
              <th>Phone</th>
              <th>NIC</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $res = new Reservation();
              $records = $res->getAllManualReservation();
              for ($i=0; $i < count($records); $i++) { 
                ?>
                <tr>
                  <td><?php echo $records[$i]['reservationID']; ?></td>
                  <td><?php echo $records[$i]['reservationType']; ?></td>
                  <td><?php echo $records[$i]['reservedBy']; ?></td>
                  <td><?php echo $records[$i]['passengerName']; ?></td>
                  <td><?php echo $records[$i]['passengerPhone']; ?></td>
                  <td><?php echo $records[$i]['passengerNIC']; ?></td>
                  <td>
                    <a href="?edit=<?php echo $records[$i]['reservationID']; ?>" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')">EDIT</a>
                  </td>
                </tr>
                <?php
              }
            ?>
          </tbody>
        </table>

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