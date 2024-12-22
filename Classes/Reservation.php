<?php
class Reservation{
    public $con;
    private $table = "reservation";

    public $reservationID ;
    public $reservationType;
    public $reservedBy;
    public $passengerName;
    public $passengerPhone;
    public $passengerNIC;
    public $vehicleType;
    public $pickupLocation;
    public $dropoffLocation;
    public $reservedDateTime;
    public $scheduledDateTime;
    public $distance;
    public $amount;
    public $note;
    public $status;
    public $code;
    public $active;

    public function __construct(){
        $database = new Database();
        $this->con = $database->con;
    }

    public function Reserve ($data ){
        $this->reservationType = "Manual";
        $this->reservedBy = 1;
        $this->passengerName =htmlspecialchars($data['passengerName']);
        $this->passengerPhone = htmlspecialchars($data['passengerPhone']);
        $this->passengerNIC = htmlspecialchars($data['passengerNIC']);
        $this->vehicleType = htmlspecialchars($data['vehicleType']);
        $this->pickupLocation = htmlspecialchars($data['pickupLocation']);
        $this->dropoffLocation = htmlspecialchars($data['dropoffLocation']);
        $this->reservedDateTime = date("Y-m-d H:i:s");
        $this->scheduledDateTime = htmlspecialchars($data['scheduledDateTime']);
        $this->distance = htmlspecialchars($data['distance']);
        $this->amount = htmlspecialchars($data['amount']);
        $this->note = htmlspecialchars($data['note']);
        $this->status = "Pending";
        $this->code = time();
        $this->active = "1";

         $sql = "INSERT INTO `reservation`(`reservationID`, `reservationType`, `reservedBy`, `passengerName`,`passengerPhone`,`passengerNIC`,`vehicleType`,`pickupLocation`, `dropoffLocation`, `reservedDateTime`, `scheduledDateTime`, `distance`, `amount`, `note`, `status`, `code`, `active`) VALUES (null,'$this->reservationType','$this->reservedBy','$this->passengerName','$this->passengerPhone','$this->passengerNIC','$this->vehicleType','$this->pickupLocation','$this->dropoffLocation','$this->reservedDateTime','$this->scheduledDateTime', '$this->distance','$this->amount','$this->note','$this->status','$this->code','$this->active')";
        


        $exe = $this->con->query($sql);
        if($exe){
            header("Location: operatorConsole.php?success");
        }else{
            echo $this->con->error;
        }

    }


    // System Reservation by Theesan
    public function SystemReservation($data){
        $this->reservationType = "System";
        $this->reservedBy = $_SESSION['userID'];

        $this->passengerName =htmlspecialchars($data['passengerName']);
        $this->passengerPhone = htmlspecialchars($data['passengerPhone']);
        $this->passengerNIC = htmlspecialchars($data['passengerNIC']);
        $this->vehicleType = htmlspecialchars($data['vehicleType']);

        $this->pickupLocation = htmlspecialchars($data['pickup_latitude'].','.$data['pickup_longitude']);
        $this->dropoffLocation = htmlspecialchars($data['dropoff_latitude'].','.$data['dropoff_longitude']);
        $this->reservedDateTime = date("Y-m-d H:i:s");
        $this->scheduledDateTime = date("Y-m-d H:i:s");
        $this->distance = (double)$data['distance'];
        $this->amount = $this->distance * 100;
        $this->note = "";
        $this->status = "Pending";
        $this->code = time();
        $this->active = "1";

        $sql = "INSERT INTO `reservation`(`reservationID`, `reservationType`, `reservedBy`, `passengerName`,`passengerPhone`,`passengerNIC`,`vehicleType`,`pickupLocation`, `dropoffLocation`, `reservedDateTime`, `scheduledDateTime`, `distance`, `amount`, `note`, `status`, `code`, `active`) VALUES (null,'$this->reservationType','$this->reservedBy', '$this->passengerName', '$this->passengerPhone', '$this->passengerNIC', '$this->vehicleType', '$this->pickupLocation', '$this->dropoffLocation', '$this->reservedDateTime', '$this->scheduledDateTime', '$this->distance', '$this->amount', '$this->note', '$this->status', '$this->code', '$this->active')";
        


        $exe = $this->con->query($sql);
        if($exe){
            $row = $this->getReservationByCode($this->code);
            $_SESSION['passengerTrack'] = $row['code'];
            header("Location: passengerConsole.php?code=$row[code]");
        }else{
            echo $this->con->error;
        }

    }



