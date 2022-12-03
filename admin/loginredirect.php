<?php 
require_once '../connection.php';

session_start();
if(isset($_SESSION['username']) && isset($_SESSION['id'])){
  $login_username = $_SESSION['username'];
  $login_id = $_SESSION['id'];
  $user_type = $_SESSION['user_type'];
  $login_state = $_SESSION['state'];
}else {
  header("Location: {$hostname}/login.php");
}

?>