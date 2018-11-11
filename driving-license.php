<?php
	include('header.php');
	//$_SESSION['address']
	/*
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
	*/
?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2>Driving License</h2>
		
			<div class="right-wrapper pull-right">
				<ol class="breadcrumbs">
					<li>
						<a href="index.html">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li><span>Driving license</span></li>
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
					<div class="panel-body">
						<form class="form-horizontal form-bordered" method="POST" id="newdrivinglicense" action="driving-license-genesis.php">

							<div class="form-group">
								<label class="col-md-3 control-label" for="userAddress">User Address</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="userAddress" id="userAddress" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="typeOfLicense">Type of license</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="typeOfLicense" id="typeOfLicense" value="" placeholder="Example: DRLMC">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="country">Country</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="country" id="country" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="state">State</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="state" id="state" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="expireDate">Expire date</label>
								<div class="col-md-6">
									<input name="expireDate" id="expireDate" placeholder="<?php echo _('dd/mm/yyyy'); ?>" class="form-control" value="" required autocomplete="off">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="owner">Owner</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="owner" id="owner" value="<?php echo $_SESSION['address']; ?>" readonly="">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-9">
									<button type="submit" class="btn btn-success btn-block">Submit</button>
								</div>
							</div>
						</form>			
					</div>
				</section>
			</div>
		</div>
	</section>

<?php include('footer.php'); ?>


<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.min.js"></script>

<script>
  	//	$("#expireDate").mask("?99/99/9999", {});
  	$(document).ready(function() {
	    $("#expireDate").datepicker({
		    format: 'dd/mm/yyyy',
		    startDate: new Date(), // minimo oggi
		    endDate: new Date(new Date().setFullYear(new Date().getFullYear() + 10)) // max dieci anni
	    });
	});
</script>

<script>
	// VALIDAZIONE LATO CLIENT

	 $.validator.addMethod(
     "DateFormat",
     function(value, element) {
     return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
     },
      "Please enter a date in the format dd/mm/yyyy"
     );

	$("#newdrivinglicense").validate({
		rules: {
			userAddress: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			typeOfLicense: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			country: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			state: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			expireDate: {
				required: true,
				DateFormat : true
			}
		}
	});

</script>