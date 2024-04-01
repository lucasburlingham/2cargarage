<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
// error_reporting(-1);


// Connect to the database
$db_conn = new SQLite3('garage.db');

// Create the table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS cars (id INTEGER PRIMARY KEY AUTOINCREMENT, model TEXT, color TEXT, price INTEGER, brand TEXT, year INTEGER, fuel INTEGER, mileage INTEGER, status INTEGER, purchase_date INTEGER, vin TEXT, primary_driver TEXT)";
$db_conn->exec($sql);


// POST implies creating a new car
if (isset($_POST['submit'])) {
	
	// convert the following to uppercase
	$model = (string) strtoupper($_POST['model']);
	$brand = (string) strtoupper($_POST['brand']);
	$color = (string) strtoupper($_POST['color']);
	$vin = (string) strtoupper($_POST['vin']);
	$primary_driver = (string) strtoupper($_POST['primary_driver']) || null;

	// Convert the price to an integer and round to the nearest $500
	$price = (int) $_POST['price'];
	$price = round($price / 500) * 500;

	$year = (int) $_POST['year'];
	$fuel = (int) $_POST['fuel']; // 1 Gasoline, 2 Diesel, 3 Electric, 4 Hybrid
	$mileage = (int) $_POST['mileage'];
	$status = (int) $_POST['status'];
	$purchase_date = (int) $_POST['purchase_date'];
	


	// Clean the input
	$model = $db_conn->escapeString($model) || null;
	$brand = $db_conn->escapeString($brand) || null;
	$color = $db_conn->escapeString($color) || null;
	$price = $db_conn->escapeString($price) || null;
	$year = $db_conn->escapeString($year) || null;
	$fuel = $db_conn->escapeString($fuel) || null;
	$mileage = $db_conn->escapeString($mileage) || null;
	$status = $db_conn->escapeString($status) || null;
	$purchase_date = $db_conn->escapeString($purchase_date) || null;
	$vin = $db_conn->escapeString($vin) || null;
	$primary_driver = $db_conn->escapeString($primary_driver) || null;


	// Create a new car
	$newCar = new Car($model, $color, $price, $brand, $year, $fuel, $mileage, $status, $purchase_date, $vin, $primary_driver);

}

// GET implies filtering the displayed cars (so get all cars and then filter)
// By default, return all cars as JSON
if(isset($_GET['filter'])) {
	$filter = $_GET['filter'];

	// if filterType is not set, default to EXACT
	$filterType = $_GET['filterType'] || 'EXACT';

	// explode the filter string into an array
	$filter = explode(",", $filter);
	$cars = Car::getAllCars();
	$filteredCars = array();

	// compare the filters to each car and return the cars that match according to the filterType
	foreach ($cars as $car) {

		if($filterType === 'EXACT') {
			if (in_array($car->getbrand(), $filter) && in_array($car->getfuel(), $filter) && in_array($car->getstatus(), $filter)) {
				array_push($filteredCars, $car);
			}
		} else if ($filterType === 'ANY') {
			if (in_array($car->getbrand(), $filter) || in_array($car->getfuel(), $filter) || in_array($car->getstatus(), $filter)) {
				array_push($filteredCars, $car);
			}
		}
	}

	return $filteredCars;
} else {
	$cars = Car::getAllCars();
	// header('Content-Type: application/json');
	echo json_encode($cars);
}
// DELETE implies removing a car
if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$id = $_GET['id'];
	$cars = Car::deleteCar($id);
	header('http 1.1 999 Car deleted');
	echo json_encode($cars);
	die(True);
}


class Car {
	public $model;
	public $color;
	public $price;
	public $brand;
	public $year;
	public $fuel;
	public $mileage;
	public $status;
	public $purchase_date;
	public $vin;
	public $primary_driver;
	public $id;


	public function __construct($model="NA", $color="NA", $price="0", $brand="NA", $year="0000", $fuel="5", $mileage, $status, $purchase_date, $vin, $primary_driver) {
		$this->model = $model;
		$this->color = $color;
		$this->price = $price;
		$this->brand = $brand;
		$this->year = $year;
		$this->fuel = $fuel;
		$this->mileage = $mileage;
		$this->status = $status;
		$this->purchase_date = $purchase_date;
		$this->id = $this->create( $model, $color, $price, $brand, $year, $fuel, $mileage, $status, $purchase_date, $vin, $primary_driver);
	}

	// Create, Read, Update, Delete (CRUD) methods

