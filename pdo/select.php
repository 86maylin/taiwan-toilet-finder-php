<?php
  
  function execute_query(){
	  require "config_query.php";
	  $pdo = new PDO($dsn, $user, $pass);
	  $statement = $pdo->prepare("
		SELECT * FROM public_restroom 
		WHERE country = '臺北市'
		ORDER BY RAND() LIMIT 50");
	  $statement->execute();
	  return $statement;
  }
  
  function echo_json($statement){
	  $rand50_taipei_restroom = $statement->fetchAll(PDO::FETCH_ASSOC);
	  $json_rand50_taipei_restroom = json_encode($rand50_taipei_restroom);
	  echo $json_rand50_taipei_restroom;
  }
  
  try{
	  $statement = execute_query();
	  echo_json($statement);
  }
  catch(Exception $e){
	  echo 'Oops. Something went wrong. ';
  }
?>