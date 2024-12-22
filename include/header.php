<header class="header_section ">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>
              AMNZ City Taxi
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
          </button>
          <div class="collapse navbar-collapse ml-auto  " id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item ">
                <a class="nav-link" href="index.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About </a>
              </li>
              
            </ul>
            <div class="user_option ">
              <?php
              //echo $_SESSION['userID'];
              //$_SESSION['firstname'];
              //$_SESSION['lastname'];
              //$_SESSION['useremail'];
              //$_SESSION['userphone'];
              //$_SESSION['token'];
              //$_SESSION['type'];

              if(isset($_SESSION['userID']) && $_SESSION['userID']!=""){

                if($_SESSION['type'] == '1'){
                  ?>
                  <a href="passengerConsole.php" class="" style="margin-right: 10px;">RIDE</a>
                  <?php
                }elseif($_SESSION['type'] == '2'){
                  ?>
                  <a href="driverConsole.php" class="" style="margin-right: 10px;">DRIVER</a>
                  <?php
                }elseif($_SESSION['type'] == '3'){
                  ?>
                  <a href="operatorConsole.php" class="" style="margin-right: 10px;">OPERATOR</a>
                  <?php
                }elseif($_SESSION['type'] == '4'){
                  ?>
                  <a href="adminConsole.php" class="" style="margin-right: 10px;">ADMIN</a>
                  <?php
                }

                ?>
                <a href="logout.php" class="">Logout</a>
                <?php
              }else{
                ?>
                <a href="login.php" class="">Login</a>
                <?php
              }
              ?>
              
            </div>
          </div>
        </nav>
      </div>
    </header>