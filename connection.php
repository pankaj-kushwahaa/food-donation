<?php
/* <-------- Procedural Oriented ----------> */
// $dsn = "mysql:host=localhost;dbname=donation";
// $db_user = "root";
// $db_password = "";
// $conn = "";

// // Create Connection
// try{
//   $conn = new PDO($dsn, $db_user, $db_password);
//   $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
//   //PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, 
//  echo "Connected";
// } catch(PDOException $e){
//   echo "Connection Failed".$e->getMessage();
// }


$hostname = 'http://localhost/food';
$emailUsername = 'ramdhani2233ramdhani@gmail.com'; // Your email id
$emailPassword = 'zyaaqbpotprjwlct'; // Your email id password
$emailName = 'Food Donation';
$websiteName = 'Food Donation';

// Global Variables 
define( "DB_HOST", "mysql:host=localhost;dbname=donation" );
define( "DB_USERNAME", "root");
define( "DB_PASSWORD", "");

// SQL Queries
class Database {
  public static function connect(){
    // echo "<br><br>inside connect method<br>";
    // Create Connection
    try{
      $conn = new PDO(DB_HOST, DB_USERNAME, DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      //PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
      // echo "Connected";
      return $conn;
      } catch(PDOException $e){
        echo "Connection Failed".$e->getMessage();
      }

    }

  public function query($sql, $values){
    $conn = $this->connect();
    $result = $conn->prepare($sql);
    $result->execute($values);
    // echo "<br><br>rowCount() = ";
    // echo $result->rowCount();
    // echo "<br><br>";
    if($result->rowCount()){
      $row = $result->fetchAll(PDO::FETCH_ASSOC);
    }else {
      $row = false;
    }
    return $row;
  }

  public function insert($sql, $values){
    $conn = $this->connect();
    $result = $conn->prepare($sql);
    $row = $result->execute($values);
    if($row){
    // echo "<br><br>rowCount() = ";
    // echo $result->rowCount();
    // echo "<br><br>";
      return $row;
    }else {
      $row = false;
    }
    return $row;
  }
}

$conn = Database::connect();
$db = new Database();


?>