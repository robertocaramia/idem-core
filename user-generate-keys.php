<?php

require_once('app.php');

if(!isset($_POST)) {
	// inviare warning
	die('error');
}


$Address = $_POST['Address'];
$ECDSApriv = $_POST['ECDSApriv'];
$ECDSApub = $_POST['ECDSApub'];
$RSApriv = $_POST['RSApriv'];
$RSApub = $_POST['RSApub'];
$SYMkey = $_POST['SYMkey'];


$zip = new ZipArchive();
$path = "./temp/";
$filename = "credentials.zip";

$file = $path . $filename;
if ($zip->open($file, ZIPARCHIVE::CREATE)!==TRUE) {
   exit("cannot open <$filename>\n");
}

$zip->addFromString("did", $Address);
$zip->addFromString("ECDSA.priv", $ECDSApriv);
$zip->addFromString("ECDSA.pub", $ECDSApub);
$zip->addFromString("RSA.priv", $RSApriv);
$zip->addFromString("RSA.pub", $RSApub);
$zip->addFromString("SYM.key", $SYMkey);


$zip->close();

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Transfer-Encoding: binary");
// make sure the file size isn't cached
clearstatcache();
header("Content-Length: ".filesize($file));
// output the file
readfile($file);
unlink($file);

?>