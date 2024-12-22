<?php
class Trips{
	public $con;
	private $table = "trips";

	public $tripID;
	public $reservationID;
	public $driverID;
	public $status;
	public $arrivedTime;
	public $pickupTime;
	public $dropoffTime;
	public $amount;
	public $note;
	public $token;
	public $active;

	public function __construct(){
		$database = new Database();
		$this->con = $database->con;
	}

	public function requestTrip($reservationID, $driverID, $token, $amount, $reservationCode){
		$this->reservationID = $this->con->real_escape_string($reservationID);
		$this->driverID = $this->con->real_escape_string($driverID);
		$this->token = $this->con->real_escape_string($token);
		$this->amount = $this->con->real_escape_string($amount);
		$reservationCode = $this->con->real_escape_string($reservationCode);

		$sql = "INSERT INTO $this->table VALUES (null, '$this->reservationID', '$this->driverID', 'Waiting', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '$this->amount', '$reservationCode', '$this->token', '1')";
		$exe = $this->con->query($sql);
		if($exe){
			return true;
		}else{
			return false;
		}
	}

	public function checkTripsByDriverID($driverID){
		$sql = "SELECT * from $this->table where driverID = '$driverID' and status = 'Waiting' and active = '1'";
		$exe = $this->con->query($sql);
		if(mysqli_num_rows($exe)>0){
			$row = $exe->fetch_assoc();
			$this->tripID = $row['tripID'];
			$this->reservationID = $row['reservationID'];
			$this->driverID = $row['driverID'];
			$this->status = $row['status'];
			$this->arrivedTime = $row['arrivedTime'];
			$this->pickupTime = $row['pickupTime'];
			$this->dropoffTime = $row['dropoffTime'];
			$this->amount = $row['amount'];
			$this->note = $row['note'];
			$this->token = $row['token'];
			$this->active = $row['active'];

			return true;
		}else{
			return false;
		}
	}

	public function checkCurrentTrip($driverID){
		$sql = "SELECT * from $this->table where driverID = '$driverID' and status = 'Accepted' and active = '1'";
		$exe = $this->con->query($sql);
		if(mysqli_num_rows($exe)>=1){
			$row = $exe->fetch_assoc();
			header("Location: track.php?code=".$row['note']);
		}
	}

	public function checkTripsByPassenger($reservationID, $note){
		$sql = "SELECT * from $this->table where reservationID = '$reservationID' and note = '$note' and active = '1'";
		$exe = $this->con->query($sql);
		if(mysqli_num_rows($exe)>0){
			$row = $exe->fetch_assoc();
			return $row['status'];
		}else{
			return "No";
		}
	}

	public function cancelTripByID($tripID){
		$tripID = $this->con->real_escape_string(strip_tags($tripID));

		$sql = "DELETE from $this->table WHERE tripID = '$tripID' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			return true;
		}else{
			return false;
		}
	}

	public function cancelTripByCode($note){
		$sql = "DELETE FROM $this->table where note = '$note' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			return true;
		}else{
			return false;
		}
	}

	public function acceptTripRequest($data){
		$this->tripID = $this->con->real_escape_string($data['tripID']);
		$this->reservationID = $this->con->real_escape_string($data['reservationID']);
		$this->driverID = $this->con->real_escape_string($data['driverID']);
		$this->note = $this->con->real_escape_string($data['note']); // Code from Reservation
		$this->token = $this->con->real_escape_string($data['token']);

		$sql = "UPDATE $this->table SET status = 'Accepted' where tripID = '$this->tripID' and reservationID = '$this->reservationID' and driverID = '$this->driverID' and note = '$this->note' and token = '$this->token'";
		$exe = $this->con->query($sql);
		if($exe){
			$Reservation = new Reservation();
			$Reservation->updateReservationStatusByDriver($data);
			$Reservation->getReservationByCode($this->note);

			$Driver = new Drivers();
			$rowD = $Driver->getDriverByID($this->driverID);

			$to = $Reservation->passengerPhone;
			$text = "Hello ".$Reservation->passengerName.". Please Contact Your Driver. Name: ".$rowD['lastname'].". Phone: ".$rowD['userphone'].". Vehicle NO: ".$rowD['vehicleNo'].".";

			$SMS = new SmsAPI();
			$SMS->sendSms($to, $text);
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}

	public function getTripByCode($code){
		$sql = "SELECT * FROM $this->table where note = '$code' and active = '1'";
		$exe = $this->con->query($sql);
		if(mysqli_num_rows($exe)>=1){
			$row = $exe->fetch_assoc();
			$this->tripID = $row['tripID'];
			$this->reservationID = $row['reservationID'];
			$this->driverID = $row['driverID'];
			$this->status = $row['status'];
			$this->arrivedTime = $row['arrivedTime'];
			$this->pickupTime = $row['pickupTime'];
			$this->dropoffTime = $row['dropoffTime'];
			$this->amount = $row['amount'];
			$this->note = $row['note'];
			$this->token = $row['token'];
			$this->active = $row['active'];
		}
	}


	public function updateTripStatus($data){
		$this->tripID = $this->con->real_escape_string(strip_tags($data['tripID']));
		$this->note = $this->con->real_escape_string(strip_tags($data['note']));
		$this->status = $this->con->real_escape_string(strip_tags($data['status']));

		if($this->status == "Arrived"){
			$arrivedTime = date("Y-m-d H:i:s");
			$sql = "UPDATE $this->table SET status = '$this->status', arrivedTime = '$arrivedTime' WHERE tripID = '$this->tripID' and note = '$this->note' and active = '1'";
		}elseif($this->status == "PickedUp"){
			$pickupTime = date("Y-m-d H:i:s");
			$sql = "UPDATE $this->table SET status = '$this->status', pickupTime = '$pickupTime' WHERE tripID = '$this->tripID' and note = '$this->note' and active = '1'";
		}elseif($this->status == "DroppedOff"){
			$pickupTime = date("Y-m-d H:i:s");
			$sql = "UPDATE $this->table SET status = '$this->status', pickupTime = '$pickupTime' WHERE tripID = '$this->tripID' and note = '$this->note' and active = '1'";
		}

		$exe = $this->con->query($sql);
		if($exe){
			header("Location: track.php?code=".$this->note);
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}
}
?>