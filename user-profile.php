<?php
	include('header.php');
	//$_SESSION['address']
	$profile = liststreamkeyitems('people',$_SESSION['address']);
	$name = $profile[0]['data']['json']['name']; 
	$surname = $profile[0]['data']['json']['surname']; 
	$birthDate = $profile[0]['data']['json']['birthDate']; 
	$birthPlace = $profile[0]['data']['json']['birthPlace']; 
	$gender = $profile[0]['data']['json']['gender']; 
	$citizenship = $profile[0]['data']['json']['citizenship']; 
	$street = $profile[0]['data']['json']['address']['street']; 
	$streetNumber = $profile[0]['data']['json']['address']['streetNumber']; 
	$city = $profile[0]['data']['json']['address']['city']; 
	$stateRegion = $profile[0]['data']['json']['address']['state/region']; 
	$postalCode = $profile[0]['data']['json']['address']['postalCode']; 
	$country = $profile[0]['data']['json']['address']['country']; 

?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2>Profile</h2>
		
			<div class="right-wrapper pull-right">
				<ol class="breadcrumbs">
					<li>
						<a href="index.html">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li><span>Profile</span></li>
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
		
						<h2 class="panel-title">Details</h2>
					</header>
					<div class="panel-body" id="fieldsToDecrypt">
							<div class="form-group">
								<label class="col-md-3 control-label" for="name">Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" id="name" value="<?php echo $name;?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="surname">Surname</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="surname" id="surname" value="<?php echo $surname;?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="birthDate">Date of birth</label>
								<div class="col-md-6">
									<input name="birthDate" id="birthDate" class="form-control" value="<?php echo $birthDate;?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="birthPlace">Place of birth</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="birthPlace" id="birthPlace" value="<?php echo $birthPlace;?>" readonly>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-3 control-label" for="birthPlace">Gender</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="gender" id="gender" value="<?php echo $gender;?>" readonly>
								</div>
							</div>
							

							<div class="form-group" style="border-bottom: none; margin-bottom: 30px">
								<label class="col-md-3 control-label" for="citizenship">Citizenship</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="citizenship" name="citizenship" value="<?php echo $citizenship;?>" readonly>
								</div>
							</div>


							
							<div class="form-group">
								<h3 style="text-align: center">Postal Address</h3>
							</div>	

							
							
							<div class="form-group">
								<label class="col-md-3 control-label" for="route">Street and Number</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="route" name="route" readonly="readonly" value="<?php echo $street;?>" required>
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo $streetNumber;?>" readonly>
								</div>								
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="locality">City</label>
								<div class="col-md-6">
									<input type="text" class="form-control"  id="locality" name="locality" value="<?php echo $city;?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="administrative_area_level_1">State</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" value="<?php echo $stateRegion?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="postal_code">Postal Code</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postalCode;?>" readonly>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-3 control-label" for="country">Country</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="country" name="country" value="<?php echo $country;?>" readonly>
								</div>
							</div>

							
					</div>
				</section>
			</div>
		</div>
	</section>

<?php include('footer.php'); ?>
