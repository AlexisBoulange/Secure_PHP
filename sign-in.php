<?php

require_once("MyError.php");
//session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Inscription</title>
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
    

    <form action="add-user.php" method="post">
    <p><input type="text" placeholder="Votre login" name="username" required></p>

    <p><input type="password" placeholder="Votre mot de passe" name="password" required></p>

    <p><input type="password" placeholder="Confirmez votre mot de passe" name="verifpassword" required></p>

    <p><input type="hidden"  name="token" value="<?= $_SESSION['token']?>" ></p>

    <p><input type="submit"  value="Inscription"  class="button"></p>

    </form>

    <?php include("src/footer.php"); ?>

</body>
</html>