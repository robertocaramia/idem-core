<?php
	//session_destroy();
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		
		<link rel="stylesheet" href="assets/stylesheets/opensans.css" />

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="assets/images/logo.png" height="54" alt="IDem" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
					</div>
					<div class="panel-body">
						
						<div id="StepONE">
							<form id="StepONE_form">
								<div class="form-group mb-lg">
									<label>IDem ID</label>
									<div class="input-group input-group-icon">
										<input id="idemID" type="text" class="form-control input-lg" />
										<span class="input-group-addon">
											<span class="icon icon-lg">
												<i class="fa fa-user"></i>
											</span>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<button type="submit" class="btn btn-success btn-block">Sign In</button>
									</div>
								</div>
							</form>
						</div>
						<div id="StepTWO" style="display: none">
							<form id="StepTWO_form">
								<h3>Scan this QR code with your App for verify your identity and insert below the secret key.</h3>
								<div id="qrcode"></div>
								<div id="encToken" style='visibility: hidden; width: 0px; height: 0px'></div>
								<div class="form-group mb-lg">
									<label>Your secret</label>
									<div class="input-group input-group-icon">
										<input id="token" type="text" class="form-control input-lg" />
										<span class="input-group-addon">
											<span class="icon icon-lg">
												<i class="fa fa-key"></i>
											</span>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<button type="submit" id="sendSecretKey" class="btn btn-success btn-block">Send the Secret key</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All Rights Reserved.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Qrcode JS library -->
		<script src="assets/vendor/qrcodejs/qrcode.min.js"></script>

		<script>
			$("#StepONE_form").submit(function(e) {

			  	e.preventDefault();

			    $.ajax({
			    	type: "POST",
			    	url: "/services/getCypherToken.php",
			    	data: "idemID=" + $('#idemID').val(),
			    	dataType: "html",
			    	success: function(json){

				      	try
				      	{
			                
			                let obj = JSON.parse(json);
							let result = Object.values(obj);
							$('#StepONE').hide();
							$('#StepTWO').show();
							new QRCode(document.getElementById("qrcode"), String(result));
							$('#encToken').text(String(result))
			            }
			            catch(err) {
			                alert('Error: An error has occurred.\r\n' + err);
			            }

			    	},
			    	error: function(){

			        	alert("Error: Couldn't be connect.");

			    	}
			    });

			});

			

			$("#StepTWO_form").submit(function(e) {

			  	e.preventDefault();

			  	$.ajax({
			    	type: "POST",
			    	url: "/services/matchToken.php",
			    	data: "token=" + $('#token').val() + "&idemID=" + $('#idemID').val(),
			    	dataType: "html",
			    	success: function(json){

				      	try
				      	{
			                
			                let obj = JSON.parse(json);
							let result = Object.values(obj);
							if(result == "LOGGED") {
								window.location.replace("index.php");
							}
							// alert('Login: ' + String(result));
							
			            }
			            catch(err) {
			                alert('Error: An error has occurred.\r\n' + err);
			            }

			    	},
			    	error: function(){

			        	alert("Error: Couldn't be connect.");

			    	}
			    });
			});
		  
		</script>
		
		<style>
			#qrcode img { width: 100%; padding: 15px; }
			#StepTWO h3 { text-align: center; }
		</style>

	</body>
</html>