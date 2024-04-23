<?php
//Visto che qui sono loggato posso usare la variabile di sessione direttamente
//per cercare le cose nel db visto che mi posso fidare
require_once("config.php");
//vittorie contro IA
$sql = "SELECT COUNT(*) AS WinVsAI
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='AI' OR P.secondPlayer='AI')
            AND P.risultato='".$_SESSION["user"]."'";
$result = mysqli_query($conn,$sql);
$vittorieVsAI = mysqli_fetch_assoc($result)["WinVsAI"];
//sconfitte contro IA
$sql = "SELECT COUNT(*) AS LostVsAI
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='AI' OR P.secondPlayer='AI')
            AND P.risultato='AI'";
$result = mysqli_query($conn,$sql);
$sconfitteVsAI = mysqli_fetch_assoc($result)["LostVsAI"];
//pareggi contro IA
$sql = "SELECT COUNT(*) AS PareggiVsAI
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='AI' OR P.secondPlayer='AI')
            AND P.risultato='Pareggio'";
$result = mysqli_query($conn,$sql);
$pareggiVsAI = mysqli_fetch_assoc($result)["PareggiVsAI"];
$totAI=$vittorieVsAI+$sconfitteVsAI+$pareggiVsAI;

//vittorie contro players
$sql = "SELECT COUNT(*) AS WinByUser
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer!='AI' AND P.secondPlayer!='AI')
            AND P.risultato='".$_SESSION["user"]."'";
$result = mysqli_query($conn,$sql);
$vittorie1v1 = mysqli_fetch_assoc($result)["WinByUser"];
//sconfitte contro players
$sql = "SELECT COUNT(*) AS LostByUser
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer!='AI' AND P.secondPlayer!='AI')
            AND P.risultato!='".$_SESSION["user"]."' 
            AND P.risultato!='Pareggio'";
$result = mysqli_query($conn,$sql);
$sconfitte1v1 = mysqli_fetch_assoc($result)["LostByUser"];
//pareggi contro players
$sql = "SELECT COUNT(*) AS PareggiUser
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer!='AI' AND P.secondPlayer!='AI')
            AND P.risultato='Pareggio'"; 
$result = mysqli_query($conn,$sql);
$pareggi1v1 = mysqli_fetch_assoc($result)["PareggiUser"];
$tot1v1=$vittorie1v1+$sconfitte1v1+$pareggi1v1;

//player contro cui ho giocato più partite
$sql="SELECT D2.user2 AS avversario, COUNT(D2.user2) AS numMatch
        FROM (SELECT A.username, PG.ID_partita, PG.username AS user2
              FROM account A LEFT OUTER JOIN partite_giocate PG ON PG.username=A.username
              LEFT OUTER JOIN partita P ON P.ID_partita=PG.ID_partita
              WHERE A.username!='AI') AS D1 LEFT OUTER JOIN
                (SELECT A.username, PG.ID_partita, PG.username AS user2
                 FROM account A LEFT OUTER JOIN partite_giocate PG ON PG.username=A.username
                 LEFT OUTER JOIN partita P ON P.ID_partita=PG.ID_partita
                 WHERE A.username!='AI') AS D2
                ON D1.username!=D2.user2 AND D1.ID_partita=D2.ID_partita
        WHERE D1.username='".$_SESSION["user"]."'
        GROUP BY D2.user2
        ORDER BY NumMatch DESC
        LIMIT 1";
$result = mysqli_query($conn,$sql);
$datiAvversario = mysqli_fetch_assoc($result);
$totAvv = $datiAvversario["numMatch"];
$avversario= $datiAvversario["avversario"];
//vittorie contro avversario preferito
$sql = "SELECT COUNT(*) AS WinVsAvv
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='".$avversario."' OR P.secondPlayer='".$avversario."')
            AND P.risultato='".$_SESSION["user"]."'";
