<?php

require_once 'functions.php';

header('Content-Type: application/json');

$result = getCypherToken($_POST['idemID']);


echo json_encode($result);
?>