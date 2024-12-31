<?php require "include/setting.php"; ?>

<?php
if (!isset($_SESSION['userID']) || $_SESSION['type'] != "2") {
  header("Location: login.php");
} else {
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Driver Console</title>

  <?php include "include/head.php"; ?>



</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->

  </div>


  <?php
  $driver = new Drivers();
  $driver->getDriverByUser($_SESSION['userID']);

  $trip = new Trips();
  $trip->checkCurrentTrip($driver->driverID);

  $rating = new Rating();

  // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //   echo "<pre>";
  //   print_r($_POST);
  //   echo "</pre>";
  //   exit;
  // }

  // if (isset($_POST['btnBusy'])) {
  //   echo "Button Busy clicked. Driver ID: " . $_POST['driverID'];
  //   exit;
  // }

  if (isset($_POST['btnOffline'])) {
    $driver->updateDriverStatus($_POST['driverID'], 'Offline');
  }

  if (isset($_POST['btnBusy'])) {
    $driver->updateDriverStatus($_POST['driverID'], 'Busy');
  }

  if (isset($_POST['btnAvailable'])) {
    $driver->updateDriverStatus($_POST['driverID'], 'Available');
  }

  if (isset($_POST['btnAcceptRequest'])) {
    $trip->acceptTripRequest($_POST);
  }

  if (isset($_POST['btnCancelTrip'])) {
    if ($trip->cancelTripByID($_POST['tripID'])) {
      header("Location: driverConsole.php");
    }
  }

  ?>

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12 text-center">

          <?php
          if ($driver->status == "Offline") {
          ?>
            <span class="badge badge-danger">Offline</span>
          <?php
          } elseif ($driver->status == "Busy") {
          ?>
            <span class="badge badge-warning">Busy</span>
          <?php
          } elseif ($driver->status == "Available") {
          ?>
            <span class="badge badge-success">Available</span>
          <?php
          }
          ?>

          <h4>Hello <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></h4>

          <span class="badge badge-info"><?php echo $driver->vehicleType; ?></span>
          <span class="badge badge-info"><?php echo $driver->vehicleModel; ?></span>
          <span class="badge badge-info"><?php echo $driver->vehicleNo; ?></span>

          <span class="badge badge-info"><i class="fa fa-users"></i> Seats: <?php echo $driver->vehicleCapacity; ?></span>


        </div>
      </div>
      <hr>
      <div class="row justify-content-center">
        <?php if ($driver->status != "Offline"): ?>
          <div class="col-md-3 text-center">
            <form action="driverConsole.php" method="post">
              <input type="hidden" name="driverID" value="<?= $driver->driverID ?>">
              <input type="submit" name="btnOffline" class="form-control btn btn-sm btn-danger" value="Set Offline">
            </form>
          </div>
        <?php endif; ?>

        <?php if ($driver->status != "Busy"): ?>
          <div class="col-md-3 text-center">
            <form action="driverConsole.php" method="post">
              <input type="hidden" name="driverID" value="<?= $driver->driverID ?>">
              <input type="submit" name="btnBusy" class="form-control btn btn-sm btn-warning" value="Set Busy">
            </form>
          </div>
        <?php endif; ?>

        <?php if ($driver->status != "Available"): ?>
          <div class="col-md-3 text-center">
            <form action="driverConsole.php" method="post">
              <input type="hidden" name="driverID" value="<?= $driver->driverID ?>">
              <input type="submit" name="btnAvailable" class="form-control btn btn-sm btn-success" value="Set Available">
            </form>
          </div>
        <?php endif; ?>
      </div>
      <hr>


      <div class="row justify-content-center">
        <div id="requestBox">

          <h5>NO Requests Found !</h5>

        </div>
      </div>
      <hr>
      <div class="row justify-content-center">
        <div class="col-md-6 col-right">
          <?php
          $row = $rating->rateCal($driver->driverID);
          // $score = $row['scoreSum'] / $row['scoreCount'];
          $score = ($row['scoreCount'] != 0) ? $row['scoreSum'] / $row['scoreCount'] : 0;
          ?>
          <span class="heading">User Rating</span>
          <?php
          if ($score < 1) {
          ?>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
          <?php
          } elseif ($score < 2) {
          ?>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
          <?php
          } elseif ($score < 3) {
          ?>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
          <?php
          } elseif ($score < 4) {
          ?>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
          <?php
          } elseif ($score < 5) {
          ?>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star "></span>
          <?php
          } else {
          ?>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
            <span class="fa fa-star text-warning"></span>
          <?php
          }
          ?>
          <p>
            <?php echo number_format($score, 1); ?>
            average based on
            <?php echo $row['scoreCount']; ?>
            reviews.
          </p>

          <hr style="border:3px solid #f1f1f1">


        </div>

        <div class="col-md-8">

          <?php
          $reviews = $rating->getRatingByDriver($driver->driverID);
          for ($i = 0; $i < count($reviews); $i++) {
          ?>
            <div class="card" style="margin-bottom: 10px;">

              <div class="card-body" style="padding: 10px;">
                <p style="font-style: italic; margin: 0px;">
                  <?php
                  if ($reviews[$i]['score'] == '0') {
                  ?>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                  <?php
                  } elseif ($reviews[$i]['score'] == '1') {
                  ?>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                  <?php
                  } elseif ($reviews[$i]['score'] == '2') {
                  ?>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                  <?php
                  } elseif ($reviews[$i]['score'] == '3') {
                  ?>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                  <?php
                  } elseif ($reviews[$i]['score'] == '4') {
                  ?>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
                  <?php
                  } elseif ($reviews[$i]['score'] == '5') {
                  ?>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                  <?php
                  }
                  ?>
                  <?php echo $reviews[$i]['review']; ?>
                </p>
                <p style="margin: 0px; font-size: small;">
                  By <span class="text-primary"><?php echo $reviews[$i]['firstname'] . " " . $reviews[$i]['lastname']; ?></span>
                  On <span class="text-info"><?php echo $reviews[$i]['datetime']; ?></span>
                </p>
              </div>
            </div>
          <?php
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

</body>

<script>
  $(document).ready(function() {
    let intervalId; // Declare a variable to hold the interval ID

    function startInterval() {
      // Only start the interval if it's not already running
      if (!intervalId) {
        intervalId = setInterval(checkRequest, 3000); // Start the interval
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


    startInterval();

    function checkRequest() {
      var driverID = "<?php echo $driver->driverID; ?>";

      var ref = "checkRequestByDriver";
      $.ajax({
        url: "liveUpdate.php",
        method: "post",
        data: {
          ref: ref,
          driverID: driverID
        },
        success: function(data) {
          if (data.trim() === "NO REQUESTS!") {
            startInterval();
          } else {
            $("#requestBox").html(data);
            stopInterval();
          }
        }
      })
    }

  });
</script>

</html>