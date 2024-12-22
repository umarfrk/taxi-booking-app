<?php
	// Config
	ob_start();
	session_start();

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	date_default_timezone_set("Asia/Colombo");

	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$host = $_SERVER['HTTP_HOST'];
	$requestUri = $_SERVER['REQUEST_URI'];
	$fullUrl = $protocol . $host . $requestUri;

	// Classes
	require "Classes/Database.php";
	require "Classes/Users.php";
	require "Classes/Drivers.php";
	require "Classes/Reservation.php";
	require "Classes/Trips.php";
	require "Classes/Payment.php";
	require "Classes/Rating.php";

	require "Classes/MailerAPI.php";
	require "Classes/SmsAPI.php";

	$mapApiKey = "AIzaSyBmDezClKTkm23mAuJrbM-w1_dFz0KYaP8";

	// Include PHPMailer classes
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader (if installed via Composer)
	require 'vendor/autoload.php';

	// OR Manually load (if you included PHPMailer manually)
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	require 'PHPMailer/src/Exception.php';
?>


	
