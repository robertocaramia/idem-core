<?php

require_once 'functions.php';

header('Content-Type: application/json');

$result = matchToken($_POST['idemID'], $_POST['token']);

echo json_encode($result);

?>