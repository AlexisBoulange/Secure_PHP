<?php
    require_once("connect.php");
    require_once("Controller.php");
    require_once("MyError.php");
    //session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant de session passé dans une requête GET, POST ou par un cookie
    session_start();

    //On créer un  nouvelle objet à partir de la classe Controller
    $controler = new Controller($connexion);

    /* Autre façon de le faire :
    $name = htmlentities(trim($_POST['username'])) ;
    $pwd1 = htmlentities(trim($_POST['password'])) ;
    $pwd2 = htmlentities(trim($_POST['pwdverif'])) ; */

    // Récupère la variable externe "username" en type POST et la filtre en RegEx
    $name = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, [
        "options" => [
            "regexp" => '#^[A-Za-z][A-Za-z0-9_-]{5,31}$#'
        ]
    ]) ;
    // Si $name est une chaîne de caractères
    if (is_string($name)) {
        // Récupère la variable externe "password" en type POST et la filtre en RegEx
        $pwd1 = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => '#^.*(?=.{8,63})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).*$#'
            ]
        ]) ;
        // Si $pwd1 est une chaîne de caractères
        if (is_string($pwd1)) {
            //On déclare "$user" et on lui donne une valeur (ce qui est à droite (getUser()) de l'operateur "->" est une méthode de l'objet instanciée ("Controller") dans la variable à gauche de l'opérateur)
            $user = $controler->getUser($name);
            
            //On détermine si la variable $user est un tableau
            if (is_array($user)) {

                //Si le nom d'utilisateur est déjà pris, on affiche une erreur à l'aide de la fonction setError
                $_SESSION['error']->setError(-3, "Cet identifiant est déjà pris ! Veuillez en choisir un autre...") ;
                header("Location:sign-in.php?error");

            } else {
                //Si l'username est bon, on récupère la variable externe "verifpassword" en type POST et on filtre les caractères ASCII <32 et >127 (caractères spéciaux entre-autre)
                $pwd2 = filter_input(INPUT_POST, 'verifpassword', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) ;

                //On vérfie que les 2 mdp concordent en valeur et en type
                if ($pwd1 === $pwd2) {

                    //On ajoute l'utilisateur à la BDD et on hash son mdp
                    $status = $controler->addUser(strtolower($name), password_hash($pwd1, PASSWORD_DEFAULT)) ;

                    //Si l'opération a fonctionnée, on redirige vers l'index
                    if ($status) {

                        header("Location:index.php");

                    } else {

                        //Sinon on lance une erreur sans expliquer le problème (pour éviter un piratage)
                        $_SESSION['error']->setError(-9, "Erreur inconnue ! Veuillez réessayer...") ;
                        header("Location:sign-in.php?error");

                    }
                } else {
                    //Sinon si les mdp ne sont pas les mêmes (égaux en valeur et en type) on affiche un message
                    $_SESSION['error']->setError(-4, "Les deux mots de passe saisis ne concordent pas ! Veuillez réessayer...") ;
                    header("Location:sign-in.php?error");

                }

           }

        } else {
            //Le mdp ne passe pas au filter, on affiche une erreur et spécifie les changements à faire
            $_SESSION['error']->setError(-2, "Le mot de passe doit comporter au moins 8 caractères, et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial ! Veuillez réessayer...") ;
            header("Location:sign-in.php?error");
    
        }

    } else {
        //L'username ne correspond pas au filter, on affiche une erreur et on donne les instructions à suivre
        $_SESSION['error']->setError(-1, "Le nom d'utilisateur doit comporter entre 6 et 32 caractères alphanumériques, et commencer par une lettre ! Veuillez réessayer...") ;
        header("Location:sign-in.php?error");

    }


