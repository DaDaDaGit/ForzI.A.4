<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["email"]=="" || $_POST["user"]=="" || $_POST["psw"]==""){
        die("Tutti i campi sono richiesti!");
    }
    //valido email
    //regExp preso da https://www.w3resource.com/javascript/form/email-validation.php     
    if(!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$_POST["email"])){
        die("Email non valida");
    }
    //valido password (almeno 6 caratteri)
    if(strlen($_POST["psw"])<6){
        die("Password con almeno 6 caratteri");
    }
    if($_POST["psw"]!=$_POST["conferma-psw"]){
        die("Le password non corrispondono");
    }
    //hashing della password
    $pswHash=password_hash($_POST["psw"],PASSWORD_DEFAULT);
    
    //valido user
    if(!preg_match('/^[a-zA-Z0-9_]{1,25}$/',$_POST["user"])){
        die("Username non valido");
    }

    require("config.php");
    //controlliamo che non ci sia già un account con stesso user o stessa email
    $sql = "SELECT COUNT(*) FROM account WHERE username=? OR email=?";
    if($statement=mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($statement,'ss',$_POST["user"],$_POST["email"]);

        mysqli_stmt_execute($statement);
        //prendo i risultati della query
        mysqli_stmt_bind_result($statement,$conta);
        mysqli_stmt_fetch($statement);
        if($conta>0){
            session_start();
            $_SESSION["errReg"]="Username o email già in uso";
            header("Location: register.php");
            exit;
        }
        mysqli_stmt_free_result($statement);
    }
    //se non ci sono utenti con stessa mail o stessa password inserisco
    $sql = "INSERT INTO account (username,email,password_hash) VALUES (?,?,?)";
    if($statement=mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($statement,'sss',$_POST["user"],$_POST["email"], $pswHash);

        mysqli_stmt_execute($statement);
    }
    header("Location: login.php");
    exit;
}
?>