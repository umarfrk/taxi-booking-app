<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "AMNZ_CityTaxi_DB";

    $con = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($con->connect_error) {
        // Connection failed, print the error message
        echo "Connection failed: " . $con->connect_error;
    } else {
        // Connection successful
        echo "Connection successful!";
    }


        $sqlCheck = "SELECT * FROM users WHERE useremail = '123' AND active = '0'";
        $exeCheck = $con->query($sqlCheck);
        echo $con->error;

        if(mysqli_num_rows($exeCheck)>=1){
            echo "yes";
        }else{
            echo "No";
        }
?>
