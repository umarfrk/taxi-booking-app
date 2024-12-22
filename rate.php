<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>AMNZ City Taxi</title>

  <?php include "include/head.php"; ?>

  <style>
        /* Basic styling for stars */
        .stars {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
        .star {
            font-size: 30px;
            color: #ccc;
        }
        .star.selected {
            color: #FFD700;
        }
        /* Styling for the review area */
        .review-container {
            margin-top: 20px;
            max-width: 500px;
        }
        .review-textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            resize: none;
            font-size: 16px;
            border: 1px solid #ddd;
        }
        .submit-btn {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>

  <?php
  if(isset($_GET['code']) && $_GET['code']!=""){
    $code = htmlspecialchars(strip_tags($_GET['code']));

    $Reservation = new Reservation();
    $Reservation->getReservationByCode($code);

    $Trip = new Trips();
    $Trip->getTripByCode($code);

    $Driver = new Drivers();
    $DriverRec = $Driver->getDriverByID($Trip->driverID);
  }else{
    header("Location: passengerConsole.php");
  }
  ?>
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

        <div class="col-md-6">
          <h2 class="text-center">Rate Driver</h2>
          <p class="text-center">
            <?php echo $DriverRec['firstname']." ".$DriverRec['lastname']; ?>
            <br>
            <span class="badge badge-info"><?php echo $Driver->vehicleType; ?></span>
          <span class="badge badge-info"><?php echo $Driver->vehicleModel; ?></span>
          <span class="badge badge-info"><?php echo $Driver->vehicleNo; ?></span>
          </p>
          <hr>
        </div>

      </div>


      <div class="row justify-content-center">
        <div class="col-md-6">

          <?php
          if(isset($_POST['btnRate'])){
            $Rating = new Rating();
            $Rating->addRating($_POST);
          }
          ?>

          <form action="" method="post">
            
            <input type="hidden" name="driverID" value="<?php echo $Driver->driverID; ?>">
            <input type="hidden" name="passengerID" value="<?php echo $_SESSION['userID']; ?>">
            <input type="hidden" name="tripID" value="<?php echo $Trip->tripID; ?>">
            <input type="hidden" name="score" id="score">

            <div class="rating-container">
                
                <div class="stars">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
            </div>

            <div class="review-container">
                <h3>Leave a Review</h3>
                <textarea class="review-textarea" placeholder="Write your review ..." name="review"></textarea>
                <button class="submit-btn" type="submit" name="btnRate">Submit</button>
            </div>


          </form>
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

    let starcount;
    // JavaScript for handling star selection
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        star.addEventListener('click', () => {
            // Remove selected class from all stars
            stars.forEach(s => s.classList.remove('selected'));
            // Add selected class to the clicked star and all previous ones
            for (let i = 0; i < star.dataset.value; i++) {
                stars[i].classList.add('selected');
            }
        });


    });

    $(document).ready(function(){
      $(document).on("click", ".star", function(){
        starcount = $(this).attr("data-value");
        $("#score").val(starcount);
      });
    });

    
</script>
</html>
