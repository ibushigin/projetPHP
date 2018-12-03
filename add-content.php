<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout user</title>
  <?php require_once('inc/header.php');
  if(!empty($_SESSION['role']) && ( $_SESSION['role'] === "ROLE_ADMIN")){?>

  <h1>Modifier le contenu</h1>
    <form action="" method="post">
      <label for="title">Titre de la page</label>
      <input type="text" name="title">
      <label for="p1">Premier paragraphe</label>
      <textarea type="text" name="p1"></textarea>
      <label for="p2">Deuxième paragraphe</label>
      <textarea type="text" name="p2"></textarea>
      <button type="submit" name="btnContent">Modifier</button>
    </form>

  <h1>Modifier l'adresse</h1>
    <form method "post">
      <label for="address">Adresse de la boutique</label>
      <input type="text" name="address" placeholder="# rue code postal ville">
      <button type="submit" name="btnAddress">Modifier</button>
    </form>



    <?php
//TRAITEMENT MODIF CONTENU
if(!empty($_POST)){
  if(isset($_POST['btnContent'])){
    $errors = [];
    $post = [];
    foreach($_POST as $key => $value){
      $post[$key] = strip_tags($value);
    }
    //VERIF DU FORMULAIRE
    if(empty($post['title']) || mb_strlen($post['title']) > 30 || mb_strlen($post['title']) < 5){
      $errors[] = 'Le titre doit faire entre 5 et 30 caractères.';
    }
    if(empty($post['p1'])){
      $errors[] = 'Ajouter du contenu au paragraphe 1';
    }
    if(empty($errors)){
      $insert = $connexion->prepare('INSERT INTO content (title, p1, p2) VALUES (:title, :p1 , ;p2)');
      $insert->bindValue(':title', $post['title']);
      $insert->bindValue(':p1', $post['p1']);
      $insert->bindValue(':p2', ($post['p2']));
      if($insert->execute()){
        echo 'vous avez modifié le contenu de la page d\'accueil.';
      }
      else{
        echo 'sql error';
      }
    }
    else{
      echo implode('<br>', $errors);
    }

  }
}
//TRAITEMENT DE L'ADRESSE
if(!empty($_POST)){
  if(isset($_POST['btnAddress'])){
    $errors = [];
    $post = [];
    foreach($_POST as $key => $value){
      $post[$key] = strip_tags($value);
    }
    if(empty($post)){
      $errors[] = 'Entrez une adresse';
    }
    if(empty($errors)){
      $insert = $connexion -> prepare('INSERT INTO address (address) VALUES (:address)');
      $insert -> bindValue(':address', $post['address']);
      if($insert -> execute()){
        echo 'vous avez modifié l\'adresse de la boutique.';
      }else{
        echo 'sql error';
      }
    }else{
      echo implode('<br>', $errors);
    }
  }
}
//FERMETURE DE LA CONDITION CONNEXION
  }else{
  		echo 'vous devez être connecté ou avoir les droits pour accéder à cette page';
  }
?>
  </body>
</html>
