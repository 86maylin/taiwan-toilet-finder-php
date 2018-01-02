<?php
  function check_required_fields(){
	  if(!isset($_GET['city'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $city;
	  
	  function __construct (){
		  $this->city = $_GET['city'];
	  }
  }
  
  function execute_query($fields){
	  require "config_query.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		SELECT * FROM public_restroom
		WHERE city = :city");
	  $statement->execute(['city' => $fields->city]);
	  return $statement;
  }
  
  function echo_json($statement){
	  $selected_city_restroom = $statement->fetchAll(PDO::FETCH_ASSOC);
	  $json_selected_city_restroom = json_encode($selected_city_restroom);
	  echo $json_selected_city_restroom;
  }
  
  try{
	  check_required_fields();
	  $fields = new fields();
	  $statement = execute_query($fields);
	  echo_json($statement);
  }
  catch(Exception $e){
	  echo 'Oops. Something went wrong. ' .$e->getMessage();
  }
?>