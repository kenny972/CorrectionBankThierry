<?php

class AccountManager{

  private $_db; // Instance PDO

  public function __construct($db){
    $this->setDb($db);
  }

  public function add(Account $account){
    $req = $this->_db->prepare('INSERT INTO account(name,sum,userId) VALUES (:name, :sum, :userId)');

    // On enregistre les valeurs de l'objet dans la DB
    $req->bindValue(':name', $account->getName());
    $req->bindValue(':userId', $account->getUserId());
    $req->bindValue(':sum', $account->getSum());
    $req->execute();
  }

  public function delete(Account $account){
    // On supprime un compte à partir de son ID
    $req = $this->_db->prepare('DELETE FROM account where id = :id');
    $req->bindValue(':id', $account->getId(), PDO::PARAM_INT);
    $req->execute();
  }

  public function update(Account $account){
    // On met à jour la somme du compte à partir de son ID
    $req = $this->_db->prepare('UPDATE account SET sum = :sum WHERE id = :id');

    $req->bindValue(':sum', $account->getSum(), PDO::PARAM_INT);
    $req->bindValue(':id', $account->getId(), PDO::PARAM_INT);

    $req->execute();
  }

  // Récupérer tous les comptes d'un utilisateur en particulier
  public function getAccounts($userId){
    // On déclare un tableau vide qui contiendra nos objets Account
    $accounts = [];

    // On récupère les infos des comptes appartenant à un User en fonction de son ID
    $req = $this->_db->prepare('SELECT id, name, sum, userId FROM account WHERE userId = :userId ORDER BY id');
    $req->bindValue(':userId', $userId, PDO::PARAM_INT);

    $req->execute();

    // On crée des objets Account en fonction de ces infos qu'on range dans notre tableau
    while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
    {
      $accounts[] = new Account($donnees);
    }

    // On renvoie le tableau
    return $accounts;
  }

  public function get($id){
    // On récupère les infos d'un compte à partir de son ID
    $req = $this->_db->prepare('SELECT * FROM account WHERE id = :id');
    $req->bindValue(':id', $id, PDO::PARAM_INT);
    $req->execute();

    // On crée un nouvel object $account à partir des données récupérées, et on le renvoie
    $donnees = $req->fetch(PDO::FETCH_ASSOC);
    return new Account($donnees);
  }

  // Setter
  // On s'assure qu'on passe bien un objet PDO en paramètre
  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
