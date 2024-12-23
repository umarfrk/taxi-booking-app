<style>
.navbar-light .navbar-nav .nav-link {
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.navbar-light .navbar-nav .nav-link:hover,
.navbar-light .navbar-nav .nav-link:focus {
  /* color: inherit !important; */
  background-color :#6c757d; 
}


</style>
<header class="header_section shadow-sm" style="background-color: black;">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand font-weight-bold text-light" href="index.php">
        QuickTrip
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Services
            </a>
            <div class="dropdown-menu" aria-labelledby="servicesDropdown">
              <a class="dropdown-item" href="rideService.php">Ride Services</a>
              <a class="dropdown-item" href="driverService.php">Driver Services</a>
              <a class="dropdown-item" href="operatorService.php">Operator Services</a>
            </div>
          </li> -->
        </ul>
        <div class="ml-lg-3">
          <?php if (isset($_SESSION['userID']) && $_SESSION['userID'] != ""): ?>
            <?php if ($_SESSION['type'] == '1'): ?>
              <a href="passengerConsole.php" class="btn btn-white btn-sm mx-2">Ride</a>
            <?php elseif ($_SESSION['type'] == '2'): ?>
              <a href="driverConsole.php" class="btn btn-white btn-sm mx-2">Driver</a>
            <?php elseif ($_SESSION['type'] == '3'): ?>
              <a href="operatorConsole.php" class="btn btn-white btn-sm mx-2">Operator</a>
            <?php elseif ($_SESSION['type'] == '4'): ?>
              <a href="adminConsole.php" class="btn btn-white btn-sm mx-2">Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="btn btn-sm btn-white">Logout</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-sm btn-white">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </div>
</header>
