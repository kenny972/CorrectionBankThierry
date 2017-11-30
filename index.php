<?php

// On ouvre une session pour la connexion des utilisateurs. Comme on reste sur cette page, pas besoin de l'ouvrir ailleurs
// session_start();

// On inclut la connexion à la DB, l'autoloader  et on crée l'objet $manager
include_once('model/init.php');

// On requiert le contrôleur qui gère nos opérations bancaires. Pour faire simple, c'est comme ci on restait toujours sur ce fichier. Tout le code sera appelé ici.
require('controllers/index.php');

 ?>
