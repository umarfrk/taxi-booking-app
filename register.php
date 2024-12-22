<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Register - QuickTrip</title>

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
      <div class="row justify-content-center">
        
        <div class="col-md-5">

          <?php
          if(isset($_POST['btnRegister'])){
            if($_POST['type'] == "Passenger"){
              $user = new Users();
              $user->register($_POST);
            }elseif($_POST['type'] == "Driver"){
              $user = new Users();
              $user->register($_POST);
              $user->getUserByEmail($user->useremail);
              
              $driver = new Drivers();
              $driver->registerDriver($_POST, $user->userID);
            }
          }
          
          ?>

          <div class="card">
            <div class="card-header">
              <h3 class="text-center">Register</h3>

              <?php
              if(isset($_GET['type']) && $_GET['type']=="Driver"){
                ?>
                <h5 class="text-center text-success">As a Driver</h5>
                <span class="float-right"><a href="register.php"><- Back</a></span>
                <?php
              }elseif(isset($_GET['type']) && $_GET['type']=="Passenger"){
                ?>
                <h5 class="text-center text-primary">As a Passenger</h5>
                <span class="float-right"><a href="register.php"><- Back</a></span>
                <?php
              }
              ?>
              
            </div>
            
            <div class="card-body">

              

              <?php
              if(isset($_GET['type'])){
                if($_GET['type']=="Passenger"){
                  ?>
                  <form action="" method="post" id="frmRegister">
                    <input type="hidden" value="Passenger" name="type">
                    <div class="form-group">
                      <input type="text" name="firstname" class="form-control" placeholder="Firstname " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="lastname" class="form-control" placeholder="Lastname " required>
                    </div>
                    <div class="form-group">
                      <input type="email" name="useremail" class="form-control" placeholder="User Email " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="userphone" class="form-control" placeholder="User Phone " required maxlength="10">
                    </div>
                    <div class="form-group">
                      <input type="text" name="nic" class="form-control" placeholder="NIC No " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="address" class="form-control" placeholder="Address " required>
                    </div>
                    <div class="form-group">
                      <button class="form-control btn btn-primary" type="submit" name="btnRegister" id="btnRegister">Register</button>
                    </div>

                    <div class="form-group text-center">
                      <a href="login.php">Have an account?</a>
                    </div>
                  </form>
                  <?php
                }
                elseif($_GET['type']=="Driver"){
                  ?>
                  <form action="register.php" method="post" id="frmRegisterD">
                    <input type="hidden" value="Driver" name="type">
                    <input type="hidden" name="currentLat" id="currentLat">
                    <input type="hidden" name="currentLng" id="currentLng">

                    <div class="form-group">
                      <input type="text" name="firstname" class="form-control" placeholder="Firstname " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="lastname" class="form-control" placeholder="Lastname " required>
                    </div>
                    <div class="form-group">
                      <input type="email" name="useremail" class="form-control" placeholder="User Email " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="userphone" class="form-control" placeholder="User Phone " required maxlength="10">
                    </div>
                    <div class="form-group">
                      <input type="text" name="nic" class="form-control" placeholder="NIC No " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="address" class="form-control" placeholder="Address " required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="licenseNo" class="form-control" placeholder="License No " required>
                    </div>
                    <div class="form-group">
                      <input type="date" name="licenseExpireDate" class="form-control" placeholder="License Exprire Date " required>
                    </div>
                    <div class="form-group">
                      <select name="vehicleType" class="form-control" required>
                        <option value="Bike">Bike</option>
                        <option value="Tuk">Tuk</option>
                        <option value="Car">Car</option>
                        <option value="Van">Van</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" name="vehicleModel" class="form-control" placeholder="Suzuki Wagan R 2015" required>
                    </div>
                    <div class="form-group">
                      <input type="number" name="vehicleCapacity" class="form-control" placeholder="Capacity" required>
                    </div>

                    <div class="form-group">
                      <input type="text" name="vehicleNo" class="form-control" placeholder="Vehicle No" required>
                    </div>
                    <div class="form-group">
                      <button class="form-control btn btn-success" type="submit" name="btnRegister" id="btnRegister">Register</button>
                    </div>

                    <div class="form-group text-center">
                      <a href="login.php">Have an account?</a>
                    </div>
                  </form>
                  <?php
                }else{
                  header("Location: register.php");
                }
                ?>
                
                <?php
              }else{
                ?>
                <div class="form-group">
                  <a href="?type=Passenger" class="form-control btn btn-primary">As a Passenger</a>
                </div>

                <div class="form-group">
                  <a href="?type=Driver" class="form-control btn btn-success">As a Driver</a>
                </div>
                <?php
              }
              ?>

              
              
            </div>

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
    $("#btnRegister").on("click", function(){
      $("#frmRegisterD").submit();
    });


    function getCurrentLocation(){
      navigator.geolocation.getCurrentPosition(function (position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          $("#currentLat").val(latitude);
          $("#currentLng").val(longitude);
          //alert("done");
      }, function () {
          alert('Failed to fetch GPS location.');
      });
    }

    getCurrentLocation();
    setInterval(getCurrentLocation, 60000);
  });
</script>

</html>