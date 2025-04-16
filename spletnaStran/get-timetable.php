<?php
session_start();
$username = $_SESSION['username'];

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT time, start, stop FROM timetable WHERE username = ?";
$timetable = [];
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($time, $start, $stop);
    while ($stmt->fetch()) {
        $formattedTime = date("d-m-Y", strtotime($time));

        $timetable[] = ['time' => $formattedTime, 'start' => $start, 'stop' => $stop];
    }
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();

echo json_encode($timetable);
?>
