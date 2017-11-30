<?php

class Account {

  protected $id,
            $name,
            $sum = 80,
            $userId;

  public function hydrate(array $donnees){
    foreach($donnees as $key => $value){
      $method = 'set' . ucfirst($key);

      if(method_exists($this, $method)){
        $this->$method($value);
      }
    }
  }

  public function __construct(array $donnees){
    $this->hydrate($donnees);
  }

  // Ajouter la valeur de $sum passé en paramètre à notre attribut $sum
  public function ajouter($sum){
    $sum = (int) $sum;
    if(!$sum == 0){
      $this->sum += $sum;
    }
  }

  // Retirer la valeur de $sum passé en paramètre à notre attribut $sum
  public function retirer($sum){
    $sum = (int) $sum;
    if(!$sum == 0){
      $this->sum -= $sum;
    }
  }

 // Setters

  public function setId($id){
    $id = (int) $id;
    if($id > 0){
      $this->id = $id;
    }
  }

  public function setName($name){
    if(is_string($name)){
      $this->name = $name;
    }
  }

  public function setSum($sum){
    $sum = (int) $sum;
    $this->sum = $sum;
  }

  public function setUserId($userId){
    $userId = (int) $userId;
    if($userId > 0){
      $this->userId = $userId;
    }
  }

  // Getters

  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getSum(){
    return $this->sum;
  }

  public function getUserId(){
    return $this->userId;
  }
}
