<?php
class Database{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db = "AMNZ_CityTaxi_DB";

	public $con;

	public function __construct(){
		$this->getConnection();
	}

	public function getConnection(){
		$this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if($this->con->connect_error){
			die("Database connection failed: " . $this->con->connect_error);
		}
	}

    public function close() {
        $this->con->close();
    }
}

?>	