<!-- <script src="js/jquery-3.4.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>


<script src="js/MapAPI.js"></script>

<?php
	if(isset($_SESSION['type']) && $_SESSION['type']=="1"){
		
	}
	elseif(isset($_SESSION['type']) && $_SESSION['type']=="2"){
		?>
		<script>
		  $(document).ready(function(){
		    function getCurrentLocation(){
		      navigator.geolocation.getCurrentPosition(function (position) {
		          const latitude = position.coords.latitude;
		          const longitude = position.coords.longitude;

		          var type = "Driver";

		          $.ajax({
		            url: "liveUpdate.php",
		            method: "post",
		            data: {latitude: latitude, longitude: longitude, type: type},
		            success: function(data){
		              //alert(data);
		            }
		          });
		      }, function () {
		          //alert('Failed to fetch GPS location.');
		      });
		    }

		    getCurrentLocation();
		    setInterval(getCurrentLocation, 60000);
		  });
		</script>
		<?php
	}
?>