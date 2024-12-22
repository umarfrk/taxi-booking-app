<?php
require "include/setting.php";

### UPDATE DRIVER LOCATION
if(
	isset($_POST['latitude']) && $_POST['latitude']!="" && 
	isset($_POST['longitude']) && $_POST['longitude']!="" && 
	isset($_POST['type']) && $_POST['type']!=""
){

	$latitude = htmlspecialchars($_POST['latitude']);
	$longitude = htmlspecialchars($_POST['longitude']);
	
	if($_POST['type'] == "Driver"){
		//Driver
		$driver = new Drivers();
		if($driver->updateDriverLocation($latitude, $longitude)){
			echo "Done";
		}else{
			echo "not done";
		}
	}
}


### LIST AVAILABLE DRIVERS
if(
	isset($_POST['ref']) && $_POST['ref']=="getDriverList" && 
	isset($_POST['pickupLat']) && $_POST['pickupLat']!="" && 
	isset($_POST['pickupLng']) && $_POST['pickupLng']!=""
){
	$pickupLat = htmlspecialchars($_POST['pickupLat']);
	$pickupLng = htmlspecialchars($_POST['pickupLng']);

	$Drivers = new Drivers();
	$rows = $Drivers->getAvailableDrivers();
	/*echo $rows['vehicleType'];
	echo "<pre>";
	var_dump($rows);
	echo "</pre>";*/

	for ($i=0; $i < count($rows); $i++) { 
		?>
		<button class="form-control text-left driverList" id="<?php echo $rows[$i]['driverID']; ?>" data-id="<?php echo $rows[$i]['token']; ?>">
			<i class="fa fa-taxi"></i> <?php echo $rows[$i]['vehicleModel']; ?> 
			<span class="badge"><?php echo $rows[$i]['firstname']." ".$rows[$i]['lastname']; ?></span>
		</button>
		<?php
	}
}


### REQUEST DRIVERS
if(
	isset($_POST['ref']) && $_POST['ref']=="requestDriver" && 
	isset($_POST['reservationID']) && $_POST['reservationID']!="" && 
	isset($_POST['driverID']) && $_POST['driverID']!="" && 
	isset($_POST['token']) && $_POST['token']!="" && 
	isset($_POST['amount']) && $_POST['amount']!="" && 
	isset($_POST['reservationCode']) && $_POST['reservationCode']!=""
){
	$reservationID = htmlspecialchars($_POST['reservationID']);
	$driverID = htmlspecialchars($_POST['driverID']);
	$token = htmlspecialchars($_POST['token']);
	$amount = htmlspecialchars($_POST['amount']);
	$reservationCode = htmlspecialchars($_POST['reservationCode']);

	$Trips = new Trips();
	$res = $Trips->requestTrip($reservationID, $driverID, $token, $amount, $reservationCode);
	if($res){
		echo "True";
	}else{
		echo "False";
	}
}


### CheckTrips for Driver
if(
	isset($_POST['ref']) && $_POST['ref']=="checkRequestByDriver" &&
	isset($_POST['driverID']) && $_POST['driverID']!=""
){
	$Trips = new Trips();
	$res = $Trips->checkTripsByDriverID($_POST['driverID']);
	if($res){
		$reservation = new Reservation();
		$row = $reservation->getReservationByID($Trips->reservationID);
		?>
		<div class="card">
			<div class="card-body">
				<h3 class="text-center text-success"><b>Request By</b></h3>
				<h5 class="text-center"><?php echo $row['passengerName']; ?></h5>
				<h5 class="text-center"><a href="tel:<?php echo $row['passengerPhone']; ?>"><?php echo $row['passengerPhone']; ?></a></h5>

				<p class="text-center">LRK <?php echo $Trips->amount; ?></p>

				<form action="" method="post">
					<input type="hidden" name="tripID" value="<?php echo $Trips->tripID; ?>">
					<input type="hidden" name="reservationID" value="<?php echo $Trips->reservationID; ?>">
					<input type="hidden" name="driverID" value="<?php echo $Trips->driverID; ?>">
					<input type="hidden" name="note" value="<?php echo $Trips->note; ?>">
					<input type="hidden" name="token" value="<?php echo $Trips->token; ?>">
					<hr>
					<button type="submit" name="btnAcceptRequest" class="form-control btn btn-primary">ACCEPT</button>
					<hr>
					<button type="submit" name="btnCancelTrip" class="form-control btn btn-dark" onclick="return confirm('Are you sure?')">Cancel</button>
				</form>
			</div>
		</div>
		<?php
	}else{
		echo "NO REQUESTS!";
	}
}


### Check Request Status by Passenger
if(
	isset($_POST['ref']) && $_POST['ref']=="checkRequestStatus" && 
	isset($_POST['reservationID']) && $_POST['reservationID']!="" && 
	isset($_POST['note']) && $_POST['note']!=""
){
	$trip = new Trips();
	$status = $trip->checkTripsByPassenger($_POST['reservationID'], $_POST['note']);

	echo $status;
}



### check Driver Status on Trip
if(
	isset($_POST['ref']) && $_POST['ref']=="checkDriverStatus" && 
	isset($_POST['code']) && $_POST['code']!=""
){
	$trip = new Trips();
	$trip->getTripByCode($_POST['code']);

	$Payment = new Payment();
	if($Payment->getPaymentByCode($_POST['code'])){
		echo "Paid";
	}else{
		echo $trip->status;
	}
}
?>