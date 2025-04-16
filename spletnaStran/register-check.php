<?php

$servername = "localhost:3306";
$username = "root";  
$password = "";    
$dbname = "job";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$status = $_POST['status'];
$username = $_POST['username'];

$sql = "SELECT COUNT(*) AS username_count FROM user WHERE username = '$username'";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    
    if ($row['username_count'] > 0) {
        header("Location: register.php?usernameCheck=true");
        exit();
    } else {
        $sql = "INSERT INTO user (name, surname, password, status, username) VALUES ('$name', '$surname', '$hashed_password', '$status', '$username')";
        if ($conn->query($sql) === TRUE) {
            header("Location: register.php?success=true");
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

