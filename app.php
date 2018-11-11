<?php
	require_once('services/functions.php');
	sec_session_start();
	
	//require_once('idem_sanitizer.php');
	
	
	
	if(!isset($_SESSION['address'])) {
		header('Location: login.php');
		die();
	}

?>
