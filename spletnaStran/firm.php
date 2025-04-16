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

$name = $_POST['name'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$description = $_POST['description'];
$username = $_SESSION['username'];

$sql = "SELECT COUNT(*) AS name_count FROM company WHERE name_com = '$name'";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    
    if ($row['name_count'] > 0) {
        header("Location: boss.php?nameCheck=true");
        exit();
    } else {
        $sql = "INSERT INTO company (name_com, boss_com, description_com, password) VALUES ('$name', '$username', '$description', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: boss.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
