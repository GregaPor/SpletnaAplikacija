<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost:3306";
$dbusername = "root";  
$password = "";    
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username']; 

$sql = "UPDATE user SET firm = NULL WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error preparing user update query: " . $conn->error;
}

$currentDate = date('Y-m-d');

$sql2 = "DELETE FROM timetable WHERE username = ?";
if ($stmt2 = $conn->prepare($sql2)) {
    $stmt2->bind_param("s", $username);
    $stmt2->execute();
    $stmt2->close();
} else {
    echo "Error preparing timetable delete query: " . $conn->error;
}

$conn->close();

header("Location: worker.php");
exit();
?>


