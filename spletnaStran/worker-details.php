<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$firm = $_SESSION['firm'];
$worker = $_GET['worker'];

$servername = "localhost:3306";
$dbusername = "root";
$password = "";
$dbname = "job";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT id, time, start, stop FROM timetable WHERE username = ? AND firm = ?";
if ($stmt1 = $conn->prepare($sql1)) {
   
    $stmt1->bind_param("ss", $worker, $firm);
    $stmt1->execute();
    $stmt1->bind_result($id, $time, $start, $stop); 
    
    $timetable = []; 
    while ($stmt1->fetch()) {
        $timetable[] = [
			'id' => $id,
            'time' => $time,
            'start' => $start,
            'stop' => $stop
        ];
    }
    $stmt1->close();
} else {
    echo "Error preparing first query: " . $conn->error;
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
    <title>Zaposlen</title>
</head>
<body>

<div class="container">

<div class="group6">
		<a href="details-firm.php?firm=<?php echo htmlspecialchars($firm, ENT_QUOTES, 'UTF-8'); ?>" class="back-icon" aria-label="Nazaj">
		<i class="fas fa-arrow-left"></i> 
		</a>
        <h1>Zaposlen (<?php echo htmlspecialchars($worker); ?>)</h1>
    </div>





<br><br>

<?php if (empty($timetable)): ?>
    <label class="no-firm">Ni podatkov o vašem delavcu.</label>
<?php else: ?>
    <h2>Časovnica:</h2>
    <div class="scrollable-timetable3">
        <table class="timetable-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Od</th>
                    <th>Do</th>
                    <th>Razlika</th>
					<th>Spremeni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timetable as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(!empty($entry['time']) ? (new DateTime($entry['time']))->format('d-m-Y') : '/'); ?></td>
                        <td><?php echo htmlspecialchars(!empty($entry['start']) ? substr($entry['start'], 0, 5) : '/'); ?></td>
                        <td><?php echo htmlspecialchars(!empty($entry['stop']) ? substr($entry['stop'], 0, 5) : '/'); ?></td>
					

                        <td>
                            <?php 
							if (!empty($entry['start']) && !empty($entry['stop'])) {
							$start = new DateTime($entry['start']);
							$stop = new DateTime($entry['stop']);

							$interval = $start->diff($stop);

							if ($interval->invert == 1) {
  
								echo '/';
							} else {
  
							if ($interval->h > 0) {

								echo $interval->h . " h " . $interval->i . " m";
							} else {
 
								echo $interval->i . " m";
							}
						}
						} else {
							echo '/';
						}
?>
                        </td>
						<td>
    <a href="#" class="openModalBtn pen-icon" data-id="<?php echo htmlspecialchars(!empty($entry['id']) ? $entry['id'] : '/'); ?>" aria-label="Odpusti">
        <i class="fas fa-pen"></i>
    </a>
</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>


<br><br>
<button class="secondary-btn" onclick="location.href='logout.php';">Odjava</button>

</div>


<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModalBtn">&times;</span>
    <h2>Spremeni čas</h2>
    <form action="edit-timetable.php?worker=<?php echo urlencode($worker); ?>" method="POST">
        <label for="Od">Od:</label>
        <input type="text" id="Od" name="Od" placeholder="HH:MM" required pattern="([01]?[0-9]|2[0-3]):([0-5]?[0-9])" maxlength="5">
    
        <label for="Do">Do:</label>
        <input type="text" id="Do" name="Do" placeholder="HH:MM" required pattern="([01]?[0-9]|2[0-3]):([0-5]?[0-9])" maxlength="5">
    
        <input type="hidden" id="id" name="id" value="">

        <button type="submit">Potrdi</button><br><br>
    </form>
  </div>
</div>


<script>
    window.onload = function() {
        var timetableTable = document.querySelector('.scrollable-timetable3');
        if (timetableTable) {
            timetableTable.scrollTop = timetableTable.scrollHeight;
        }
    }
</script>

<script>
var modal = document.getElementById("myModal");
var closeModalBtn = document.getElementById("closeModalBtn");
var openModalBtns = document.querySelectorAll(".openModalBtn");

openModalBtns.forEach(function(btn) {
    btn.addEventListener("click", function(event) {
        event.preventDefault(); 
        var id = this.getAttribute('data-id'); 
        document.getElementById("id").value = id; 

        modal.style.display = "block"; 
    });
});

closeModalBtn.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}





</script>

</body>
</html>

