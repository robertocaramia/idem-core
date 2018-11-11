<?php
	
	// prevengo ogni tipo di XSS

	if(isset($_POST)) {
		$_POST = array_map('strip_tags', $_POST);
	}

	if(isset($_GET)) {
		$_GET = array_map('strip_tags', $_GET);
	}


	// prevengo attacchi CSRF con libreria

	require_once('assets/vendor/csrf-magic/csrf-magic.php');
?>