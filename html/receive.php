<?php
$json = file_get_contents("php://input");
$partita = json_decode($json, true); //mettendo true per avere un array associativo

$arrayMosseString = implode(",",$partita["moves"]); //porta l'array in una stringa (la ',' è il separatore)
//lunghezza massima della stringa: 83 (per creare la variabile in db) 

//salvo dati in DB
require_once("config.php");
$sql="INSERT INTO partita (firstPlayer, secondPlayer, arrayMosse, timestampPartita, risultato, redPlayer)
      VALUES (?,?,?,?,?,?)";
if($statement=mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($statement,'ssssss',$partita["firstPlayer"],$partita["secondPlayer"], 
                            $arrayMosseString, $partita["timeOfGame"],$partita["result"], $partita["redPlayer"]);

    mysqli_stmt_execute($statement);
}

//faccio poi 2 inserimenti nella tabella che mette in relazione account e partita
//prima mi recupero l'id della partita (@@IDENTITY prende l'ultimo indice inserito)
$result = mysqli_query($conn,"SELECT @@IDENTITY");
$idPartita = mysqli_fetch_array($result)[0]; //metto il risultato in un array e prendo il primo elemento

$sql="INSERT INTO partite_giocate VALUES (?,?)";
//inserisco prima un record con il primo giocatore e poi con il secondo
if($statement=mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($statement,'ss', $idPartita, $partita["firstPlayer"]);

    mysqli_stmt_execute($statement);
}
if($statement=mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($statement,'ss', $idPartita, $partita["secondPlayer"]);

    mysqli_stmt_execute($statement);
}
?>