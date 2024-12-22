<?php
class Users {
	public $con;
	private $table = "users";

	public $userID;

	public $firstname;
	public $lastname;
	public $useremail;
	public $userphone;

	public $password;
	
	public $nic;
	public $address;
	
	public $code;
	public $token;
	public $otp;
	public $lastLogin;
	public $type;
	public $active;


	// Constructor with correct method name
	public function __construct(){
		$database = new Database();
        $this->con = $database->con;
	}

	public function register($data){
		$this->firstname = htmlspecialchars(strip_tags($data['firstname']));
		$this->lastname = htmlspecialchars(strip_tags($data['lastname']));
		$this->useremail = htmlspecialchars(strip_tags($data['useremail']));
		$this->userphone = htmlspecialchars(strip_tags($data['userphone']));

		$this->password = password_hash('1234', PASSWORD_DEFAULT);
		
		$this->nic = htmlspecialchars(strip_tags($data['nic']));
		$this->address = htmlspecialchars(strip_tags($data['address']));

		$this->code = time();
		$this->token = md5($this->useremail.$this->nic.$this->code);  
		$this->otp = '0';
		$this->lastLogin = date("Y-m-d H:i:s");
		// Set user type based on the data input
		if($data['type'] == "Passenger"){
			$this->type = "1";
		}elseif($data['type'] == "Driver"){
			$this->type = "2";
		}

		$this->active = "1";


		// Check if the email is already registered
		if($this->checkUserEmail($this->useremail)){
		
			?>
			<div class="alert alert-warning" role="alert">
	            <h5 style="text-align: center;"><b>The Email is already registered.</b></h5>
	        </div>
			<?php
		}else{
			$sql = "INSERT INTO $this->table (userID, firstname, lastname, useremail, userphone, password, nic, address, code, token, otp, lastLogin, type, active) VALUES (null, '$this->firstname', '$this->lastname', '$this->useremail', '$this->userphone', '$this->password', '$this->nic', '$this->address', '$this->code', '$this->token', '$this->otp', '$this->lastLogin', '$this->type', '$this->active')";

			$exe = $this->con->query($sql);
			if($exe){

				$mailer = new MailerAPI();
				$message="
				<h2>QuickTrip Login Details</h2>
				<p>Thank you for registering. Here are your login credentials:</p>
				<h4>Username: Your Email</h4>
				<h4>Password: 1234</h4>
				<p>Please keep your credentials safe and do not share them with anyone.</p>
				Visit <a href='https://QuickTrip.esanwin.com/login.php?key=".$this->token."'>https://QuickTrip.esanwin.com/login.php?key=".$this->token."</a> to activate the account!";
				
				$result = $mailer->sendMail($this->useremail, 'Login Credentials', $message);

				// Success
				?>
				<div class="alert alert-success" role="alert">
					<h5 style="text-align: center;"><b>Registration Successful!</b></h5>
					<p class="text-center text-success">Please check your email!</p>
				</div>
				<?php
			}else{
				// SQL execution failed
				?>
				<div class="alert alert-warning" role="alert">
					<h5 style="text-align: center;"><?php echo $this->con->error; ?></h5>
				</div>
				<?php
			}
		}
	}


	public function checkUserEmail($useremail){
		$queryCheck = "SELECT * FROM $this->table WHERE useremail = '$useremail' AND active != '0'";
		$exe = $this->con->query($queryCheck);
		if(mysqli_num_rows($exe)>=1){
			return true;
		}else{
			return false;
		}
	}

	public function getUserByKey($key){
		$sql = "SELECT * FROM $this->table where token = '$key' and active != '0'";
		$exe = $this->con->query($sql);
		$row = $exe->fetch_assoc();

		$this->userID = $row['userID'];
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->useremail = $row['useremail'];
		$this->userphone = $row['userphone'];
		$this->password = $row['password'];
		$this->nic = $row['nic'];
		$this->address = $row['address'];
		$this->code = $row['code'];
		$this->token = $row['token'];
		$this->otp = $row['otp'];
		$this->lastLogin = $row['lastLogin'];
		$this->type = $row['type'];
		$this->active = $row['active'];
	}

