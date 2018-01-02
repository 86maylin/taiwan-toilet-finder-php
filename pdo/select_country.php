<?php
  function check_required_fields(){
	  if(!isset($_GET['country'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $country;
	  
	  function __construct (){
		  $this->country = $_GET['country'];
	  }
  }
  
  function execute_query($fields){
	  require "config_query.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		SELECT * FROM public_restroom
		WHERE country = :country");
	  $statement->execute(['country' => $fields->country]);
	  return $statement;
  }
  
  function echo_json($statement){
	  $selected_country_restroom = $statement->fetchAll(PDO::FETCH_ASSOC);
	  $json_selected_country_restroom = json_encode($selected_country_restroom);
	  echo $json_selected_country_restroom;
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