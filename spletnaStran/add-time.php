<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$firm = $_SESSION['firm'];

$conn = new mysqli("localhost:3306", "root", "", "job");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method. Only POST allowed."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['time'])) {
    echo json_encode(["status" => "error", "message" => "'time' parameter is required."]);
    exit();
}

$startTime = $data['time'];
$currentDate = date('Y-m-d');

$sqlSelect = "SELECT * FROM timetable WHERE username = ? AND stop IS NULL";
$stmt = $conn->prepare($sqlSelect);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "An active timetable entry already exists."]);
    $stmt->close();
    exit();
}

$sqlInsert = "INSERT INTO timetable (username, firm, time, start) VALUES (?, ?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("ssss", $username, $firm, $currentDate, $startTime);
if ($stmtInsert->execute()) {
    echo json_encode(["status" => "success", "message" => "Start time added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add start time."]);
}

$stmtInsert->close();
$conn->close();
?>




