<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
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
</body>
</html>

