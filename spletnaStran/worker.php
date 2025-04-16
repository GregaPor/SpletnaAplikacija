<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$status = $_SESSION['status'];

if ($status == 'B') {
    header("Location: boss.php");
    exit();
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

$sql = "SELECT firm, count FROM user WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($firm, $count);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}




$sql3 = "SELECT COUNT(DISTINCT time) FROM timetable WHERE username = ?";

if ($stmt = $conn->prepare($sql3)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($skupno);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaposlen</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">
	
    <?php if ($firm): ?>
 
		<div class="group7">
        <h1><?php echo strtoupper(htmlspecialchars($firm)); ?> (<?php echo htmlspecialchars($username); ?>)</h1>
		<a href="#" class="openModalBtn_2" aria-label="Zapusti">
		<i class="fas fa-sign-out-alt"></i>
		</a>
		</div>
			
		
		<br><br><br><br>
		<label><strong>Skupne ure:</strong>  <span id="total-value">/</span> </label>
		<label><strong>Nadure:</strong>  <span id="nadure">/</span> </label>

  


<?php else: ?>
	
        <h1>Nezaposlen (<?php echo htmlspecialchars($username); ?>)</h1>
		<br><br><br>
		<button id="openModalBtn2">Pridruži se oddelku</button>
    
<?php endif; ?>

   

   
<br><br>

    <?php if ($firm): ?>
		<h2 class='firm'>Časovnica:</h2>
		<label class='no-firm'>Ni podatkov o vaši časovnici.</label>
        <div class="scrollable-timetable">
            
            <table class="timetable-table">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Od</th>
                        <th>Do</th>
						<th>Razlika</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
		
        </div>
    <?php endif; ?>

    <br><br>

    <?php if ($firm): ?>
		<div class="buttons-container">
        <button id="add-time-button">Začetek</button>
        <button id="add-time-button-stop">Konec</button>
		</div>

    <?php endif; ?>

    <button class="secondary-btn" onclick="location.href='logout.php';">Odjava</button>
	
	<div id="myModal" class="modal">
  <div class="modal-content">
  
    <span class="close" id="closeModalBtn">&times;</span>
    <h2>Oddelek</h2>
    <form action="join-firm-check.php" method="POST">
        <label for="name">Ime oddelka:</label>
        <input type="text" id="name" name="name" required>
	

        <label for="Password">Geslo:</label>
        <input type="password" id="password" name="password" required><br><br>
     
        
		<label id="successMessage" style="color: red;"></label><label id="successMessage2" style="color: red;"></label>
        <button type="submit">Dodaj</button><br>
		
    </form>
  </div>
</div>

<div id="myModal_2" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModalBtn_2">&times;</span>
	<h2>Opomba</h2>
	<label>Ste prepričani, da želite zapustiti oddelek? Če ga zapustite, se bo izbrisala vaša časovnica.</label>
	<br>
	<button class="b-btn" onclick="location.href='worker.php';">Ostani</button>
    <form action="leave-firm.php" method="POST">
        
        <button class="a-btn" type="submit">Zapusti</button><br>
    </form>
		
  </div>
</div>


<script>
var modal = document.getElementById("myModal");
var openModalBtn = document.getElementById("openModalBtn2");
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
const passwordCheck = urlParams.get('passwordCheck');

if (passwordCheck === 'true') {
			modal.style.display = "block";
            document.getElementById("successMessage").innerText = "Napačno geslo";
        }
		
if (passwordCheck === 'false') {
			modal.style.display = "block";
            document.getElementById("successMessage2").innerText = "To ime ne obstaja";
        }
		


</script>

<script>


    var modal_2 = document.getElementById("myModal_2");
    var openModalBtn_2 = document.querySelector(".openModalBtn_2"); 
    var closeModalBtn_2 = document.getElementById("closeModalBtn_2");


    openModalBtn_2.onclick = function() {
        modal_2.style.display = "block";
    };

    closeModalBtn_2.onclick = function() {
        modal_2.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal_2) {
            modal_2.style.display = "none";
        }
    };

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

<script>
        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }


        function fetchTimetable() {
    fetch('get-timetable.php')
    .then(response => response.json())
    .then(data => {
        const timetableTableBody = document.querySelector('.timetable-table tbody');
        const timetableTable = document.querySelector('.scrollable-timetable');
        const noDataMessage = document.querySelector('.no-firm');
        const DataMessage = document.querySelector('.firm');
		const totalValueElement = document.getElementById("total-value");
		const nadureElement = document.getElementById("nadure");
		let skupno = 0;
		var skupno2 = <?php echo $skupno;?>;


        timetableTableBody.innerHTML = ''; 

        if (data.length === 0) {
            timetableTable.style.display = 'none';
            noDataMessage.style.display = 'block'; 
            DataMessage.style.display = 'none'; 
        } else {
            timetableTable.style.display = 'block'; 
            noDataMessage.style.display = 'none'; 
            DataMessage.style.display = 'block';

            data.forEach(entry => {
                const row = document.createElement('tr');
        
                let workingTime = '/';
                if (entry.start !== null && entry.stop !== null) {
     
                    const startTimeInSeconds = convertToSeconds(entry.start); 
                    const stopTimeInSeconds = convertToSeconds(entry.stop); 

                    const differenceInSeconds = stopTimeInSeconds - startTimeInSeconds;
					skupno = skupno + differenceInSeconds;

     
                    const workingMinutes = Math.round(differenceInSeconds / 60) % 60; 

                   const workingHours = Math.floor(differenceInSeconds / 3600); 
					
                    if(differenceInSeconds < 3600){
						if(differenceInSeconds < 0){
							workingTime = `/`;
						}else{
							workingTime = `${workingMinutes} min`; 
						}
				
					}else{
						workingTime = `${workingHours} h ${workingMinutes} min`; 
					}
                
                }

                row.innerHTML = `
                    <td>${entry.time === null ? '/' : entry.time}</td>
                    <td>${formatTimeToHoursMinutes(entry.start)}</td>
					<td>${formatTimeToHoursMinutes(entry.stop)}</td>
                    <td>${workingTime}</td>
                `;
                timetableTableBody.appendChild(row);
            });
			totalValueElement.innerHTML = Math.floor(skupno / 3600);
					if((totalValueElement.innerHTML - (skupno2*8)) > 0){
					nadureElement.innerHTML = totalValueElement.innerHTML - (skupno2*8);

					}
					else{
					nadureElement.innerHTML = 0;
					
					}

            timetableTable.scrollTop = timetableTable.scrollHeight;
        }
    })
    .catch(error => {
        console.error("Error fetching timetable:", error);
    });

	
}

