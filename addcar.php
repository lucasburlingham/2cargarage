<s?php

$title = "Add Car";

include_once 'assets/elements/before.php';
?>

<body>

<s?php 
include_once 'assets/elements/head.php';
include_once 'assets/elements/nav.php';
?>
<div class="container">
	<div class="row"></div>
	<div class="row">
		<div class="col"></div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-10">
		<h1 class="mx-auto center"><?php echo $title; ?></h1>
			<form action="/handler.php" method="POST" class="form needs-validation">
				<div class="form-floating mb-3">
					<input type="text" name="brand" placeholder="Brand" id="new_car_form_brand" class="form-control" required>
					<label for="new_car_form_brand">Brand</label>
				</div>
				<div class="form-floating mb-3">
					<input type="text" name="model" placeholder="Model" id="new_car_form_model" class="form-control form-floating" required>
					<label for="new_car_form_model">Model</label>
				</div>
				<div class="form-floating mb-3">
					<input type="text" name="color" placeholder="Color" id="new_car_form_color" class="form-control" required>
					<label for="new_car_form_color">Color</label>
				</div>
				<div class="form-floating mb-3">
					<input type="number" name="year" placeholder="Year" id="new_car_form_year" min="1901" max="<?php echo $year; ?>" class="form-control" required>
					<label for="new_car_form_year">Year</label>
				</div>
				<div class="form-floating mb-3">
					<select name="fuel" id="fuel_picker" class="form-select">
						<option value="1">Gasoline</option>
						<option value="2">Diesel</option>
						<option value="3">Electric</option>
						<option value="4">Hybrid</option>
					</select>
					<label for="new_car_form_fuel_picker">Choose a fuel type:</label>
				</div>
				<div class="form-floating mb-3">
					<input type="number" name="mileage" placeholder="Mileage" id="new_car_form_mileage" min="0" step="100" class="form-control" required>
					<label for="new_car_form_mileage">Mileage</label>
				</div>
				<div class="form-floating mb-3">
					<input type="number" name="price" placeholder="Price" id="new_car_form_price" min="0" step="500" class="form-control" autocomplete="transaction-amount" required>
					<label for="new_car_form_price">Price</label>
				</div>
				<div class="form-floating mb-3">
					<input type="date" name="purchase_date" placeholder="Purchase Date" id="new_car_form_purchase_date" class="form-control" required>
					<label for="new_car_form_purchase_date">Purchase Date</label>
				</div>
				<div class="form-floating mb-3">
					<input type="text" name="vin" placeholder="VIN" id="new_car_form_vin" class="form-control" maxlength="17" minlength="17" pattern="\b[(A-H|J-N|P|R-Z|0-9)]{17}\b" required>
					<label for="new_car_form_vin">VIN</label>
				</div>
				<div class="form-floating mb-3">
					<input type="text" name="primary_driver" placeholder="Primary Driver" id="new_car_form_primary_driver" class="form-control" autocomplete="name">
					<label for="new_car_form_primary_driver">Primary Driver</label>
				</div>
				<div class="form-check form-switch my-3">
					<input class="form-check-input" type="checkbox" role="switch" id="new_car_form_status" name="status" value="1" checked>
					<label class="form-check-label" for="new_car_form_status">Car is operational</label>
				</div>
				<button type="submit" name="submit" id="new_car_form_submit" class="btn btn-primary">Add Car</button>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>


<!-- New car confirmation toast https://getbootstrap.com/docs/5.3/components/toasts/ -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
	<div id="new_car_form_confirmation_toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<img class="rounded me-2" alt="...">
			<strong class="me-auto">New Car added to garage</strong>
			<small>11 mins ago</small>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			The car has successfully been added to the garage. Go to <a class="tab" href="/garage.php" target=htmz>Your Garage to view it!</a>
		</div>
	</div>
</div>

<script>
try {
	const form = document.getElementById('new_car_form');
	form.addEventListener('submit', function (event) {
	
		status = document.getElementById('new_car_form_status');
		// If the status checkbox is not checked, insert a 0 into the form data and submit it
		if (!status.checked) {
			status.value = 0;
		}
		// Clear form data once submitted
		form.reset();
		const new_car_confirmation = document.getElementById('new_car_form_confirmation_toast');
		const toastBootstrap = bootstrap.Toast.getOrCreateInstance(new_car_confirmation);
		toastBootstrap.show();
	});
} catch (error) {
	console.error(error);
}
</script>

<?php

include_once 'assets/elements/footer.php';
include_once 'assets/elements/after.php';
?>