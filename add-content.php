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
<div class="container-fluid">
    <div class="row justify-content-around mb-5 mt-3">

      <div class="col-md-4 mt-5">
        <form action="" method="post">

        <h1>Modifier le contenu</h1>
          <div class="form-group">
            <label for="title">Titre de la page</label>
            <input type="text" name="title" class="form-control">
          </div>

          <div class="form-group">
            <label for="p1">Premier paragraphe</label>
            <textarea type="text" name="p1" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <label for="p2">Deuxième paragraphe</label>
            <textarea type="text" name="p2" class="form-control"></textarea>
          </div>

          <button class="btn btn-dark" type="submit" name="btnContent">Modifier</button>
        </form>
      </div>

      <div class="col-md-4 mt-5">
        <form method="post">
        <h1>Modifier l'adresse</h1>
          <div class="form-group">
            <label for="address">Adresse de la boutique</label>
            <input type="text" name="address" placeholder="# rue code postal ville" class="form-control">
          </div>
          <button class="btn btn-dark" type="submit" name="btnAddress">Modifier</button>
        </form>
      </div>

      <div class="col-md-4 mt-5">
        <form method="post" enctype="multipart/form-data">
        <h1>Modifier les images de la page d'accueil</h1>
        <div class="form-group">
          <label for="img1">Première image</label>
          <input class="form-control" type="file" name="img1">
        </div>

        <div class="form-group">
          <label for="img2">Deuxième image</label>
          <input class="form-control" type="file" name="img2">
        </div>

        <div class="form-group">
          <label for="img3">Troisième image</label>
          <input class="form-control" type="file" name="img3">
        </div>

          <button class="btn btn-dark" type="submit" name="btnImg">Ajouter les images</button>
        </form>
      </div>
    </div>


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
      $insert = $connexion->prepare('INSERT INTO content (title, p1, p2) VALUES (:title, :p1 , :p2)');
      $insert->bindValue(':title', $post['title']);
      $insert->bindValue(':p1', $post['p1']);
      $insert->bindValue(':p2', $post['p2']);
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
		$delete = $connexion ->prepare('DELETE FROM address');
		$delete->execute();
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
//TRAITEMENT DES IMAGES DU CAROUSEL
if(!empty($_FILES)){
	$delete = $connexion ->prepare('DELETE FROM carousel');
	$delete->execute();
	$folder = 'files/carousel';
	$files = glob($folder . '/*');
	foreach($files as $file){
	    if(is_file($file)){
	        unlink($file);
	    }
	};
  foreach($_FILES as $key => $file){
    if($_FILES[$key]['error']==0){

      $maxSize = 2000 * 1024;
      if($_FILES[$key]['size'] <= $maxSize){
        $fileInfo = pathinfo($_FILES[$key]['name']);
        $extension = $fileInfo['extension'];
        $extensionAuth = ['jpg', 'png', 'svg', 'gif', 'jpeg'];
        if(in_array($extension, $extensionAuth)){
          $newName = md5(uniqid(rand(), true));
          if($extension === 'jpg' || $extension === 'jpeg'){
            $newImage = imagecreatefromjpeg($_FILES[$key]['tmp_name']);
          }elseif($extension === 'png'){
            $newImage = imagecreatefrompng($_FILES[$key]['tmp_name']);
          }else($extension === 'gif'){
            $newImage = imagecreatefromgif($_FILES[$key]['tmp_name'])
          };
          move_uploaded_file($_FILES[$key]['tmp_name'], 'files/carousel/' . $newName .'.'. $extension);
          $file_name = $newName .'.'. $extension;

					$insert = $connexion->prepare('INSERT INTO carousel (img1) VALUES (:img1)');
          $insert->bindValue(':img1', strip_tags($file_name));

          if($insert ->execute()){
            echo "<h3>Fichier enregistré</h3>";
          }else{
            echo "<h3>Erreur de chargement</h3>";
          }

        }else{
          echo "<h3>Extension interdite</h3>";
        }
      }else{
        echo "<h3>Fichier supérieur à la limite de 2000ko</h3>";
      }
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
