<?php
	
	// XSS PROTECTION

	if(isset($_POST)) {
		$_POST = array_map('strip_tags', $_POST);
	}

	if(isset($_GET)) {
		$_GET = array_map('strip_tags', $_GET);
	}


	// CSRF PROTECTION

	require_once('assets/vendor/csrf-magic/csrf-magic.php');

?>
