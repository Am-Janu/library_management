<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "library_management";

$conn = mysqli_connect($servername , $username , $password , $db_name);

if(!$conn)
{
    die("error : " . mysqli_connect_error());
}

if(!isset($_SESSION['userid']) && !$guestpage){
  header("Location: /library_management/login.php");
  exit;
    //echo "no session";
}
?>