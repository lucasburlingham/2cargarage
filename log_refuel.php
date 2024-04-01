<?php

$title = "Log Refueling Event";

include_once 'assets/elements/before.php';
?>

<body>

	<?php
	include_once 'assets/elements/head.php';
	include_once 'assets/elements/nav.php';
	?>


	<div class="container mb-2">
		<div class="row">
			<div class="col"></div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-xs-10">
				<h1 class="mx-auto center"><?php echo $title; ?></h1>
				<form action="/handler.php" method="POST" class="form">

					<?php

					// Get the car's ID and name from handler.php and display it
					$garage = file_get_contents("http://localhost/handler.php");

					$garage = json_decode($garage, true);

					foreach ($garage as $car) {
						// Show the car's name and set the value of the dropdown to the car's ID
						echo <<<EOT

									<div class="form-floating mb-3">
										<select class="form-select" placeholder="Select a vehicle">
									EOT;
						foreach ($garage as $car) {
							$car_name = $car['year'] . " " . $car['make'] . " " . $car['model'];
							$car_id = $car['id'];

							echo '<option value="' . $car_id . '">' . $car_name . '</option>';
						}
						echo <<<EOT
										</select>
										<label for="new_event_form_car">Car</label>
									</div>

									EOT;
					}
					?>

					<div class="form-floating mb-3">
						<input type="number" name="mileage" placeholder="Mileage" id="new_event_form_mileage" min="0" step="100" class="form-control" required>
						<label for="new_event_form_mileage">Mileage</label>
					</div>
					<div class="form-floating mb-3">
						<input type="number" name="cost" placeholder="cost" id="new_event_form_cost" min="0" step="500" class="form-control" autocomplete="transaction-amount" required>
						<label for="new_event_form_cost">Cost</label>
					</div>
					<div class="form-floating mb-3">
						<input type="date" name="event_date" placeholder="Event Date" id="new_event_form_event_date" class="form-control" required>
						<label for="new_event_form_event_date">Event Date</label>
					</div>
					<div class="form-floating mb-3">
						<input type="text" name="notes" placeholder="Notes" id="new_event_form_notes" class="form-control">
						<label for="new_event_form_notes">Notes</label>
					</div>
					<input type="hidden" name="form_type" value="fuel">
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
			<div class="col"></div>
		</div>
	</div>

	<?php
	include_once 'assets/elements/footer.php';
	include_once 'assets/elements/after.php';
	?>