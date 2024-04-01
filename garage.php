<?php

$title = "View Garage";

// Get the JSON from handler.php
$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://" . $_SERVER['HTTP_HOST'] . '/handler.php';

// Get the cars as JSON from the database
$response = file_get_contents($url);

$garage = json_decode($response, true);

include_once 'assets/elements/before.php';
?>

<body>

<?php 
include_once 'assets/elements/head.php';
include_once 'assets/elements/nav.php';
?>
	<div class="container">
	<h1 class="mx-auto center"><?php echo $title; ?></h1>
		<table class="table table-striped table-hover">
			<thead>
				<tr scope="row">
					<th scope="col">ID</th>
					<th scope="col">Brand</th>
					<th scope="col">Model</th>
					<th scope="col">Color</th>
					<th scope="col">Year</th>
					<th scope="col">Fuel</th>
					<th scope="col">Mileage</th>
					<th scope="col">Price</th>
					<th scope="col">Purchase Date</th>
					<th scope="col">VIN</th>
					<th scope="col">Primary Driver</th>
					<th scope="col">Last Oil Change</th>
					<th scope="col">Status</th>
				</tr>
			</thead>
			<tbody>
					<?php
					foreach ($garage as $car) {

						if ($car['status'] == 1) {
							$car['status'] = "Operational";
						} else {
							$car['status'] = "Not operational";
						}

						switch ($car['fuel']) {
							case 1:
								$car['fuel'] = "Gasoline";
								break;
							case 2:
								$car['fuel'] = "Diesel";
								break;
							case 3:
								$car['fuel'] = "Electric";
								break;
							case 4:
								$car['fuel'] = "Hybrid";
								break;
						}

						// @ is used to suppress the error message, which is expected if the primary driver is null (facepalm)
						if (@$car['primary_driver'] == null) {
							$car['primary_driver'] = " ";
						}

						if (@$car['last_oil_change'] == null) {
							$car['last_oil_change'] = " ";
						}

						echo <<<EOT
						<tr scope="row">
							<th scope="row">{$car['id']}</td>
							<td>{$car['brand']}</td>
							<td>{$car['model']}</td>
							<td>{$car['color']}</td>
							<td>{$car['year']}</td>
							<td>{$car['fuel']}</td>
							<td>{$car['mileage']}</td>
							<td>{$car['price']}</td>
							<td>{$car['purchase_date']}</td>
							<td>{$car['vin']}</td>
							<td>{$car['primary_driver']}</td>
							<td>{$car['last_oil_change']}</td>
							<td>{$car['status']}</td>
							<td><a href="edit.php?id={$car['id']}">Edit</a></td>
							<td><button class="delete-button" data-id="{$car['id']}">Delete</button></td>
						</tr>
						EOT;
					}

					?>
			</tbody>
		</table>
	</div>

<?php
include_once 'assets/elements/footer.php';
include_once 'assets/elements/after.php';
?>