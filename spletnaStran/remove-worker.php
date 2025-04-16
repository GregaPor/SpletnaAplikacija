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
$worker = $_GET['worker'];
$firm = $_SESSION['firm'];

$sql = "UPDATE user SET firm = null, count = 0 WHERE username ='$worker'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$currentDate = date('Y-m-d'); 

$sql2 = "DELETE FROM timetable WHERE username = ?";
if ($stmt2 = $conn->prepare($sql2)) {
    $stmt2->bind_param("s", $worker);
    $stmt2->execute();
    $stmt2->close();
}

$conn->close();

header("Location: details-firm.php?firm=" . urlencode($firm));

?>
