<?php
  function check_required_fields(){
	  if(!isset($_GET['number'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $number;
	  
	  function __construct (){
		  $this->number = $_GET['number'];
	  }
  }
  
  function execute_query($fields){
	  require "config_query.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		SELECT * FROM rating
		WHERE number = :number");
	  $statement->execute(['number' => $fields->number]);
	  return $statement;
  }
  
  function echo_json($statement){
	  $selected_number_rating = $statement->fetchAll(PDO::FETCH_ASSOC);
	  $json_selected_number_rating = json_encode($selected_number_rating);
	  echo $json_selected_number_rating;
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