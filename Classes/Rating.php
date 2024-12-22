<?php
class Rating{
	private $con;
	private $table = "rating";

	public $ratingID;
	public $driverID;
	public $passengerID;
	public $tripID;
	public $score;
	public $review;
	public $datetime;
	public $active;

	public $averageScore;
	public $reviewCount;

	public $scoreCountOne;
	public $scoreCountTwo;
	public $scoreCountThree;
	public $scoreCountFour;
	public $scoreCountFive;

	public function __construct(){
		$database = new Database();
		$this->con = $database->con;
	}

	public function addRating($data){
		$this->driverID = htmlspecialchars(strip_tags($data['driverID']));
		$this->passengerID = htmlspecialchars(strip_tags($data['passengerID']));
		$this->tripID = htmlspecialchars(strip_tags($data['tripID']));
		$this->score = htmlspecialchars(strip_tags($data['score']));
		$this->review = htmlspecialchars(strip_tags($data['review']));
		$this->datetime = date("Y-m-d H:i:s");
		$this->active = "1";

		$sql = "INSERT INTO $this->table VALUES (null, '$this->driverID', '$this->passengerID', '$this->tripID', '$this->score', '$this->review', '$this->datetime', '$this->active')";
		$exe = $this->con->query($sql);
		if($exe){
			header("Location: passengerConsole.php?finished");
		}else{
			echo "DB Error: ".$this->con->error;
		}
	}

	public function getRatingByDriver($driverID){
		$sql = "SELECT * FROM rating
				JOIN (SELECT userID, firstname, lastname from users) user 
				ON rating.passengerID = user.userID 
				WHERE rating.driverID = '$driverID' and active = '1'";
		$exe = $this->con->query($sql);
		$rows = [];
		if(mysqli_num_rows($exe)>=1){
			while($row = $exe->fetch_assoc()){
				$rows[] = $row;
			}
		}
		return $rows;
	}

	public function rateCal($driverID){
		$sql = "SELECT count(score) as scoreCount, sum(score) as scoreSum from rating WHERE driverID = '$driverID' and active = '1'";
		$exe = $this->con->query($sql);
		$rows = [];
		if($exe){
			$row = $exe->fetch_assoc();
			return $row;
		}else{
			return "DB Error: ".$this->con->error;
		}
		//return $rows;
	}
}
?>