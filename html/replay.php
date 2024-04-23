<?php
require_once("config.php");
//viene selezionata la partita
$sql = "SELECT *
        FROM partita
        WHERE ID_partita=".$_GET["idPartita"]."";
if($result = mysqli_query($conn,$sql)){
    $dati=mysqli_fetch_assoc($result);
    $json=json_encode($dati);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="data" content='<?php echo $json ?>'>
    <title>Replay partita</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/replay.css">
    <!--includo font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet"> 
</head>
<body onload="inizio()">
    <!--Includo header con php-->
    <?php
        $IPATH = "../assets/php/";
        include($IPATH."header.php");
    ?>
    <h1 class="title"><em id="nomeP1"></em> contro <em id="nomeP2"></em></h1>

    <div class="game">
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
                <div class="grid-row">
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                    <div class="grid-elem"></div>
                </div>
            </div>
        </div>

        <div class="inputs">
            <button id="oldMove" class="button">&#10140;</button>
            <button id="nextMove" class="button" disabled>&#10140;</button>
        </div>

<script src="../js/replay.js"></script>
<script src="../js/header.js"></script>
</body>
</html>