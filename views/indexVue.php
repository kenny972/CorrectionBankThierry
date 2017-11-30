<?php
  include("includes/header.php")
 ?>

<?php
  // Quand on intègrera la connexion de users, on vérifie sur la variable $_SESSION['name'] existe et n'est pas vide pour afficher un message de bienvenue à l'utilisateur.
  if(isset($_SESSION['name']) && !empty($_SESSION['name']))
  {
 ?>
   <p>Bonjour <?php echo $_SESSION['name']; ?>. Bienvenue sur votre page de gestion de comptes</p>


   <form action="" method="post">
     <input type="submit" name="deconnexion" value="Déconnexion">
   </form>

   <?php
 }
 ?>

   <h1>Mes comptes</h1>



  <?php



  // On parcourt le tableau $comptes qu'on vient de créer
  foreach($accounts as $account){
    ?>

    <div class="compte">
    <fieldset>
      <legend>Compte n°<?php echo $account->getId();?><strong> : <?php echo $account->getName();?></strong></legend>
      <p><u>Somme disponible : </u><br><br>
        <?php echo $account->getSum(); ?>€</p>
      </fieldset>

      <!-- FORMULAIRE VERSEMENT/RETRAIT -->
      <form action="" method="post">
        <input type="text" class="sum" name="sum" placeholder="Entrez une somme">
        <input type="hidden" name="id" value="<?php echo $account->getId();?>">
        <input type="submit" name="credit" value="Créditer">
        <input type="submit" name="debit" value="Débiter">
      </form>
      <!-- END FORMULAIRE VERSEMENT/RETRAIT -->

      <!-- FORMULAIRE SUPPRESSION COMPTE -->
      <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $account->getId();?>">
        <input type="submit" name="delete" value="Supprimer le compte">
      </form>
      <!-- END FORMULAIRE SUPPRESSION COMPTE -->
    </div>
    <?php
 }
 ?>

 <hr>

 <h2>Effectuer un virement</h2>

 <!-- FORMULAIRE POUR VIREMENT -->
 <form action="" method="post">
  <p>
  <label for="sum">Somme à transférer</label><br>
  <input type="text" id="sum" name="sum" placeholder="Somme à transférer">€ <br>
  <label for="id1">Compte à débiter</label><br>
  <input type="text" id="id1" name="id1" placeholder="N° du compte à débiter"><br>
  <label for="id2">Compte à créditer</label><br>
  <input type="text" id="id2" name="id2" placeholder="N° du compte à créditer"><br>
  <input type="submit" value="Effectuer le virement" name="transfer">
  </p>
 </form>
 <!-- END FORMULAIRE POUR VIREMENT -->

 <h2>Créer un compte</h2>

 <!-- FORMULAIRE CREATION DE COMPTE -->
 <form action="" method="post">
  <input type="text" name="name" placeholder="Entrez un nom de compte">
  <input type="submit" value="Créer un compte" name="create">
 </form>
 <!-- END FORMULAIRE CREATION DE COMPTE -->


 <?php
 include('includes/footer.php');
  ?>
