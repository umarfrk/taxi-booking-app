<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>AMNZCityTaxi</title>

  <?php include "include/head.php"; ?>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->


    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div class="box">
        <div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Welcome To AMNZ City Taxi
                      </h1>
                      <p class="col-lg-11 px-0">
                        At City Taxi, we are dedicated to providing a safe, reliable, and convenient transportation solution for our customers. With years of experience in the industry, our mission is to transform the way people travel by offering exceptional service and cutting-edge technology.
                      </p>
                      <a href="about.php">
                        Read More
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Welcome To AMNZ City Taxi
                      </h1>
                      <p class="col-lg-11 px-0">
                        At City Taxi, we are dedicated to providing a safe, reliable, and convenient transportation solution for our customers. With years of experience in the industry, our mission is to transform the way people travel by offering exceptional service and cutting-edge technology.
                      </p>
                      <a href="about.php">
                        Read More
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Welcome To AMNZ City Taxi
                      </h1>
                      <p class="col-lg-11 px-0">
                        At City Taxi, we are dedicated to providing a safe, reliable, and convenient transportation solution for our customers. With years of experience in the industry, our mission is to transform the way people travel by offering exceptional service and cutting-edge technology.
                      </p>
                      <a href="about.php">
                        Read More
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="carousel-btn-box">
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!-- book section -->

  <section class="book_section ">
    <div class="container">
      <div class="col-md-11 col=lg-9 mx-auto px-0">
        <div class="book_form ">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <div class="input-group ">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-car" aria-hidden="true"></i>
                    </div>
                  </div>
                  <input type="text" class="form-control" id="inputDestination" placeholder="Car Type">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="input-group ">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                    </div>
                  </div>
                  <input type="text" class="form-control" id="inputDestination" placeholder="Phone Number">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <div class="input-group ">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                  </div>
                  <input type="text" class="form-control" id="inputDestination" placeholder="Pickup Location ">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="input-group ">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                  </div>
                  <input type="text" class="form-control" id="inputLocation" placeholder="Drop Location">
                </div>
              </div>
            </div>
            <div class="btn-box">
              <button type="submit" class="">Book Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <!-- end book section -->


  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                About Us
              </h2>
            </div>
            <p>
              At City Taxi, we are dedicated to providing a safe, reliable, and convenient transportation solution for our customers. With years of experience in the industry, our mission is to transform the way people travel by offering exceptional service and cutting-edge technology.
            </p>
            <a href="about.php">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- why section -->

  <section class="why_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Why Choose Us
        </h2>
      </div>
      <div class="why_container">
        <div class="row">
          <div class="col-md-4">
            <div class="box b1">
              <div class="img-box">
                <img src="images/w1.png" alt="" class="" />
              </div>
              <div class="detail-box">
                <h5>
                  Fast & Easy Booking
                </h5>
                <p style="display: none;">
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its It is a
                  long established fact that a reader
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box b2">
              <div class="img-box">
                <img src="images/w2.png" alt="" class="" />
              </div>
              <div class="detail-box">
                <h5>
                  Driving safety
                </h5>
                <p style="display: none;">
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its It is a
                  long established fact that a reader
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box b3">
              <div class="img-box">
                <img src="images/w3.png" alt="" class="" />
              </div>
              <div class="detail-box">
                <h5>
                  Full Satisfaction
                </h5>
                <p style="display: none;">
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its It is a
                  long established fact that a reader
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end why section -->

  <!-- app section -->

  <section class="app_section layout_padding" style="display: none;">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Download Our App
              </h2>
            </div>
            <p>
              It is a long established fact that a reader will be distracted by
              the readable content of a page when looking at its layout. The point
              of using Lorem Ipsum is that it has a more-or-less normal
              distribution of letters
            </p>
            <div class="btn-box">
              <a href="">
                <img src="images/app_store.png" alt="">
              </a>
              <a href="">
                <img src="images/google_play.png" alt="">
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/app-img.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer section -->
  <?php include "include/footer.php"; ?>
  <!-- footer section -->


  <?php include "include/bottom.php"; ?>

</body>

</html>