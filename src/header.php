<header>
        <img src="img/banner.jpg" alt="Bannière" id="banner">
        <div class="container flex">
            <img src="img/logo.png" alt="Logo Vibes" id="logo">
            <nav class="flex">
                <a href="#"><b>HOME</b></a>
                <a href="#"><b>ABOUT</b></a>
                <a href="#"><b>PORTFOLIO</b></a>
                <?php 

    if(!isset($_SESSION['user'])){
            echo "<h1><a href='index.php'>CONNECTEZ-VOUS</a> OU <a href='sign-in.php'>INSCRIVEZ-VOUS</a> ! </h1>";
    }
    else{
        echo "<a href='#'><b>".strtoupper($_SESSION['user']['username'])."<b></a>";
        echo "<a href='logout.php'><b>DECONNEXION</b></a>";

    }
    ?>
            </nav>
        </div>
    </header>