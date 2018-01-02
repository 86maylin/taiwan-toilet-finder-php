<?php
  function check_required_fields(){
	  if(!isset($_GET['country']) || !isset($_GET['city']) || !isset($_GET['village']) || !isset($_GET['name']) || !isset($_GET['address']) || !isset($_GET['latitude']) || !isset($_GET['longitude']) || !isset($_GET['type'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $country, $city, $village, $name, $address, $latitude, $longitude, $type;
	  
	  function __construct (){
		  $this->country = $_GET['country'];
		  $this->city = $_GET['city'];
		  $this->village = $_GET['village'];
		  $this->name = $_GET['name'];
		  $this->address = $_GET['address'];
		  $this->latitude = $_GET['latitude'];
		  $this->longitude = $_GET['longitude'];
		  $this->type = $_GET['type'];
	  }
  }
  
  function execute_insert($fields){
	  require "config_insert.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		INSERT INTO to_add_restroom (country, city, village, name, address, latitude, longitude, type)
		VALUES(:country, :city, :village, :name, :address, :latitude, :longitude, :type)");
	  $statement->execute([
		'country' => $fields->country, 'city' => $fields->city, 'village' => $fields->village, 'name' => $fields->name,
		'address' => $fields->address, 'latitude' => $fields->latitude, 'longitude' => $fields->longitude, 'type' => $fields->type]);
  }
  
  try{
	  check_required_fields();
	  $fields = new fields();
	  execute_insert($fields);
	  echo 'Insert succeeded. ';
  }
  catch(Exception $e){
	  echo 'Insert failed. ' .$e->getMessage();
  }
?>