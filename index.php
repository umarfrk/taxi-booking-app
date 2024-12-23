<?php require "include/setting.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>QuickTrip</title>

  <?php include "include/head.php"; ?>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <?php include "include/header.php"; ?>
    <!-- end header section -->


    <!-- slider section -->
    <section class="slider_section position-relative">
      <div class="box">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Who We Are
                      </h1>
                      <p class="col-lg-11 px-0">
                        QuickTrip (PVT) Ltd is a leading taxi service provider based in Colombo, Sri Lanka. Our team is passionate about ensuring every journey is comfortable, efficient, and enjoyable. We pride ourselves on our fleet of well-maintained vehicles and professional drivers who prioritize your safety and satisfaction.
                      </p>
                      <a href="about.php" class="btn-dark">
                        Learn More
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
            <div class="carousel-item">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Our Vision
                      </h1>
                      <p class="col-lg-11 px-0">
                        At QuickTrip, our vision is to revolutionize travel by offering innovative, safe, and reliable transportation solutions. We aim to enhance every journey through top-notch service and cutting-edge technology.
                      </p>
                      <a href="about.php" class="btn-dark">
                        Discover More
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
            <div class="carousel-item">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        Why Choose Us
                      </h1>
                      <p class="col-lg-11 px-0">
                        We prioritize your convenience and safety with a fleet of well-maintained vehicles, professional drivers, and 24/7 service availability. QuickTrip is committed to making your travels stress-free and enjoyable.
                      </p>
                      <a href="about.php" class="btn-dark">
                        Find Out More
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
              <button type="submit" class="btn-dark">Book Now</button>
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
                Our Vision
              </h2>
            </div>
            <p>
              At QuickTrip, our vision is to revolutionize transportation by offering seamless and sustainable travel experiences. We aim to integrate advanced technology, eco-friendly practices, and unmatched customer service to meet the evolving needs of modern travelers.
            </p>
            <a href="about.php" class="btn-dark">
              Learn More
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
        Why QuickTrip Stands Out
      </h2>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="box b1">
          <div class="img-box">
            <img src="images/w1.png" alt="Fast Booking" />
          </div>
          <div class="detail-box">
            <h5>
              Effortless Booking Experience
            </h5>
            <p>
              With our simple and intuitive booking system, you can easily book a ride in just a few clicks, ensuring a quick and seamless experience every time.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box b2">
          <div class="img-box">
            <img src="images/w2.png" alt="Driving Safety" />
          </div>
          <div class="detail-box">
            <h5>
              Prioritizing Your Safety
            </h5>
            <p>
              Your safety is our top priority. Our professional drivers undergo rigorous training and adhere to strict safety standards to ensure a secure journey.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box b3">
          <div class="img-box">
            <img src="images/w3.png" alt="Full Satisfaction" />
          </div>
          <div class="detail-box">
            <h5>
              Unmatched Customer Satisfaction
            </h5>
            <p>
              We strive for excellence in every ride. Our goal is to exceed your expectations by providing top-notch service, reliable rides, and customer satisfaction.
            </p>
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