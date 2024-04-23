<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="../css/homepage.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <!--includo font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <!--header incluso con php-->
    <?php 
        $IPATH = "../assets/php/";
        include($IPATH."header.php");
    ?>

    <section class="cards">
        <div class="card">
            <img class="card-img" src="img/forza4-game.jpg" alt="Tabellone Forza 4">            
            <div class="card-txt">
                <h3 class="normal-text">Guida al gioco</h3>
                <p>Forza 4 è un gioco da tavolo per 2 giocatori in cui a turno ogni giocatore mette nel tabellone
                    un gettone del proprio colore, che cade nella casella libera più in basso della colonna scelta.
                    <br><a class="readMore" id="readMore">leggi di più...</a>
                    <span id="more" class="">L'obiettivo del gioco è allineare 4 gettoni del proprio colore.
                    L'allineamento può essere orizzonatale, verticale o anche in diagonale. 
                    <br>In questo sito è possibile giocare a Forza 4 sia contro un'altra persona nella modalità "1vs1",
                     sia da soli sfidando un'intelligenza artificiale nella modalita "Sfida IA".
                    <br><a id="readLess" class="readMore">Nascondi</a></span>
                </p>
                <a href="https://it.wikipedia.org/wiki/Forza_quattro" class="button">Scopri di più</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img" src="img/forza4-IA.jpg" alt="Intelligenza Artificiale">
            <div class="card-txt">
                <h3 class="normal-text">Forza 4 - IA</h3>
                <p>Misurati conto un'intelligenza artificiale capace di calcolare la prossima mossa ottimale,
                    per divertirti e allo stesso tempo migliorarti!
                </p>        
                <button id="sfidaIA" class="button normal-text" <?php if(!isset($_SESSION["user"])){echo "disabled";}?> >Sfida IA</button>
                <?php if(!isset($_SESSION["user"])){
                    echo "<p class='small-text'>Per giocare è necessario il login</p>"; 
                }
                ?>
            </div>
        </div>
        <div class="card">
            <img class="card-img" src="img/forza4-1v1.jpg" alt="Gioca contro un avversario">
            <div class="card-txt">
                <h3 class="normal-text">Forza 4 - 1vs1</h3>
                <p>Sfida un avversario ad una partita a tempo limitato e determina chi dei due
                    è più forte!</p>        
                <button id="1vs1" class="button normal-text" <?php if(!isset($_SESSION["user"])){echo "disabled";} ?>>Gioca 1vs1</button>
                <?php if(!isset($_SESSION["user"])){
                    echo "<p class='small-text'>Entrambi i giocatori dovranno effettuare il login</p>"; 
                }
                else{
                    echo "<p class='small-text'>Il secondo giocatore dovrà effettuare il login</p>"; 
                }
                ?>
            </div>
        </div>
    </section>

    <script src="../js/home.js"></script>
    <script src="../js/header.js"></script>
</body>
</html>
