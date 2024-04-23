<header>
    <div class="logo">
        <a href="index.php"><img class="logo-img" src="img/logoForza4.png" alt="Logo">
        <span class="mid-text">ForzI.A. 4</span></a>
    </div>

    <div class="icon-bar" id="icon-bar">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="menu" id="menu">
        <li><a href="index.php">Home</a></li>
        <?php
        if(isset($_SESSION["user"])){
            echo "<li><a href='login.php'>1vs1</a></li>";
            echo "<li><a href='forzIA4.php'>AI</a></li>";
            echo "<li><a href='profile.php' class='button'>Il mio account</a></li>";
        }
        else{
            echo "<li><a href='login.php' class='button'>Accedi</a></li>";
        }
            
        ?>
    </ul>
</header>