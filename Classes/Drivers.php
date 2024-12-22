<?php
class Drivers{
	public $con;
	private $table = "drivers";

	public $driverID;
	public $userID;
	public $licenseNo;
	public $licenseExpireDate;
	public $vehicleType;
	public $vehicleModel;
	public $vehicleCapacity;
	public $vehicleNo;
	public $status;
	public $currentLocation;
	public $updatedTime;
	public $active;


	public function __construct(){
		$database = new Database();
		$this->con = $database->con;
	}

	public function registerDriver($data, $userID){
		$this->userID = htmlspecialchars($userID);
		$this->licenseNo = htmlspecialchars($data['licenseNo']);
		$this->licenseExpireDate = htmlspecialchars($data['licenseExpireDate']);
		$this->vehicleType = htmlspecialchars($data['vehicleType']);
		$this->vehicleModel = htmlspecialchars($data['vehicleModel']);
		$this->vehicleCapacity = htmlspecialchars($data['vehicleCapacity']);
		$this->vehicleNo = htmlspecialchars($data['vehicleNo']);
		$this->status = "Offline";
		$this->currentLocation = htmlspecialchars($data['currentLat'].",".$data['currentLng']);
		$this->updatedTime = date("Y-m-d H:i:s");
		$this->active = '1';

		$sql = "INSERT INTO $this->table VALUES (null, '$this->userID', '$this->licenseNo', '$this->licenseExpireDate', '$this->vehicleType', '$this->vehicleModel', '$this->vehicleCapacity', '$this->vehicleNo', '$this->status', '$this->currentLocation', '$this->updatedTime', '$this->active')";
		$exe = $this->con->query($sql);
		if($exe){
			?>
			<!-- <div class="alert alert-success" role="alert">
				<h5 style="text-align: center;"><b>Registered Driver Successful!</b></h5>
			</div> -->
			<?php
		}else{
			?>
			<div class="alert alert-warning" role="alert">
				<h5 style="text-align: center;"><?php echo $this->con->error; ?></h5>
			</div>
			<?php
		}
	}

	public function getDriverByUser($userID){
		$sql = "SELECT * FROM $this->table where userID = '$userID' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			$row = $exe->fetch_assoc();

			$this->driverID = $row['driverID'];
			$this->licenseNo = $row['licenseNo'];
			$this->licenseExpireDate = $row['licenseExpireDate'];
			$this->vehicleType = $row['vehicleType'];
			$this->vehicleModel = $row['vehicleModel'];
			$this->vehicleCapacity = $row['vehicleCapacity'];
			$this->vehicleNo = $row['vehicleNo'];
			$this->status = $row['status'];
		}
	}

	public function getDriverByID($driverID){
		$sql = "SELECT * FROM drivers 
				JOIN (SELECT userID, firstname, lastname, useremail, userphone, token from users) users
				ON drivers.userID = users.userID
				WHERE drivers.driverID='$driverID'";
		$exe = $this->con->query($sql);
		if($exe){
			$row = $exe->fetch_assoc();

			$this->driverID = $row['driverID'];
			$this->userID = $row['userID'];
			$this->licenseNo = $row['licenseNo'];
			$this->licenseExpireDate = $row['licenseExpireDate'];
			$this->vehicleType = $row['vehicleType'];
			$this->vehicleModel = $row['vehicleModel'];
			$this->vehicleCapacity = $row['vehicleCapacity'];
			$this->vehicleNo = $row['vehicleNo'];
			$this->status = $row['status'];

			return $row;
		}
	}

	public function updateDriverStatus($driverID, $status){
		$updatedTime = date("Y-m-d H:i:s");

		$sql = "UPDATE $this->table SET status = '$status', updatedTime = '$updatedTime' where driverID = '$driverID'";
		$exe = $this->con->query($sql);
		if($exe){
			header("Location: driverConsole.php");
		}
	}

	public function updateDriverLocation($latitude, $longitude){
		$latitude = $this->con->real_escape_string($latitude);
		$longitude = $this->con->real_escape_string($longitude);

		$currentLocation = $latitude.",".$longitude;
		$userID = $_SESSION['userID'];
		$updatedTime = date("Y-m-d H:i:s");

		$sql = "UPDATE $this->table SET currentLocation = '$currentLocation', updatedTime = '$updatedTime' where userID = '$userID' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			return true;
		}else{
			return false;
		}
	}

	public function getAvailableDrivers(){
		$sql = "SELECT * FROM drivers 
				JOIN (SELECT userID, firstname, lastname, useremail, userphone, token from users) users
				ON drivers.userID = users.userID
				WHERE drivers.status = 'Available' and drivers.updatedTime > NOW() - INTERVAL 1 MINUTE";
		$exe = $this->con->query($sql);
		if($exe){
			$rows = [];
			while($row = $exe->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}
	}
}
?>