	// MODEL: string type
	public function getmodel() {
		return $this->model;
	}
	public function setmodel( $model ) {
		$this->model = $model;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET model = '$model' WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// COLOR: string type
	public function getcolor() {
		return $this->color;
	}
	public function setcolor( $color ) {
		$this->color = $color;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET color = '$color' WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// PRICE: integer type: rounded to the nearest $500
	public function getprice() {
		return $this->price;
	}
	public function setprice( $price ) {
		$this->price = $price;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET price = $price WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// BRAND: string type
	public function getbrand() {
		return $this->brand;
	}
	public function setbrand( $brand ) {
		$this->brand = $brand;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET brand = '$brand' WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// YEAR: integer type
	public function getyear() {
		return $this->year;
	}
	public function setyear( $year ) {
		$this->year = $year;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET year = $year WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// FUEL: integer type: 1 Gasoline, 2 Diesel, 3 Electric, 4 Hybrid
	public function getfuel() {
		return $this->fuel;
	}
	public function setfuel( $fuel ) {
		$this->fuel = $fuel;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET fuel = $fuel WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// MILEAGE: integer type
	public function getmileage() {
		return $this->mileage;
	}
	public function setmileage( $mileage ) {
		$this->mileage = $mileage;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET mileage = $mileage WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// STATUS: binary type: 1 ready, 0 out of service
	public function getstatus() {
		return $this->status;
	}
	public function setstatus( $status ) {
		$this->status = $status;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET status = $status WHERE id = $this->id";
		$db_conn->exec($sql);
	}
	public function removestatus() {
		$this->status = 0;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET status = 0 WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// PURCHASE_DATE: integer type
	public function getpurchase_date() {
		return $this->purchase_date;
	}
	public function setpurchase_date( $purchase_date ) {
		$this->purchase_date = $purchase_date;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET purchase_date = $purchase_date WHERE id = $this->id";
		$db_conn->exec($sql);
	}

	// VIN: string type
	public function getvin() {
		return $this->vin;
	}

	public function setvin( $vin ) {
		$this->vin = $vin;
		$db_conn = new SQLite3('garage.db');
		$sql = "UPDATE cars SET vin = '$vin' WHERE id = $this->id";
		$db_conn->exec($sql);
	}



	// CREATE (and return the id of the new car)
	public function create( $model, $color, $price, $brand, $year, $fuel, $mileage, $status, $purchase_date, $vin, $primary_driver) {
		$this->model = $model;
		$this->color = $color;
		$this->price = $price;
		$this->brand = $brand;
		$this->year = $year;
		$this->fuel = $fuel;
		$this->mileage = $mileage;
		$this->status = $status;
		$this->purchase_date = $purchase_date;
		$this->vin = $vin;
		$this->primary_driver = $primary_driver;


		// Save the new car to the database
		$db_conn = new SQLite3('garage.db');

		// Clean the input
		$model = $db_conn->escapeString($model) || null;
		$brand = $db_conn->escapeString($brand) || null;
		$color = $db_conn->escapeString($color) || null;
		$price = $db_conn->escapeString($price) || null;
		$year = $db_conn->escapeString($year) || null;
		$fuel = $db_conn->escapeString($fuel) || null;
		$mileage = $db_conn->escapeString($mileage) || null;
		$status = $db_conn->escapeString($status) || null;
		$purchase_date = $db_conn->escapeString($purchase_date) || null;
		$vin = $db_conn->escapeString($vin) || null;
		$primary_driver = $db_conn->escapeString($primary_driver) || null;
		
		$sql = "INSERT INTO cars (model, color, price, brand, year, fuel, mileage, status, purchase_date, vin, primary_driver) VALUES ('$model', '$color', '$price', '$brand', '$year', '$fuel', '$mileage', '$status', '$purchase_date', '$vin', '$primary_driver')";
		$db_conn->exec($sql);

		// Get the id of the new car and return it
		$id = $db_conn->lastInsertRowID();
		return $id;

	}
	// READ 
	public static function getCar( $id ) {

		$db_conn = new SQLite3('garage.db');
		$sql = "SELECT * FROM cars WHERE id = $id";
		$result = $db_conn->query($sql);
		$car = $result->fetchArray();
		
		return $car;
	}
	// READ ALL
	public static function getAllCars() {
		$db_conn = new SQLite3('garage.db');
		$sql = "SELECT * FROM cars";
		$result = $db_conn->query($sql);
		$cars = array();
		while ($row = $result->fetchArray()) {
			$car = array("model"=>$row['model'],"color"=>$row['color'],"price"=>$row['price'],"brand"=>$row['brand'],"year"=>$row['year'],"fuel"=>$row['fuel'],"mileage"=>$row['mileage'],"status"=>$row['status'],"purchase_date"=>$row['purchase_date'],"id"=>$row['id'], "vin"=>$row['vin']);
			array_push($cars, $car);
		}
		return $cars;
	}
	// DELETE
	public static function deleteCar( $id ) {
		$db_conn = new SQLite3('garage.db');
		$sql = "DELETE FROM cars WHERE id = $id";
		try {
			$db_conn->exec($sql);
			return True;
		} catch (Exception $e) {
			echo $e;
			return False;
		}
		
	}

}