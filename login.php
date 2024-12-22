
<?php require "include/setting.php"; ?>

<?php
if(isset($_SESSION['userID']) && $_SESSION['userID']!=""){
  if($_SESSION['type'] == '1'){
    header("Location: passengerConsole.php");
  }elseif($_SESSION['type'] == '2'){
    header("Location: driverConsole.php");
  }elseif($_SESSION['type'] == '3'){
    header("Location: operatorConsole.php");
  }elseif($_SESSION['type'] == '4'){
    header("Location: adminConsole.php");
  }
}
?>

<?php $user = new Users(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Login - QuickTrip</title>

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
          if(isset($_POST['btnLogin'])){
            $user->Login($_POST);
          }

          if(isset($_POST['btnSubmit'])){
            $user->setPassword($_POST);
          }

          if(isset($_GET['success'])){
            ?>
            <div class="alert alert-success" role="alert">
              <p class="text-center">Successfully Created the password!</p>
            </div>
            <?php
          }
          if(isset($_GET['001'])){
            ?>
            <div class="alert alert-success" role="alert">
              <p class="text-center">Successfully Logged In!</p>
            </div>
            <?php
          }

          if(isset($_GET['key']) && $_GET['key']!=""){
            $user->getUserByKey($_GET['key']);
            ?>
            <div class="card">
              <div class="card-header">
                <p class="text-center text-primary">Welcome back <?php echo $user->lastname; ?></p>
                <h3 class="text-center"> Create Password</h3>
              </div>
              <div class="card-body">
                <form action="" method="post">
                  <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
                  <div class="form-group">
                    <input type="password" name="password1" id="password1" required class="form-control" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password2" id="password2" required class="form-control" placeholder="Re-Enter Password">
                  </div>
                  <div class="form-group">
                    <input type="text" name="otp" placeholder="Enter OTP Here" class="form-control" required id="otp" style="<?php if(!isset($_POST['otp'])){ echo 'display: none;'; } ?>" value="<?php if(isset($_POST['otp'])){ echo $_POST['otp']; } ?>">

                    <?php
                    if(!isset($_POST['otp']) || $_POST['otp']==""){
                      ?>
                    <button class="btn btn-sm btn-success form-control" id="btnOtp"> Send OTP </button>
                      <?php
                    }
                    ?>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="btnSubmit" id="btnSubmit" class="form-control btn btn-sm btn-primary" style="<?php if(!isset($_POST['otp'])){ echo 'display: none;'; } ?>">
                  </div>
                </form>
              </div>
            </div>
            <?php
          }else{
            ?>
            <div class="card">
              <div class="card-header">
                <h2 class="text-center">Login</h2>
              </div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="form-group">
                    <input type="email" name="useremail" class="form-control" placeholder="Email " required value="<?php if(isset($_POST['useremail'])) { echo $_POST['useremail']; } ?>">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password " required>
                  </div>
                  <div class="form-group">
                    <button class="form-control btn btn-primary" type="submit" name="btnLogin">Login</button>
                  </div>
                  <div class="form-group text-center">
                    <a href="register.php">Don't have an account?</a>
                  </div>
                </form>
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
      $(document).ready(function () {
          // Show OTP field when 'Send OTP' button is clicked
          $("#btnOtp").click(function (e) {
              e.preventDefault();
              var userID = "<?php echo $user->userID; ?>";
           
              $("#otp").slideDown(); // Show OTP field
              $(this).prop('disabled', true); // Disable 'Send OTP' button after click
           
              $.ajax({
                  url: "send_sms.php",
                  method: 'post',
                  data: {userID: userID},
                  success: function(data){
                    //alert(data);
                  }
              })
          });

          // Show Submit button when OTP field is filled
          $("#otp").on('input', function () {
              let otpValue = $(this).val();
              if (otpValue.length > 0) {
                  $("#btnSubmit").slideDown(); // Show Submit button
              } else {
                  $("#btnSubmit").slideUp(); // Hide Submit button if OTP is cleared
              }
          });
      });
  </script>

</html>