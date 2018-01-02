<?php
  function check_required_fields(){
	  if(!isset($_GET['number']) || !isset($_GET['stars']) || !isset($_GET['comment'])){
		throw new Exception("Missing required fields. ");
	  }
  }
  
  class fields{
	  public $number, $stars, $comment;
	  
	  function __construct (){
		  $this->number = $_GET['number'];
		  $this->stars = $_GET['stars'];
		  $this->comment = $_GET['comment'];
	  }
  }
  
  function execute_insert($fields){
	  require "config_insert.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		INSERT INTO rating (number, stars, comment)
		VALUES(:number, :stars, :comment)");
	  $statement->execute(['number' => $fields->number, 'stars' => $fields->stars, 'comment' => $fields->comment]);
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