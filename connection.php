<?php

// $dsn = "mysql:host=localhost;dbname=id18929726_approval";
// $db_user = "id18929726_pankaj";
// $db_password = "NMJAw3-QZmt^l&Qx";

$dsn = "mysql:host=localhost;dbname=approval2";
$db_user = "root";
$db_password = "";


// Create Connection
try{
  $conn = new PDO($dsn, $db_user, $db_password);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
  //PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, 
 // echo "Connected";
} catch(PDOException $e){
  echo "Connection Failed".$e->getMessage();
}


// $hostname = 'https://associated-tape.000webhostapp.com';
$hostname = 'http://localhost/food';

$emailUsername = 'ramdhani2233ramdhani@gmail.com';
$emailPassword = 'xrcgbbkhebxvbyfp';
$emailName = 'Pankaj';
$websiteName = 'Food Donation';

?>