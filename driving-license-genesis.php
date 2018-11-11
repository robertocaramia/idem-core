<?php

	require_once('app.php');
	
	if(!isset($_POST['userAddress']) || !isset($_POST['typeOfLicense']) || !isset($_POST['country']) || !isset($_POST['state']) || !isset($_POST['expireDate'])) {
		die('Fatal Error: Non ho ricevuto i parametri POST');
	} 

	$genesis = newDrivingLicense($_POST['userAddress'],$_POST['typeOfLicense'],$_POST['country'],$_POST['state'],$_POST['expireDate']);
	



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
						<?php
						if(isset($genesis) && !empty($genesis)) {
							echo $genesis;
						} else {
							echo "error! 91823";
						}
						?>
					</div>
				</section>
			</div>
		</div>


	</section>

<?php include('footer.php'); ?>
