<?php

// Pour se déconnecter, on détruit la session et on se redirige vers la page de connexion
// if(isset($_POST['deconnexion'])){
//   session_destroy();
//   header('location: index.php');
// }

// ##### AJOUTER UN COMPTE #####
// Si on a cliqué sur 'Créer un compte'
if(isset($_POST['create']) && !empty($_POST['create'])){
  // On évite l'ajout d'une entrée avec un nom vide dans la table 'account'
  if(isset($_POST['name']) && !empty($_POST['name'])){

    // Création d'un nouvel objet 'Account'. Pour le moment il existe mais n'est pas encore ajouté à la DB. C'est le manager qui s'en occupera.
    $account = new Account([
      'name' => $_POST['name'],
      'userId' => 1,  // On donne une valeur par défaut, on changera par l'ID du user
    ]);

    // On ajoute les valeurs de notre objet $account à la DB
    $manager->add($account);
  }
}

// ##### AJOUTER / RETIRER UNE SOMME #####
// Si on a cliqué sur 'débiter' ou 'créditer'
if( (isset($_POST['debit']) && !empty($_POST['debit'])) || (isset($_POST['credit']) && !empty($_POST['credit'])) ){

  // On vérifie si une somme a bien été entrée dans l'input et que l'ID est bien envoyé
  if(isset($_POST['sum']) && !empty($_POST['sum']) && isset($_POST['id']) && !empty($_POST['id'])){

    // On crée un nouvel objet, en fonction de l'ID, à partir des infos en base de données
    $account = $manager->get($_POST['id']);
    // On ajoute la somme si on clique sur le bouton ajouter
    if(isset($_POST['credit']) && !empty($_POST['credit'])){
      $account->ajouter($_POST['sum']);
    } else {
      // Sinon on retire la somme du compte
      $account->retirer($_POST['sum']);
    }

    // Nous avons modifier les valeurs de l'attribut, mais rien n'a encore été modifié en base de données
    // On demande au manager d'enregistrer les modifications dans la DB
    $manager->update($account);
  }

}

// ##### SUPPRIMER UN COMPTE #####
// Si on clique sur Supprimer le compte et que l'ID a bien été envoyé
if(isset($_POST['delete']) && !empty($_POST['delete']) && isset($_POST['id']) && !empty($_POST['id'])){

  // Creation d'un nouvel objet $compte prenant comme ID l'ID du compte à supprimer
  $account = $manager->get($_POST['id']);
  // On demande au manager de supprimer l'entrée en fonction de cet ID
  $manager->delete($account);

}

// ##### FAIRE UN VIREMENT #####
// Si on clique sur 'Effectuer le virement'
if(isset($_POST['transfer']) && !empty($_POST['transfer'])){
  // On vérifie la présence de toutes les infos
  if(isset($_POST['sum']) && !empty($_POST['sum']) && isset($_POST['id1']) && !empty($_POST['id1']) && isset($_POST['id2']) && !empty($_POST['id2'])){
    $sum = $_POST['sum'];
    $id1 = $_POST['id1'];
    $id2 = $_POST['id2'];

    // On utilise la méthode get() du manager pour récupérer les infos d'un compte en fonction de son ID, et on attribue le résultat à une variable

    $account1 = $manager->get($id1); // Création de l'objet compte à débiter
    $account2 = $manager->get($id2); // Création de l'objet compte à créditer

    $account1->retirer($sum); // On retire la somme à l'objet compte à débiter
    $account2->ajouter($sum); // On ajoute la somme à l'objet compte à créditer

    // Notez qu'on aurait très bien pu créer une méthode dans notre classe Account qui permet de faire directement un virement, plutôt que de faire un crédit sur un compte et un débit sur un autre

    // On enregistre les modifications dans la DB pour chacun des objets comptes modifiés
    $manager->update($account1);
    $manager->update($account2);

  }
}


//$manager->getAccounts() crée un tableau d'objets 'Account' créés à partir des infos de la DB
// En gros on récupère toutes les entrées de notre table, et on crée un objet pour chaque entrée pour pouvoir les afficher dans notre vue grâce à une boucle foreach
// On passe 1 en paramètre simulant l'id d'un utilisateur. On le modifiera quand on y ajoutera la connexion de users
$accounts = $manager->getAccounts(1);

// On affiche la vue
include('views/indexVue.php');
