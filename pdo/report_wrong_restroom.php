<?php
  function check_required_fields(){
	  if(!isset($_GET['number']) || !isset($_GET['comment'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $number, $comment;
	  
	  function __construct (){
		  $this->number = $_GET['number'];
		  $this->comment = $_GET['comment'];
	  }
  }
  
  function check_if_number_in_count($fields, $pdo){
	  $statement = $pdo->prepare("
	    SELECT * FROM amount
		WHERE number = :number");
	  $statement->execute(['number' => $fields->number]);
	  if(0 == $statement->rowCount()){
		  return 0;
	  }
	  else{
		  return 1;
	  }
  }
  
  function execute_count_insert($fields, $pdo){
	  $statement = $pdo->prepare("
		INSERT INTO amount (number)
		VALUES(:number)");
	  $statement->execute(['number' => $fields->number]);
  }
  
  function execute_count_update($fields, $pdo){
	  $statement = $pdo->prepare("
		UPDATE amount
		SET count = count + 1
		WHERE number = :number");
	  $statement->execute(['number' => $fields->number]);
  }
  
  function execute_reported_insert($fields, $pdo){
	  $statement = $pdo->prepare("
		INSERT INTO reported_restroom (number, comment)
		VALUES(:number, :comment)");
	  $statement->execute(['number' => $fields->number, 'comment' => $fields->comment]);
  }
  
  function execute($fields){
	  require "config_insert_update.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  
	  if(check_if_number_in_count($fields, $pdo)){
		  execute_count_update($fields, $pdo);
	  }
	  else{
		  execute_count_insert($fields, $pdo);
	  }
	  execute_reported_insert($fields, $pdo);
  }
  
  try{
	  check_required_fields();
	  $fields = new fields();
	  execute($fields);
	  echo 'Insert succeeded. ';
  }
  catch(Exception $e){
	  echo 'Insert failed. ' .$e->getMessage();
  }
?>