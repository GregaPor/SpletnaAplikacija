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
$start = $_POST['Od']; 
$stop = $_POST['Do'];
$id = $_POST['id'];
$worker = $_GET['worker']; 


$sql = "UPDATE timetable SET start = ?, stop = ? WHERE ID = ?";

if ($stmt = $conn->prepare($sql)) {

    $stmt->bind_param("sss", $start, $stop, $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) { 
        echo "Record updated successfully!";
    } else {
        echo "No record found or no changes made.";
    }

    $stmt->close();
} else {
    echo "Error preparing update query: " . $conn->error;
}

$conn->close();

header("Location: worker-details.php?worker=" . urlencode($worker));
exit();
?>
