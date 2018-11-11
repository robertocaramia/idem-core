<?php include('header.php'); ?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2>Create a new user</h2>
		
			<div class="right-wrapper pull-right">
				<ol class="breadcrumbs">
					<li>
						<a href="index.html">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li><span>Create a new user</span></li>
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
						<form class="form-horizontal form-bordered" method="POST" id="newuser" action="user-genesis.php">
							<div class="form-group">
								<label class="col-md-3 control-label" for="name">Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" id="name" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="surname">Surname</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="surname" id="surname" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="birthDate">Date of birth</label>
								<div class="col-md-6">
									<input name="birthDate" id="birthDate" placeholder="<?php echo _('dd/mm/yyyy'); ?>" class="form-control" value="" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="birthPlace">Place of birth</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="birthPlace" id="birthPlace">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="gender">Gender</label>
								<div class="col-md-6">
									<div class="radio-custom">
										<input type="radio" name="gender" id="male" value="0" required>
										<label for="male">Male</label>
									</div>

									<div class="radio-custom radio-primary">
										<input type="radio" name="gender" value="1" id="female">
										<label for="female">Female</label>
									</div>
								</div>
							</div>

							<div class="form-group" style="border-bottom: none; margin-bottom: 30px">
								<label class="col-md-3 control-label" for="citizenship">Citizenship</label>
								<div class="col-md-6">
									<select class="form-control" id="citizenship" name="citizenship" required>

									</select>
								</div>
							</div>


							
							<div class="form-group">
								<h3 style="text-align: center">Postal Address</h3>
							</div>	

							
							<div class="form-group">
								<label class="col-md-3 control-label" for="street">Search an address</label>
								<div class="col-md-6">
									<input id="autocomplete" class="form-control" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
						    	</div>
						    </div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="route">Street and Number</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="route" name="route" readonly="readonly" required>
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="street_number" name="street_number" readonly="readonly" required>
								</div>								
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="locality">City</label>
								<div class="col-md-6">
									<input type="text" class="form-control"  id="locality" name="locality" readonly="readonly" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="administrative_area_level_1">State</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" readonly="readonly" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label" for="postal_code">Postal Code</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="postal_code" name="postal_code" readonly="readonly" required>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-3 control-label" for="country">Country</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="country" name="country" readonly="readonly" required>
								</div>
							</div>

							<div class="form-groug">
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
  $("#birthDate").mask("?99/99/9999", {});
  $( function() {
    $( "#birthDate" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1900:'+(new Date).getFullYear(),
      maxDate: 0,
      dateFormat: 'dd/mm/yy'
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

	$("#newuser").validate({
		rules: {
			name: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			surname: {
				required: true,
				normalizer: function(value) {
					return $.trim(value);
				}
			},
			birthDate: {
				required: true,
				DateFormat : true
			},
			birthPlace: {
				required: true
			},
			gender: {
				required: true
			},
			citizenship: {
				required: true
			},
			route: {
				required: true
			},
			locality: {
				required: true
			},
			administrative_area_level_1: {
				required: true
			},
			postal_code: {
				required: true
			},
			country: {
				required: true
			},

		}
	});

</script>





<script>

//get a reference to the select element
$select = $('#citizenship');
//request the JSON data and parse into the select element
$.ajax({
  url: 'resources/databases/citizenship.json',
  dataType:'JSON',
  success:function(data){
    //clear the current content of the select
    $select.html('');
    $select.append('<option value="" disabled selected> -- Select an option --</option>');

    //iterate over the data and append a select option
    $.each(data, function(key, val){
      $select.append('<option value="' + val.Name + '">' + val.Name + '</option>');
    })
  },
  error:function(){
    //if there is an error append a 'none available' option
    $select.html('<option id="-1">none available</option>');
  }
});
</script>




<script>
     

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {



      	// Place of birth
	    var options = {
			types: ['(cities)']
		};

		var inputBirthPlace = document.getElementById('birthPlace');
		autocompleteBirthPlace = new google.maps.places.Autocomplete(inputBirthPlace, options);


        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);

      }



      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW2peWb-O-8Yqlgij3SlREnGSD5pqXUro&libraries=places&callback=initAutocomplete" async defer></script>
