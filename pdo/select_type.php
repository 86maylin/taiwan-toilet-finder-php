<?php
  function check_required_fields(){
	  if(!isset($_GET['type'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $type;
	  
	  function __construct (){
		  $this->type = $_GET['type'];
	  }
  }
  
  function execute_query($fields){
	  require "config_query.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		SELECT * FROM public_restroom
		WHERE type = :type");
	  $statement->execute(['type' => $fields->type]);
	  return $statement;
  }
  
  function echo_json($statement){
	  $selected_type_restroom = $statement->fetchAll(PDO::FETCH_ASSOC);
	  $json_selected_type_restroom = json_encode($selected_type_restroom);
	  echo $json_selected_type_restroom;
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