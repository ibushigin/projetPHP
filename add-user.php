<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout user</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
  <?php require_once('inc/header.php') ?>
  <div class="container">
    <div class="row justify-content-around mb-5 mt-3">
      <div class="col-md-4">
      <form method="post">
        <h2>Ajouter un nouvel utilisateur</h2>
          <div class="form-group">
            <label for="name">Entrez le nom </label>
            <input type="text" name="name" class="form-control">
          </div>

          <div class="form-group">
            <label for="email">Entrez l'email</label>
            <input type="text" name="email" class="form-control">
          </div>

          <div class="form-group">
            <label for="password">Entrez le mot de passe</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="form-group">
            <label for="password2">Répétez le mot de passe</label>
            <input type="password" name="password2" class="form-control">
          </div>

          <label for="role">Choisissez le rôle</label>
          <div class="input-group mb-3">
            <select class="custom-select" name="role" id="role">
              <option value="ROLE_VENDOR" selected>Vendeur</option>
              <option value="ROLE_USER">Admin</option>
            </select>
          </div>

          <button class="btn btn-dark" type="submit" name="button">Envoyer</button>
        </form>
      </div>
<!-- PHP POUR L'AJOUT DE L'USER -->
<?php
//Verif du POST
if(!empty($_POST)){
  $errors = [];
  $post = [];
  foreach($_POST as $key => $value){
    $post[$key] = strip_tags($value);
  }
//Verif du nom
  if(empty($post['name']) || mb_strlen($post['name']) < 4 || mb_strlen($post['name']) > 25){
    $errors[] = 'Le nom doit faire entre 4 et 25 caractères';
  }
//Verif du mdp
  if(!isset($post['password']) OR !isset($post['password2'])
    OR mb_strlen($post['password']) < 4
    OR mb_strlen($post['password']) > 10){
      $errors['password'] = 'le mot de passe doit faire entre 4 et 10 caractères';
  }
  if($post['password'] !== $post['password2']){
        $errors['mdp'] = 'Les deux mdp envoyés doivent être identiques';
    }
//Verif du role
  if(!isset($post['role']) || (($post['role']) != 'ROLE_ADMIN' && ($post['role']) != 'ROLE_VENDOR')){
      $errors['role'] = 'rôle pas trouvé';
    }
//Verif de l'email
  $select = $connexion->prepare('SELECT * FROM users WHERE email = :email');
  $select->bindValue(':email', $post['email']);
  $select->execute();
  $users = $select->fetchAll();
  if(count($users) > 0){
    $errors[] = 'l\'email existe déjà';
  }
  if(empty($post['email']) OR !filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'email invalide';
  }

//Validé ===> insert
  if(empty($errors)){
    $insert = $connexion->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
    $insert->bindValue(':name', $post['name']);
    $insert->bindValue(':email', $post['email']);
    $insert->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
    $insert->bindValue(':role', $post['role']);
    if($insert->execute()){
      echo 'vous avez bien inscrit ' .$post['name'];
    }
    else{
      echo 'sql error';
    }
  }
  else{
    echo implode('<br>', $errors);
  }
}
 ?>
    <div class="col-md-4">
      <h2>Modifier un utilisateur</h2>
      <?php
      $select = $connexion->query('SELECT id, name FROM users');
      $users = $select->fetchAll();
      ?>
        <form class="mb-5">
            <div class="form-group">
                <label>Nom de l'utilisateur</label>
                <select name="idUser" class="form-control">
                    <option value="0">Choisir un user</option>
                    <?php
                    foreach($users as $user){
                        ?>
                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button class="btn btn-dark">Choisir</button>
        </form>
  <?php


if(!empty($_GET['idUser']) && preg_match("#^\d+$#", $_GET['idUser'])){
    //récupération des infos de l'utilisateur
    $select = $connexion->prepare('SELECT * FROM users WHERE id = :id');
    $select->bindValue(':id', $_GET['idUser']);
    $select->execute();
    $user = $select->fetch();
?>
<hr>
        <form method="post" class="mt-5">
          <div class="form-group">
              <label>Nom</label>
              <input type="text" name="Nom" class="form-control" value="<?= $user['name'] ?>">
          </div>
          <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control" value="<?= $user['email'] ?>">
          </div>
          <div class="form-group">
              <label>Role</label>
              <select name="role" class="form-control">
                  <option value="0">Choisir un role</option>
                  <option value="ROLE_AUTEUR" <?= $user['role'] === "ROLE_VENDOR" ? 'selected' : ''; ?> >Vendeur</option>
                  <option value="ROLE_ADMIN" <?= $user['role'] === "ROLE_ADMIN" ? 'selected' : ''; ?> >admin</option>
              </select>
          </div>
          <input type="hidden" name="idUser" value="<?= $_GET['idUser'] ?>">
          <button type="submit" class="btn btn-dark">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>



</body>
</html>
