<?php

//Création d'une nouvelle classe Controller qui nous permettra de check l'utilisateur
 class Controller{

    private $_connexion;
    private $_user;


    public function __construct($connexion){
            $this->_connexion = $connexion;
    }

    //Création d'une fonction nous permettant de récupérer l'utilisateur depuis la BDD
    public function  getUser($uname){

        try{
            //On affecte à la variable $sql une valeur à partir de la BDD
            $sql = "SELECT username, password FROM user WHERE username = LOWER(:name)";

            //Préparation de la requête dans le serveur (elle ne sera pas encore exécutée)
            $statement = $this->_connexion->prepare($sql);

            //Injection des paramètres, ici bindParam() lie un paramètre (name) à un nom de variable spécifique ($uname)
            $statement->bindParam("name", $uname);

            //Exécute la requête préparée 
            $statement->execute();

            //On récupère l'utilisateur dans la BDD
            $this->_user = $statement->fetch();

            return $this->_user;
        }

        catch(Exception $e){
            return $e->getMessage();
        }
    }

    //On vérifie que le mdp est correct
    public function verifyPassword($upwd){
        sleep(1);
        //password_verify() vérifie qu'un mot de passe correspond à un hachage
        return password_verify($upwd, $this->_user['password']);

    }

    //Création d'une fonctione permettant à l'utilisateur de s'enregistrer si il n'a pas de compte
    public function addUser($uname, $upwd){

        try{
            //On ajoute à la table user un username et un mdp
            $sql = "INSERT INTO user (username, password) VALUES (:name, :pwd)";

            //Préparation de la requête dans le serveur (pas encore exécutée)
             $statement = $this->_connexion->prepare($sql);

             //Injection des paramètres, ici bindParam() lie un paramètre (name) à un nom de variable spécifique ($uname)
             $statement->bindParam("name", $uname);

             //Injection des paramètres, ici bindParam() lie un paramètre (pwd) à un nom de variable spécifique ($upwd)
             $statement->bindParam("pwd", $upwd);
         
            //Exécute la requête préparée 
            return $statement->execute();

        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
 }

 ?>