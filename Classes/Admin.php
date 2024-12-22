<?php
class Admin{
	private $con;

	public function __construct(){
		$database = new Database();
		$this->con = $database->con;
	}

	public function getPassengerCount(){
		$sql = "SELECT count(userID) as pcount from users where type = '1' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			$row = $exe->fetch_assoc();
			echo $row['pcount'];
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}
	
	public function getDriverCount(){
		$sql = "SELECT count(userID) as dcount from users where type = '2' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			$row = $exe->fetch_assoc();
			echo $row['dcount'];
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}

	public function getOperatorCount(){
		$sql = "SELECT count(userID) as ocount from users where type = '3' and active = '1'";
		$exe = $this->con->query($sql);
		if($exe){
			$row = $exe->fetch_assoc();
			echo $row['ocount'];
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}

	
}
?>