    public function ManualReservation($data){
        $this->reservationType = "Manual";
        $this->reservedBy = $_SESSION['userID'];

        $this->passengerName =htmlspecialchars($data['passengerName']);
        $this->passengerPhone = htmlspecialchars($data['passengerPhone']);
        $this->passengerNIC = htmlspecialchars($data['passengerNIC']);
        $this->vehicleType = htmlspecialchars($data['vehicleType']);

        $this->pickupLocation = htmlspecialchars($data['pickup_latitude'].','.$data['pickup_longitude']);
        $this->dropoffLocation = htmlspecialchars($data['dropoff_latitude'].','.$data['dropoff_longitude']);
        $this->reservedDateTime = date("Y-m-d H:i:s");
        $this->scheduledDateTime = date("Y-m-d H:i:s");
        $this->distance = (double)$data['distance'];
        $this->amount = $this->distance * 100;
        $this->note = "";
        $this->status = "Pending";
        $this->code = time();
        $this->active = "1";

        $sql = "INSERT INTO `reservation`(`reservationID`, `reservationType`, `reservedBy`, `passengerName`,`passengerPhone`,`passengerNIC`,`vehicleType`,`pickupLocation`, `dropoffLocation`, `reservedDateTime`, `scheduledDateTime`, `distance`, `amount`, `note`, `status`, `code`, `active`) VALUES (null,'$this->reservationType','$this->reservedBy', '$this->passengerName', '$this->passengerPhone', '$this->passengerNIC', '$this->vehicleType', '$this->pickupLocation', '$this->dropoffLocation', '$this->reservedDateTime', '$this->scheduledDateTime', '$this->distance', '$this->amount', '$this->note', '$this->status', '$this->code', '$this->active')";
        


        $exe = $this->con->query($sql);
        if($exe){
            $row = $this->getReservationByCode($this->code);
            $_SESSION['passengerTrack'] = $row['code'];
            header("Location: operatorConsole.php?done");
        }else{
            echo $this->con->error;
        }

    }


    public function getAllManualReservation(){
        $sql = "SELECT * from $this->table where reservationType = 'Manual' and active = '1'";
        $exe = $this->con->query($sql);
        if($exe){
            $records = [];
            while($row = $exe->fetch_assoc()){
                $records[] = $row;
            }
            return $records;
        }
    }

    public function getReservationByID($ID){
        $sql = "SELECT * FROM $this->table where reservationID = '$ID' and active = '1' ";
        $exe = $this->con->query($sql);
        $row = $exe->fetch_assoc();
        return $row;
    }

    public function getReservationByCode($code){
        $sql = "SELECT * FROM $this->table where code = '$code' and active = '1' ";
        $exe = $this->con->query($sql);
        if(mysqli_num_rows($exe)>=1){
            $row = $exe->fetch_assoc();

            $this->reservationID = $row['reservationID'] ;
            $this->reservationType = $row['reservationType'];
            $this->reservedBy = $row['reservedBy'];
            $this->passengerName = $row['passengerName'];
            $this->passengerPhone = $row['passengerPhone'];
            $this->passengerNIC = $row['passengerNIC'];
            $this->vehicleType = $row['vehicleType'];
            $this->pickupLocation = $row['pickupLocation'];
            $this->dropoffLocation = $row['dropoffLocation'];
            $this->reservedDateTime = $row['reservedDateTime'];
            $this->scheduledDateTime = $row['scheduledDateTime'];
            $this->distance = $row['distance'];
            $this->amount = $row['amount'];
            $this->note = $row['note'];
            $this->status = $row['status'];
            $this->code = $row['code'];
            $this->active = $row['active'];

            return $row;
        }else{
            header("Location: index.php");
        }
    }

    public function cancelReservationByCode($code){
        if($_SESSION['type'] == '3'){
            $sql = "DELETE FROM $this->table where code = '$code' and status = 'Pending' and active = '1' ";
            $exe = $this->con->query($sql);
            if($exe){
                $trip = new Trips();
                $trip->cancelTripByCode($code);
                header("Location: operatorConsole.php");
            }else{
                echo "DB Error: ". $this->con->error;
            }
        }else{
            $res = $this->checkReservation();
            if($res == false){
                ?>
                <div class="alert alert-warning" role="alert">
                    <p style="text-align: center;"><b>You CAN NOT cancel the trip. </b><br>The Driver has confirmed the trip.</p>
                </div>
                <?php
            }else{
                $sql = "DELETE FROM $this->table where code = '$code' and status = 'Pending' and active = '1' ";
                $exe = $this->con->query($sql);
                if($exe){
                    $trip = new Trips();
                    $trip->cancelTripByCode($code);
                    header("Location: passengerConsole.php");
                }else{
                    echo "DB Error: ". $this->con->error;
                }
            }
        }
    }

    public function checkReservation(){
        $sql = "SELECT * FROM $this->table where reservedBy = '$_SESSION[userID]' and active = '1'";
        $exe = $this->con->query($sql);
        if(mysqli_num_rows($exe)>=1){
            $row = $exe->fetch_assoc();
            if($row['status'] == "Pending"){
                header("Location: passengerConsole.php?code=".$row['code']);
            }elseif($row['status'] == "Confirmed"){

                $Payment = new Payment();
                if($Payment->getPaymentByCode($row['code'])){
                    //header("Location: passengerConsole.php?Done");
                }else{
                    header("Location: track.php?code=".$row['code']);
                }
            }
        }else{
            return false;
        }
    }

    public function updateReservationStatusByDriver($data){
        $reservationID = $data['reservationID'];
        $sql = "UPDATE $this->table SET status = 'Confirmed' where reservationID = '$reservationID' and active = '1'";
        $exe = $this->con->query($sql);
        if($exe){
            $Driver = new Drivers();
            $Driver->updateDriverStatus($data['driverID'], "Busy");
            header("Location: track.php?code=".$data['note']);
        }else{
            echo "DB Error: ".$this->con->error;
        }
    }
}


?>

