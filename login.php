<?php
    require_once("connect.php");
    require_once("Controller.php");
    require_once("MyError.php");

    //session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie
    session_start();

    //On créer un nouvel objet Controller
    $controler = new Controller($connexion);

    // $name = htmlentities(trim($_POST['username']));
    // $pwd  = htmlentities(trim($_POST['password']));

    // Récupère la variable externe "username" en type POST et supprime les balises, et supprime ou encode les caractères spéciaux (FILLTER_SANITIZE_STRING) et on filtre les caractères ASCII <32 et >127 (caractères spéciaux entre-autre)
    $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) ;

    // Si $name est une chaîne de caractères
    if (is_string($name)) {

        // Récupère la variable externe "password" en type POST et supprime les balises, et supprime ou encode les caractères spéciaux (FILLTER_SANITIZE_STRING) et on filtre les caractères ASCII <32 et >127 (caractères spéciaux entre-autre)
        $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) ;

        // Récupère la variable externe "token" en type POST et la filtre en RegEx
        $token = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => '#^[A-Fa-f0-9]{48}$#'
            ]
        ]) ;
        //On récupère le nom d'utilisateur dans la BDD
        $user = $controler->getUser($name);
        //On vérifie que $user est un tableau
        if (is_array($user)) {
            //On récupère et vérifie le mdp correspondant
            if ($controler->verifyPassword($pwd)) {
                //hash_equels() Comparaison de chaînes résistante aux attaques temporelles
                if (hash_equals($_SESSION['token'], $token)) {

                    $_SESSION['user'] = $user;
                    header("Location:index.php");

                } else {

                    $_SESSION['error']->setError(-8, "Identification incorrecte ! Veuillez réessayer...") ;
                    header("Location:index.php?error");

                }

            } else {

                $_SESSION['error']->setError(-7, "Identification incorrecte ! Veuillez réessayer...") ;
                header("Location:index.php?error");

            }

        } else {

            $_SESSION['error']->setError(-6, "Identification incorrecte ! Veuillez réessayer...") ;
            header("Location:index.php?error");

        }

    } else {

        $_SESSION['error']->setError(-5, "Identification incorrecte ! Veuillez réessayer...") ;
        header("Location:index.php?error");

    }
