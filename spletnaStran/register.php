<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <form action="register-check.php" method="POST">
        <h1>Registracija</h1>

        <label for="name">Ime:</label>
        <input type="text" id="name" name="name" required>

        <label for="surname">Priimek:</label>
        <input type="text" id="surname" name="surname" required>
        
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="W">Delavec</option>
            <option value="B">Vodja</option>
        </select><br>
        
        <label for="username">Uporabniško ime:</label> 
        <input type="text" id="username" name="username" required>  
   
        
        <label for="password">Geslo:</label> 
        <input type="password" id="password" name="password" required><br><br>
		<label id="successMessage" style="color: green;"></label>
		<label id="successMessage2" style="color: red;"></label>
        <button type="submit">Potrdi</button>
     
        <button type="button" class="secondary-btn" onclick="location.href='login.php';">Nazaj na prijavo</button>
		
    </form>

  

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const usernameCheck = urlParams.get('usernameCheck');

        if (success === 'true') {
            document.getElementById("successMessage").innerText = "Uspešna registracija";
        }

        if (usernameCheck === 'true') {
            document.getElementById("successMessage2").innerText = "To uporabniško ime že obstaja";
        }
    </script>
</body>
</html>

