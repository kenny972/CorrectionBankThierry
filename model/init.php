<?php

// Connexion à la base de données
try
{
  $db = new PDO('mysql:host=localhost;dbname=exobanque;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


// Chargement automatique des classes
function chargerClasse($classname){
  require 'entities/' . $classname . '.php';
}
spl_autoload_register('chargerClasse');

require('model/AccountManager.php');

// Création d'un manager compte. Je le crée une seule fois, car je reste toujours sur le même fichier.
// Je lui passe mon instance PDO $db en argument
$manager = new AccountManager($db);

// Création d'un manager user
// $managerUser = new UserManager($db);
