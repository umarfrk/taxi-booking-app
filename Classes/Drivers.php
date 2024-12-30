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

	public function registerDriver($data, $userID)
	{
		// Sanitize and assign values
		$this->userID = $userID;
		$this->licenseNo = $data['licenseNo'];
		$this->licenseExpireDate = $data['licenseExpireDate'];
		$this->vehicleType = $data['vehicleType'];
		$this->vehicleModel = $data['vehicleModel'];
		$this->vehicleCapacity = $data['vehicleCapacity'];
		$this->vehicleNo = $data['vehicleNo'];
		$this->status = "Offline";
		$this->currentLocation = $data['currentLat'] . "," . $data['currentLng'];
		$this->updatedTime = date("Y-m-d H:i:s");
		$this->active = '1';
	
		// Use a prepared statement to avoid SQL injection
		$stmt = $this->con->prepare("INSERT INTO $this->table 
			(userID, licenseNo, licenseExpireDate, vehicleType, vehicleModel, vehicleCapacity, vehicleNo, status, currentLocation, updatedTime, active) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		
		if (!$stmt) {
			echo "Failed to prepare statement: " . $this->con->error;
			return;
		}
	
		// Bind parameters
		$stmt->bind_param(
			"issssisssss",
			$this->userID,
			$this->licenseNo,
			$this->licenseExpireDate,
			$this->vehicleType,
			$this->vehicleModel,
			$this->vehicleCapacity,
			$this->vehicleNo,
			$this->status,
			$this->currentLocation,
			$this->updatedTime,
			$this->active
		);
	
		// Execute query and handle result
		if ($stmt->execute()) {
			echo "<div class='alert alert-success' role='alert'>
					<h5 style='text-align: center;'><b>Registered Driver Successfully!</b></h5>
				  </div>";
		} else {
			echo "<div class='alert alert-warning' role='alert'>
					<h5 style='text-align: center;'>Error: " . $stmt->error . "</h5>
				  </div>";
		}
	
		// Close the statement
		$stmt->close();
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