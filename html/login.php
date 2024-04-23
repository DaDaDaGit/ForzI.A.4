<?php
session_start();
$user="";
$player2="";
$loginFallito=false;
//validiamo l'input prima di salvarlo in database
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["user"]=="" || $_POST["psw"]==""){
        echo "<p class='error-txt'>Riempire tutti i campi</p>";
        die("Tutti i campi necessari");
    }   
    
    //valido user
    if(!preg_match('/^[a-zA-Z0-9_]{1,25}$/',$_POST["user"])){
        die("Username non valido");
    }

    //controlliamo che username e password inseriti siano presenti nel database
    $pswHash="";
    require("config.php");
    $sql = "SELECT username, password_hash FROM account WHERE username=?";
    if($statement=mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($statement,'s',$_POST["user"]);
        mysqli_stmt_execute($statement);
        //prendo il risultato dalla query e lo metto in user
        if(!isset($_SESSION["user"])){
            mysqli_stmt_bind_result($statement,$user,$pswHash);
        }
        else{
            //in questo modo se mi trovo nel login del secondo giocatore per la modalità 1v1 
            //setterò la nuova variabile 
            mysqli_stmt_bind_result($statement,$player2,$pswHash);
        }
        mysqli_stmt_fetch($statement);
        mysqli_stmt_free_result($statement);
    }
    //se nel database abbiamo preso l'utente controlliamo che la password corrisponda
    if($user!=""){
        if(password_verify($_POST["psw"],$pswHash)){
            //login dell'utente (porta alla pagina iniziale)
            $_SESSION["user"]=$user;
            header("Location: index.php");
            exit;
        }
    }
    if($player2!=""){
        if(password_verify($_POST["psw"],$pswHash)){
            //login dell'utente (porta alla pagina iniziale)
            $_SESSION["player2"]=$player2;
            header("Location: forza4-1v1.php");
            exit;
        }
    }
    //se arrivo qui vuol dire che almeno un controllo è fallito
    $loginFallito=true;
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Login</title>
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
        <?php 
        if(!isset($_SESSION["user"])){
            echo "<h2 class='mid-text'>Accedi al tuo account</h2>";
        }
        else{
            echo "<h2 class='mid-text'>Login secondo giocatore</h2>";
        }
        ?>
        
        <form action="login.php" method="POST" id="form">
            <label for="input-user">Username:</label>
            <input type="text" name="user" id="input-user" placeholder="Username" required>
            <p id="error-user" class="error-txt small-text"></p>
            <label for="input-psw">Password:</label>
            <input type="password" name="psw" id="input-psw" placeholder="Password" required>
            <p id="error-psw" class="error-txt small-text"></p>
            <button type="submit" id="btn-submit" class="button">Invia</button>
        </form>
        <?php
            if($loginFallito){
                echo "<p class='error-txt'>Username o password errati</p>";
            }
        ?>
        <p class="small-text">Non hai un accont? <a href="register.php">Registrati</a></p>
    </main>

    <script src="../js/header.js"></script>
    <script src="../js/login.js"></script>
</body>
</html>
