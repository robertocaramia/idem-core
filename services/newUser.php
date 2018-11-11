<?php
	require_once('functions.php');

	echo "<pre>";
	print_r(newUser($_POST['name'],$_POST['surname'],$_POST['birthDate'],$_POST['birthPlace'],$_POST['gender'],$_POST['citizenship'],$_POST['route'],$_POST['street_number'],$_POST['locality'],$_POST['administrative_area_level_1'],$_POST['postal_code'],$_POST['country']));
	echo "</pre>";
	
?>