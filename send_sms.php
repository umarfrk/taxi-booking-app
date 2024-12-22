<?php
require "include/setting.php";

if (isset($_POST['userID']) && $_POST['userID'] != "") {
    $user = new Users();
    $user->getUserByID($_POST['userID']);
    $otp = $user->generateOTP($_POST['userID']);
    
    $_SESSION['OTP'] = $otp;
    
    $message = "Hello " . $user->lastname . ", The OTP for your account at AMNZCityTaxi is " . $otp;
    
    $smsApi = new SmsApi();
	$to = '94' . substr($user->userphone, 1);

    $response = $smsApi->sendSms($to, $message);

    if ($response['status'] == 'success') {
        echo "SMS sent successfully.";
    } else {
        echo "Error sending SMS: " . $response['message'];
    }
} else {
    echo "Error: User ID is required.";
}
?>
