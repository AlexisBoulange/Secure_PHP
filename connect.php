<?php

//Création d'une instance PDO avec "try" et définition du mode d'erreur avec "catch"
// ! Chaque try doit avoir au moins un bloc "catch" ou "finally" !
try{
    //PHP Data Objects (PDO) est une extension définissant l'interface pour accéder à une base de données avec PHP.
    $connexion = new PDO(
        'mysql:host=localhost:3306;dbname=securev1',
        'root',
        ''
    );
    //"setattribute()" configure un attribut du gestionnaire de base de données, puis on définit le mode de récupération dans PDO (ici par défaut) et FETCH_ASSOC retourne le tableau indexé par le nom de la colonne comme retourné dans le jeu de résultats
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

}

catch(Exception $e){ // On va attraper les exceptions "Exception" s'il y en a une qui est levée.
    echo $e->getMessage();
}