<?php
session_start();

if (isset($_SESSION['username'])) {

$username = $_SESSION['username'];

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT status FROM user WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->bind_result($status);
    $stmt->fetch();

    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

    if($status == 'W'){
    header("Location: worker.php");
	}else{
	header("Location: boss.php");	
	}
    exit();

$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <form action="login-check.php" method="POST">
        <h1>Prijava</h1>
        
        <label for="username">Uporabniško ime:</label>
        <input type="text" id="username" name="username" required>  
     
     

        <label for="password">Geslo:</label>
        <input type="password" id="password" name="password" required>  
		<br><br>
        <label id="successMessage" style="color: red;"></label>
		<label id="successMessage2" style="color: red;"></label>
        <button type="submit">Potrdi</button>
        
        <button type="button" class="secondary-btn" onclick="location.href='register.php';">Registracija</button>
    </form>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const passwordCheck = urlParams.get('passwordCheck');
        const usernameCheck = urlParams.get('usernameCheck');

        if (passwordCheck === 'true') {
            document.getElementById("successMessage").innerText = "Napačno geslo";
        }
        
        if (usernameCheck === 'true') {
            document.getElementById("successMessage2").innerText = "Uporabniško ime ne obstaja";
        }
    </script>
	
	<script>
        function preventBack() {
            window.history.forward();
        }

        window.onload = function() {
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1); 
            };
        };

        setInterval(function() {
            preventBack();
        }, 100);

</script>

</body>
</html>




