<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center mb-5 mt-3">
			<div class="col-md-4">
				<form method="POST">
					<h2 class="mb-3">Connexion</h2>
			        <div class="form-group">
			            <label>Identifiant (email)</label>
			            <input type="email" name="email" class="form-control">
			        </div>
			        <div class="form-group">
			            <label>Mot de passe</label>
			            <input type="password" name="password" class="form-control">
			        </div>
			        <button type="submit" class="btn btn-info">Se connecter</button>
			    </form>
			</div>
		</div>
	</div>

	<?php
		if(!empty($_POST)){

			$errors = [];

			if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = 'email not valid';
			}

			if(empty($_POST['password']) || !preg_match("#^\w{4,10}$#", $_POST['password'])){
			$errors[] = 'password not valid';
			}

			if(empty($errors)){

				$select = $connexion->prepare('SELECT * FROM users WHERE email = :email');
				$select->bindValue(':email', strip_tags($_POST['email']));
				$select->execute();
		    $users = $select->fetchAll();

		    	//si j'ai bien un utilisateur et que l'email correspond
		    	//je dois comparer le mdp envoyé avec le mdp crypté en base avec password_verify
		    	if(count($users) === 1 && password_verify($_POST['password'] ,$users[0]['password'])){

		    		$_SESSION['id'] = $users[0]['id'];
		    		$_SESSION['pseudo'] = $users[0]['name'];
		    		$_SESSION['mail'] = $users[0]['email'];
		        $_SESSION['role'] = $users[0]['role'];

		            if($_SESSION['role'] == 'ROLE_ADMIN' || $_SESSION['role'] == 'ROLE_VENDOR'){

		    		header('Location: index.php');

		            }
		    	}
		    	else{
		    		echo '<div class="row  justify-content-center"><div class="text-center alert alert-danger col-md-2" role="alert" >identifiants invalides</div></div>';
		    	}
			}

		}
	?>
</body>
</html>
