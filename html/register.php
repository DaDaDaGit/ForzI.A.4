<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <!--includo font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <!--header incluso con php-->
    <?php 
        $IPATH = "../assets/php/";
        include($IPATH."header.php");
    ?>

    <main id="form-container" class="form-container">
        <h2 class="mid-text">Registrati</h2>
        <form action="validaRegister.php" method="POST" id="form">
            <label for="input-email">Email:</label>
            <input type="email" name="email" id="input-email" placeholder="esempio@gmail.com" required> 
            <p id="error-email" class="error-txt small-text"></p>
            <label for="input-user">Username:</label>
            <input type="text" name="user" id="input-user" placeholder="Username" required>
            <p id="error-user" class="error-txt small-text"></p>
            <label for="input-psw">Password:</label>
            <input type="password" name="psw" id="input-psw" placeholder="Password" required>
            <label for="input-confermaPsw">Conferma Password:</label>
            <input type="password" name="conferma-psw" id="input-confermaPsw" placeholder="Conferma Password" required>
            <p id="error-psw" class="error-txt small-text"></p>
            <button type="submit" id="btn-submit" class="button">Invia</button>
        </form>
        <?php
        //devo capire come gestire la stampa dell'errore
        if(isset($_SESSION["errReg"]))
        {
            echo "<p class='error-txt'>".$_SESSION["errReg"]."</p>";
        }
        ?>
        <p class="small-text">Hai già un accont? <a href="login.php">Accedi!</a></p>
        
    </main>

    <script src="../js/header.js"></script>
    <script src="../js/register.js"></script>
</body>
</html>
