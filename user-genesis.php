<?php

	require_once('app.php');
	
	if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['birthDate']) || !isset($_POST['birthPlace']) || !isset($_POST['gender']) || !isset($_POST['citizenship']) || !isset($_POST['route']) || !isset($_POST['street_number']) || !isset($_POST['locality']) || !isset($_POST['administrative_area_level_1']) || !isset($_POST['postal_code']) || !isset($_POST['country'])) {
		die('Fatal Error: Non ho ricevuto i parametri POST');
	} 
	$genesis = newUser($_POST['name'],$_POST['surname'],$_POST['birthDate'],$_POST['birthPlace'],$_POST['gender'],$_POST['citizenship'],$_POST['route'],$_POST['street_number'],$_POST['locality'],$_POST['administrative_area_level_1'],$_POST['postal_code'],$_POST['country']);
	
	/*
	$Address = preg_replace( "/\r|\n/", "", $genesis['Address'] );
	$ECDSApriv = preg_replace( "/\r|\n/", "", $genesis['ECDSA private key'] );
	$ECDSApub = preg_replace( "/\r|\n/", "", $genesis['ECDSA public key'] );
	$RSApriv = preg_replace( "/\r|\n/", "", $genesis['RSA private key'] );
	$RSApub = preg_replace( "/\r|\n/", "", $genesis['RSA public key'] );
	$SYMkey = preg_replace( "/\r|\n/", "", $genesis['Symetric key'] );
	*/
	$Address = $genesis['Address'];
	$ECDSApriv = $genesis['ECDSA private key'];
	$ECDSApub = $genesis['ECDSA public key'];
	$RSApriv = $genesis['RSA private key'];
	$RSApub = $genesis['RSA public key'];
	$SYMkey = $genesis['Symetric key'];


	require_once('header.php');

?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2>Genesis</h2>
		
			<div class="right-wrapper pull-right">
				<ol class="breadcrumbs">
					<li>
						<a href="index.html">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li><span>Genesis</span></li>
				</ol>
		
				<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
			</div>
		</header>

		<!-- start: page -->
	
		
		<div class="row">
			<div class="col-lg-12">
			
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
							<a href="#" class="fa fa-times"></a>
						</div>
		
						<h2 class="panel-title">Genesis</h2>
					</header>
					<div class="panel-body">
						<div class="col-md-12">
							<form action="user-generate-keys.php" method="POST" target="_blank">
								<input type="hidden" name="Address" value="<?php echo $Address;?>">
								<input type="hidden" name="ECDSApriv" value="<?php echo $ECDSApriv;?>">
								<input type="hidden" name="ECDSApub" value="<?php echo $ECDSApub;?>">
								<input type="hidden" name="RSApriv" value="<?php echo $RSApriv;?>">
								<input type="hidden" name="RSApub" value="<?php echo $RSApub;?>">
								<input type="hidden" name="SYMkey" value="<?php echo $SYMkey;?>">
								<button type="submit" class="btn btn-success btn-block btn-lg">DOWNLOAD A .ZIP FILE</button></a>
							</form>

						</div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="col-md-12">
							<div class="owl-carousel" data-plugin-carousel data-plugin-options='{ "items": 1,  "navigation": true, "pagination": false }' style="display: block; opacity: 1">
								<div class="item text-center">
									<div id="Address"></div>
									<h4>Address</h4>
								</div>
								<div class="item text-center">
									<div id="ECDSApriv"></div>
									<h4>ECDSA Private Key</h4>

								</div>
								<div class="item text-center">
									<div id="ECDSApub"></div>
									<h4>ECDSA Public Key</h4>
								</div>
								<div class="item text-center">
									<div id="RSApriv"></div>
									<h4>RSA Private Key</h4>
								</div>
								<div class="item text-center">
									<div id="RSApub"></div>
									<h4>RSA Public Key</h4>
								</div>
								<div class="item text-center">
									<div id="SYMkey"></div>
									<h4>Symetric Key</h4>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>






	</section>

<?php include('footer.php'); ?>

<script src="assets/vendor/qrcodejs/qrcode.new.js"></script>
<script>

	var typeNumber = 40;
	var errorCorrectionLevel = 'M';
	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $Address;?>`);
	qr.make();
	document.getElementById('Address').innerHTML = qr.createImgTag();
	delete qr;

	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $ECDSApriv;?>`);
	qr.make();
	document.getElementById('ECDSApriv').innerHTML = qr.createImgTag();
	delete qr;

	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $ECDSApub;?>`);
	qr.make();
	document.getElementById('ECDSApub').innerHTML = qr.createImgTag();
	delete qr;

	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $RSApriv;?>`);
	qr.make();
	document.getElementById('RSApriv').innerHTML = qr.createImgTag();
	delete qr;

	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $RSApub;?>`);
	qr.make();
	document.getElementById('RSApub').innerHTML = qr.createImgTag();
	delete qr;

	var qr = qrcode(typeNumber, errorCorrectionLevel);
	qr.addData(`<?php echo $SYMkey;?>`);
	qr.make();
	document.getElementById('SYMkey').innerHTML = qr.createImgTag();
	delete qr;


</script>