$result = mysqli_query($conn,$sql);
$vittorieVsAvv = mysqli_fetch_assoc($result)["WinVsAvv"];
//sconfitte contro avversario preferito
$sql = "SELECT COUNT(*) AS LostVsAvv
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='".$avversario."' OR P.secondPlayer='".$avversario."')
            AND P.risultato='".$avversario."'";
$result = mysqli_query($conn,$sql);
$sconfitteVsAvv = mysqli_fetch_assoc($result)["LostVsAvv"];
//pareggi contro avversario preferito
$sql = "SELECT COUNT(*) AS PareggiVsAvv
        FROM account A INNER JOIN partite_giocate PG ON PG.username=A.username
            INNER JOIN partita P ON P.ID_partita=PG.ID_partita
        WHERE A.username='".$_SESSION["user"]."' 
            AND (P.firstPlayer='".$avversario."' OR P.secondPlayer='".$avversario."')
            AND P.risultato='Pareggio'";
$result = mysqli_query($conn,$sql);
$pareggiVsAvv = mysqli_fetch_assoc($result)["PareggiVsAvv"];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
    <!--includo font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <title>Il mio account</title>
</head>
<body>
    <!--Includo header con php-->
    <?php
        $IPATH = "../assets/php/";
        include($IPATH."header.php");
    ?>
    <section class="title">
        <h1 class="big-text">Ciao <?php echo $_SESSION["user"];?></h1>
        <a class="button" href="logout.php">Log out</a>
    </section>
    <section class="stats cards">
        <h2 class="mid-text">Le tue statistiche:</h2>
        <div class="card" id="stats-ia">
            <h3 class="normal-text">Sfide IA:</h3>
            <p class="win">Vittorie: <?php echo $vittorieVsAI; ?></p>
            <p>Pareggi: <?php echo $pareggiVsAI; ?></p>
            <p class="lost">Sconfitte: <?php echo $sconfitteVsAI; ?></p>
            <p>Totale sfide AI: <?php echo $totAI; ?></p>
        </div>
        <div class="card" id="stats-1v1">
            <h3 class="normal-text">Sfide 1vs1:</h3>
            <p class="win">Vittorie: <?php echo $vittorie1v1; ?></p>
            <p>Pareggi: <?php echo $pareggi1v1; ?></p>
            <p class="lost">Sconfitte: <?php echo $sconfitte1v1;?></p>
            <p>Totale Partite 1vs1: <?php echo $tot1v1; ?></p>
        </div>
        <div class="card" id="stats-nemesi">
            <h3 class="normal-text">Avversario preferito: <?php echo $avversario; ?></h3>
            <p class="win">Vittorie: <?php echo $vittorieVsAvv; ?></p>
            <p>Pareggi: <?php echo $pareggiVsAvv; ?></p>
            <p class="lost">Sconfitte: <?php echo $sconfitteVsAvv; ?></p>
            <p>Partite contro <?php echo $avversario.": ".$totAvv; ?></p>
        </div>
    </section>

    <!--Elenco delle partite giocate da poter rivedere-->
    <section id="elencoPartite">
        <h2 class="mid-text">Elenco partite giocate:</h2>
        <?php
        $sql = "SELECT *
                FROM partita
                WHERE firstPlayer='".$_SESSION["user"]."' OR secondPlayer='".$_SESSION["user"]."'";
        if($result = mysqli_query($conn,$sql)){
            //creo la tabella se ci sono partite giocate
            echo "<table id='table-matches'>
                    <tr>
                        <th>Timestamp</th>
                        <th>Player 1</th>
                        <th>Player 2</th>
                        <th>Vincitore</th>
                        <th>Replay</th>
                    </tr>";
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>".$row["timestampPartita"]."</td>
                        <td>".$row["firstPlayer"]."</td>
                        <td>".$row["secondPlayer"]."</td>
                        <td>".$row["risultato"]."</td>
                        <td>
                            <button class='button' onclick='redirect(".$row["ID_partita"].")'>Replay Partita</button>
                        </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </section>

    <script src="../js/header.js"></script>
    <script src="../js/profile.js"></script>
</body>
</html>