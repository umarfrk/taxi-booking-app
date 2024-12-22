<?php
class Payment{
	private $con;
	private $table = "payments";

	public $paymentID;
	public $tripID;
	public $paidBy;
	public $driverID;
	public $amount;
	public $code;
	public $paymentMethod;
	public $paymentStatus;
	public $paidDateTime;
	public $active;

	public function __construct(){
		$database = new Database();
		$this->con = $database->con;
	}

	public function makePayment($data){
		$this->tripID = $this->con->real_escape_string($data['tripID']);
		$this->paidBy = $this->con->real_escape_string($data['paidBy']);
		$this->driverID = $this->con->real_escape_string($data['driverID']);
		$this->amount = $this->con->real_escape_string($data['amount']);
		$this->code = $this->con->real_escape_string($data['code']);
		$this->paymentMethod = "Cash";
		$this->paymentStatus = "Paid";
		$this->paidDateTime = date("Y-m-d H:i:s");
		$this->active = '1';

		$sql = "INSERT INTO $this->table VALUES (null, '$this->tripID', '$this->paidBy', '$this->driverID', '$this->amount', '$this->code', '$this->paymentMethod', '$this->paymentStatus', '$this->paidDateTime', '$this->active')";

		$exe = $this->con->query($sql);
		if($exe){
			$Driver = new Drivers();
			$Driver->updateDriverStatus($this->driverID, 'Available');
			header("Location: driverConsole.php?paid");
		}else{
			echo "DB Error: ".$this->con->error;
		}

	}

	public function getPaymentByCode($code){
		$sql = "SELECT * FROM $this->table where code = '$code' and active = '1'";
		$exe = $this->con->query($sql);
		if(mysqli_num_rows($exe)>=1){
			return true;
		}else{
			return false;
		}
	}
}
?>