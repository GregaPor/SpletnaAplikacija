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

$firm_name = $_POST['name'];
$password = $_POST['password'];
$username = $_SESSION['username'];
$_SESSION['firm'] = $_POST['name'];




$check_firm_sql = "SELECT * FROM company WHERE name_com = ?";
if ($stmt = $conn->prepare($check_firm_sql)) {
    $stmt->bind_param("s", $firm_name);
    $stmt->execute();

    $stmt->store_result(); 
    if ($stmt->num_rows > 0) {
    } else {

        header("Location: worker.php?passwordCheck=false");
		$conn->close();
		exit();
		
    }

    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}	
	



$sql = "SELECT password FROM company WHERE name_com = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $firm_name);
    $stmt->execute();

    $stmt->bind_result($firm_password);
    $stmt->fetch();
    $stmt->close();

    if ($firm_password && password_verify($password, $firm_password)) {
        $update_sql = "UPDATE user SET firm = ? WHERE username = ?";
        if ($update_stmt = $conn->prepare($update_sql)) {
            $update_stmt->bind_param("ss", $firm_name, $username);
            if ($update_stmt->execute()) {
                header("Location: worker.php");
                exit();
            } else {
                echo "Error updating firm: " . $conn->error;
            }
            $update_stmt->close();
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }
    } else {
        header("Location: worker.php?passwordCheck=true");
        exit();
    }
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();
?>



