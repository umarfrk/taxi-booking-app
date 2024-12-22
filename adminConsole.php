<?php require "include/setting.php"; ?>

<?php
if(!isset($_SESSION['userID']) || $_SESSION['type']!="4"){
  header("Location: login.php");
}else{
  require "Classes/Admin.php";

  $admin = new Admin();
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

        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Registered Passengers</div>
                            <div class="text-lg fw-bold">
                              <?php $admin->getPassengerCount(); ?>
                            </div>
                        </div>
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Registered Drivers</div>
                            <div class="text-lg fw-bold">
                              <?php $admin->getDriverCount(); ?>
                            </div>
                        </div>
                        <i class="fa fa-id-card-o"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 mb-4">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Operators</div>
                            <div class="text-lg fw-bold">
                              <?php $admin->getOperatorCount(); ?>
                            </div>
                        </div>
                        <i class="fa fa-id-card-o"></i>
                    </div>
                </div>
            </div>
        </div>

      </div>




      <div class="row">
        
        

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