	public function getUserByID($userID){
		$sql = "SELECT * FROM $this->table where userID = '$userID' and active != '0'";
		$exe = $this->con->query($sql);
		$row = $exe->fetch_assoc();

		$this->userID = $row['userID'];
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->useremail = $row['useremail'];
		$this->userphone = $row['userphone'];
		$this->password = $row['password'];
		$this->nic = $row['nic'];
		$this->address = $row['address'];
		$this->code = $row['code'];
		$this->token = $row['token'];
		$this->otp = $row['otp'];
		$this->lastLogin = $row['lastLogin'];
		$this->type = $row['type'];
		$this->active = $row['active'];
	}

	public function getUserByEmail($useremail){
		$sql = "SELECT * FROM $this->table where useremail = '$useremail' and active != '0'";
		$exe = $this->con->query($sql);
		$row = $exe->fetch_assoc();

		$this->userID = $row['userID'];
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->useremail = $row['useremail'];
		$this->userphone = $row['userphone'];
		$this->password = $row['password'];
		$this->nic = $row['nic'];
		$this->address = $row['address'];
		$this->code = $row['code'];
		$this->token = $row['token'];
		$this->otp = $row['otp'];
		$this->lastLogin = $row['lastLogin'];
		$this->type = $row['type'];
		$this->active = $row['active'];
	}

	public function generateOTP($userID){
		$otp = rand(100000, 999999);
    	$sql = "UPDATE $this->table SET otp = '$otp' where userID = '$userID'";
    	$exe = $this->con->query($sql);
    	$this->otp = $otp;
    	if($exe){
    		return $otp;
    	}
	}

	public function setPassword($data){
		if($data['otp'] == $_SESSION['OTP']){
			if($data['password1'] == $data['password2']){
				$password = password_hash($data['password1'], PASSWORD_DEFAULT);
				$this->getUserByKey($data['key']);

				$sql = "UPDATE $this->table SET password = '$password' where userID='$this->userID'";
				$exe = $this->con->query($sql);
				if($exe){
					unset($_SESSION['OTP']);
					header("Location: login.php?success");
				}
			}else{
				?>
				<div class="alert alert-danger" role="alert">
					<p class="text-center">Please check the Password!</p>
				</div>
				<?php
			}
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<p class="text-center">The OTP is Wrong!</p>
			</div>
			<?php
		}
	}


	public function Login($data){
		$useremail = htmlspecialchars($data['useremail']);
		$password = htmlspecialchars($data['password']);
		if($this->checkUserEmail($useremail)){
			$this->getUserByEmail($useremail);
			//if(password_hash($password, PASSWORD_DEFAULT) == $this->password){
			if(password_verify($password, $this->password)){
				$_SESSION['userID'] = $this->userID;
				$_SESSION['firstname'] = $this->firstname;
				$_SESSION['lastname'] = $this->lastname;
				$_SESSION['useremail'] = $this->useremail;
				$_SESSION['nic'] = $this->nic;
				$_SESSION['userphone'] = $this->userphone;
				$_SESSION['token'] = $this->token;
				$_SESSION['type'] = $this->type;

				if($this->type == '1'){
					header("Location: passengerConsole.php");
				}elseif($this->type == '2'){
					header("Location: driverConsole.php");
				}elseif($this->type == '3'){
					header("Location: operatorConsole.php");
				}elseif($this->type == '4'){
					header("Location: adminConsole.php");
				}
			}else{
				?>
				<div class="alert alert-danger" role="alert">
					<p class="text-center">Please Check the Password</p>
				</div>
				<?php
			}
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<p class="text-center">Sorry, You don't have an account!</p>
			</div>
			<?php
		}
	}
}
?>
