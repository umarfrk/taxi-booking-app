<?php
	session_start();

	unset($_SESSION['userID']);
	unset($_SESSION['firstname']);
	unset($_SESSION['lastname']);
	unset($_SESSION['useremail']);
	unset($_SESSION['userphone']);
	unset($_SESSION['token']);
	unset($_SESSION['type']);

	session_destroy();

	header("Location: login.php");
?>