<?php

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$username = $_SESSION['username']; 

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method. Only POST requests are allowed."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['time'])) {
    echo json_encode(["status" => "error", "message" => "'time' parameter is required."]);
    exit();
}

$stopTime = $data['time'];
$currentDate = date('Y-m-d');

$sql = "UPDATE timetable SET stop = ? WHERE username = ? AND time = ? AND stop IS NULL";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Failed to prepare the update query."]);
    exit();
}

$stmt->bind_param("sss", $stopTime, $username, $currentDate);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Stop time added successfully."]);
} else {

    $insertSql = "UPDATE timetable SET stop = '00:00' WHERE username = ? AND stop IS NULL";
    $insertStmt = $conn->prepare($insertSql);

    if (!$insertStmt) {
        echo json_encode(["status" => "error", "message" => "Failed to prepare the insert query."]);
        exit();
    }

    $insertStmt->bind_param("s", $username);
    if ($insertStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Stop time '00:00' added because no matching time was found."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to insert the stop time."]);
    }
    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>

