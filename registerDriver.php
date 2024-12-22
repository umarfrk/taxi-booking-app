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
          

          if(isset($_POST['btnregisterDriver'])){
            echo "<script>alert('he')</script>";
            var_dump($_POST);
            $user = new Users();
            $user->register($_POST);
            $user->getUserByEmail($user->useremail);
            echo "fhere";
            $driver = new Driver();
            $driver->registerDriver($_POST, $user->userID);
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
                if($_GET['type']=="Driver"){
                  ?>
                  <form action="" method="post" id="frmRegisterD">
                    <input type="hidden" value="Driver" name="type">
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
                      <input type="text" name="licenseNO" class="form-control" placeholder="License No " required>
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
                      <button class="form-control btn btn-success" type="submit" name="btnRegisterDriver" id="btnRegisterDriver">Register</button>
                    </div>

                    <div class="form-group text-center">
                      <a href="login.php">Have an account?</a>
                    </div>
                  </form>
                  <?php
                }else{
                  header("Location: registerDriver.php");
                }
                ?>
                
                <?php
              }else{
                ?>
                <div class="form-group">
                  <a href="?type=Passenger" class="form-control btn btn-primary">As a Passenger</a>
                </div>

                <div class="form-group">
                  <a href="registerDriver.php?type=Driver" class="form-control btn btn-success">As a Driver</a>
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
    $("#btnRegisterDriver").on("click", function(){
      $("#frmRegisterD").submit();
    });

    
  });
</script>

</html>