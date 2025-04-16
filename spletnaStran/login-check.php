<?php

session_start();

session_unset();
session_destroy();

session_start();

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job"; 

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, firm, username, password, status FROM user WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $firm, $name_db, $password_db, $status);

            $stmt->fetch();

            if (password_verify($password, $password_db)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $id;
				$_SESSION['firm'] = $firm;
				$_SESSION['status'] = $status;

                if ($status == 'W') {
                    header("Location: worker.php");
                    exit();
                } else {
                    header("Location: boss.php");
                    exit();
                }
            } else {
                header("Location: login.php?passwordCheck=true");
                exit();
            }
        } else {
            header("Location: login.php?usernameCheck=true");
            exit();
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>


