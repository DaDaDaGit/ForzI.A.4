<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Schermata di gioco 1v1</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="../css/timer.css">
        <link rel="stylesheet" type="text/css" href="../css/gioco.css">
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <!--includo font-->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    </head>
    <body onload="inizio()">
        <!--header incluso con php-->
        <?php 
            $IPATH = "../assets/php/";
            include($IPATH."header.php");
        ?>
        <!--assegno l'username dell'utente loggato a una variabile js-->
        <script>
            const nomePlayer1="<?php echo $_SESSION["user"]; ?>";
            const nomePlayer2="<?php echo $_SESSION["player2"]; ?>";
        </script>

        <div id="timer-container">          
            <div id="red-timer" class="timer">
                <div id="red-time">0:00</div>
                <div class="name" id="name-1"><?php echo $_SESSION["user"]; ?></div>
                <div id="red-bar"></div>
            </div>
        
            <div id="yellow-timer" class="timer">
                <div id="yellow-time">0:00</div>
                <div class="name" id="name-2"><?php echo $_SESSION["player2"]; ?></div>
                <div id="yellow-bar"></div>
            </div>    
        </div>

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

        <button id="reset" class="button">RESET</button>
        
        <!--includo con php la schermata di fine gioco-->
        <?php
        include($IPATH."endGame.html");
        ?>

    <script src="../js/loadGioco.js"></script>
    <script src="../js/gioco.js"></script>
    <script src="../js/checkWin.js"></script>
    <script src="../js/header.js"></script>
    </body>
</html>