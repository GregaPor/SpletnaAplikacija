<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$firm = $_GET['firm'];
$_SESSION['firm'] = $firm;

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT name, surname, username FROM user WHERE firm = ? ORDER BY 1";
if ($stmt1 = $conn->prepare($sql1)) {
    $stmt1->bind_param("s", $firm);
    $stmt1->execute();
    $stmt1->bind_result($name, $surname, $username);
    
    $workers = [];
    while ($stmt1->fetch()) {
        $workers[] = [
            'name' => $name,
            'surname' => $surname,
            'username' => $username,
        ];
    }
    $stmt1->close();
} else {
    echo "Error preparing first query: " . $conn->error;
}

$sql2 = "SELECT description_com FROM company WHERE name_com = ?";
if ($stmt2 = $conn->prepare($sql2)) {
    $stmt2->bind_param("s", $firm);
    $stmt2->execute();
    $stmt2->bind_result($description);
    $stmt2->fetch();
    $stmt2->close();
} else {
    echo "Error preparing second query: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style2.css">

<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oddelek</title>
</head>
<body>

<div class="container">

<div class="group6">
		<a href="boss.php" class="back-icon" aria-label="Nazaj">
		<i class="fas fa-arrow-left"></i> 
		</a>
        <h1><?php echo strtoupper(htmlspecialchars($firm)); ?></h1>
    </div>


<br><br>
<label><strong>Opis oddelka:</strong>
  <?php
    $maxLength = 40;
    if (strlen($description) > $maxLength) {
        echo htmlspecialchars(substr($description, 0, $maxLength)) . '...';
    } else {
        echo htmlspecialchars($description);
    }
  ?>
</label>

<br><br>

 <?php 
        if (count($workers) > 0) {
			echo '<h2>Zaposleni:</h2>';
		}
 ?>

<div class="scrollable-timetable4">
    <?php 
        if (count($workers) > 0) {
            foreach ($workers as $worker) {
                echo "<li class='firm-item'>";
                echo "<p class='worker-name'>" . htmlspecialchars($worker['name']) . " " . htmlspecialchars($worker['surname']) . " (" . htmlspecialchars($worker['username']) . ")</p>";
                echo '<div class="button-group2">';
                echo '   <a href="worker-details.php?worker=' . htmlspecialchars($worker['username']) . '" class="clock-icon" aria-label="Podrobnosti">';
				echo '       <i class="fas fa-clock"></i>';  
				echo '   </a>';
                echo '   <a href="remove-worker.php?worker=' . htmlspecialchars($worker['username']) . '" class="trash-icon" aria-label="Odpusti">';
                echo '       <i class="fas fa-trash"></i>'; 
                echo '   </a>';
                echo '</div>';
                echo "</li>";
            }
        } else {
             echo "<label class='no-firm'>Nikogar še nimate zaposlenega.</label>";
        }
    ?>
</div>

<br><br>
<button class="secondary-btn" onclick="location.href='logout.php';">Odjava</button>

</div>

<script>
    setTimeout(function() {
        location.reload();
    }, 30000);
	
	

    window.onload = function() {
        var timetableTable = document.querySelector('.scrollable-timetable');
        if (timetableTable) {
            timetableTable.scrollTop = timetableTable.scrollHeight;
        }
    }
</script>

</body>
</html>

