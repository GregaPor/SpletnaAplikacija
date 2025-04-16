<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}




$servername = "localhost:3306";
$username = "root";  
$password = "";    
$dbname = "job";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$username = $_SESSION['username']; 
$firm = $_GET['firm'];



$sql = "DELETE FROM company WHERE name_com ='$firm'";
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->close();

$sql = "UPDATE user SET firm = null WHERE firm ='$firm'";
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->close();

$sql = "DELETE FROM timetable WHERE firm ='$firm'";
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->close();



header("Location: boss.php");

$conn->close();
?>
