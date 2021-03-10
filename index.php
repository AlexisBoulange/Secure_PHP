<?php

require_once("MyError.php");
//session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie
session_start();

//On génère un token avec des octets pseudo-aléatoire cryptographiquement sécurisé
$_SESSION["token"] = bin2hex(random_bytes(24));

//On vérifie si il n'y a pas d'erreur avec "isset()"qui détermine si une variable est déclarée et est différente de null
if (!isset($_SESSION['error']))
$_SESSION['error'] = new MyError();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
			integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
			crossorigin="anonymous"
	/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lightbox.css">
    <title>Secure v2</title>
</head>
<body>

<?php include("src/header.php"); ?>

<p style="color:red">
        <?php
            if(isset($_GET['error'])){
                echo "<strong>".$_SESSION['error']."</strong>";
            }
        ?>
    </p>
    <?php
    if(!isset($_SESSION['user'])){
        include("src/form.php");
    }else{
        include("src/gallery.php");
    }
    ?>
    
    
    <?php include("src/footer.php"); ?>
    <script src="js/lightbox.js"></script>
</body>
</html>