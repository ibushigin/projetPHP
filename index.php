<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<?php require_once('inc/header.php');

	if(isset($_GET['deco'])){
            //on supprime la session
            session_destroy();
            //on redirige vers la page d'accueil
            header('location:index.php');
    }


	?>

	<div class="row background">
		<div class="col-md-3 description text-center">
			<div class="row">
				<h2 class="col-md-12 mt-3">A propos de nous</h2>
				<p></p>
			</div>

			<div class="row mt-5">
				<div class="col-md-12">
					<p>Vintage Shop vous présente tous les articles que vous retrouverez dans nos magasins. Si vous aimez le style rock bla bla bla.....</p>
				</div>
			</div>


		</div>
	</div>
</body>
</html>
