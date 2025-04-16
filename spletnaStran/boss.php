<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$status = $_SESSION['status'];

if($status == 'W'){
	header("Location: worker.php");
}

$username = $_SESSION['username'];

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name_com FROM company WHERE boss_com = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($firm);
    
    $firms = [];
    
    while ($stmt->fetch()) {
        $firms[] = $firm;
    }

    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
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
    <title>Vodja</title>
</head>
<body>

<div class="container">



        <h1>Vodja (<?php echo htmlspecialchars($username); ?>)</h1>
  

<br><br>

	<?php 
        if (count($firms) > 0) {
	echo '<h2>Vaši oddelki:</h2>';
		}
	 ?>
  <div class="scrollable-timetable2">
    <?php 
        if (count($firms) > 0) {
            foreach ($firms as $firm) {	
                echo "<li class='firm-item'>";
				echo "<p class='firm-name'>" . strtoupper(htmlspecialchars($firm)) . "</p>";
                echo '<div class="button-group">';
                echo '<button class="details-btn" type="button" onclick="window.location.href=\'details-firm.php?firm=' . htmlspecialchars($firm) . '\';">Podrobnosti</button>';
                echo '   <a href="remove-firm.php?firm=' . htmlspecialchars($firm) . '" class="trash-icon" aria-label="Odstrani">';
                echo '       <i class="fas fa-trash"></i>'; 
                echo '   </a>';
                echo '</div>';
                echo "</li>";
            }
        } else {
            echo "<label class='no-firm'>Nimate še nobenega oddelka.</label>";
        }
    ?>
</div>

<div class="buttonplus">
  <button id="openModalBtn">+</button>
</div>

<br><br>
<button class="secondary-btn" onclick="location.href='logout.php';">Odjava</button>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModalBtn">&times;</span>
    <h2>Dodaj oddelek</h2>
    <form action="firm.php" method="POST">
        <label for="name">Ime oddelka:</label>
        <input type="text" id="name" name="name" required>
	

        <label for="Password">Geslo:</label>
        <input type="password" id="password" name="password" required><br><br>
     
        <label for="Description">Opis:</label> 
        <input type="text" id="description" name="description" required><br><br> 
		<label id="successMessage2" style="color: red;"></label>
        <button type="submit">Dodaj</button><br>
		
    </form>
  </div>
</div>

</div>

<script>
var modal = document.getElementById("myModal");
var openModalBtn = document.getElementById("openModalBtn");
var closeModalBtn = document.getElementById("closeModalBtn");

openModalBtn.onclick = function() {
    modal.style.display = "block";
}

closeModalBtn.onclick = function() {
	modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
		modal.style.display = "none";
    }
}

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const usernameCheck = urlParams.get('nameCheck');

   

    if (usernameCheck === 'true') {
		modal.style.display = "block";
        document.getElementById("successMessage2").innerText = "To ime že obstaja";
    }

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

    window.onload = function() {
        var timetableTable = document.querySelector('.scrollable-timetable');
        if (timetableTable) {
            timetableTable.scrollTop = timetableTable.scrollHeight;
        }
    }
</script>

</body>
</html>