function convertToSeconds(time) {
    const timeParts = time.split(':'); 
    const hours = parseInt(timeParts[0], 10);
    const minutes = parseInt(timeParts[1], 10);

    return hours * 3600 + minutes * 60;
}

        document.getElementById('add-time-button').addEventListener('click', function() {
            const currentTime = getCurrentTime();
            addTimeToDatabase(currentTime);
        });

        document.getElementById('add-time-button-stop').addEventListener('click', function() {
            const currentTime = getCurrentTime();
            addTimeToDatabaseStop(currentTime);
        });

        function addTimeToDatabase(time) {
            fetch('add-time.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ time: time })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Start time added to database:", data);
                fetchTimetable(); 
            })
            .catch(error => {
                console.error("Error adding time:", error);
            });
        }

        function addTimeToDatabaseStop(time) {
            fetch('add-time-Stop.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ time: time })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Stop time added to database:", data);
                fetchTimetable(); 
            })
            .catch(error => {
                console.error("Error adding stop time:", error);
            });
        }

        fetchTimetable();
		

function formatTimeToHoursMinutes(time) {
    if (time === null || time === undefined || time === '') return '/';

    const timeParts = time.split(':');

    if (timeParts.length === 3) {
        const hours = timeParts[0].padStart(2, '0');
        const minutes = timeParts[1].padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    return '/';
}	



</script>



<script>
var triggerAlertLink = document.getElementById("triggerAlert");


triggerAlertLink.onclick = function(event) {
  event.preventDefault(); 

  var userConfirmed = confirm("Ste prepričani, da želite zapustiti oddelek? Če ga zapustite, se bo izbrisala vaša časovnica.");

  if (userConfirmed) {
    window.location.href = "leave-firm.php";
  } else {
    return;
  }
}
</script>



</body>
</html>













