<?php
session_start();
require_once('inc/connexion.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<?php require_once('inc/header.php');
	if(isset($_GET['deco'])){
            //on supprime la session
            session_destroy();
            //on redirige vers la page d'accueil
            header('location:index.php');
    }
    // BOUCLE SUR LE CONTENU
    $resultat = $connexion->query('SELECT * FROM content ORDER BY id DESC LIMIT 1');

    $contenu = $resultat->fetchAll();

    foreach($contenu as $content){
	?>
	<div class="row background ml-0 carousel">
		<div class="col-md-3 description text-center">
			<div class="row">
				<h2 class="col-md-12 mt-3"><?= $content['title'] ?></h2>
			</div>
			<div class="row mt-5">
				<div class="col-md-12">
					<p><?= $content['p1'] ?></p>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-12">
					<p><?= $content['p2'] ?></p>
				</div>
			</div>
		</div>
	<?php
    }
    ?>
		<div class="col-md-6">
		</div>
		<!-- BOUCLE SUR LES IMAGES -->
		<div class="col-md-3 description text-center">
			<div class="row">
				<h2 class="col-md-12 mt-3">Derniers produits ajoutés</h2>
			</div>
			<div class="row mt-5">
				<div class="col-md-12 flex-column">
				<?php
					$select = $connexion->query('SELECT * FROM pictures ORDER BY id DESC LIMIT 4');
					$products = $select->fetchAll();
					foreach($products as $product){
				?>
					<img src="files/thumbnails/<?= $product['file_name'] ?>">
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</div>

<?php

 ?>
<script src="js/jQuery.js"></script>
<script>/*Changement Background*/
$(function () {
    var carousel = $('.carousel');
    var backgrounds = [
			<?php
			//TRAITEMENT DES IMAGES BACKGROUND
			$select = $connexion -> query('SELECT * FROM carousel ORDER BY id DESC LIMIT 3');
			$slider = $select -> fetchAll();
			foreach($slider as $img){
				echo "'url(files/carousel/".$img['img1'].")', ";
			}
			?>
      ];
    var current = 0;

    function nextBackground() {
        carousel.css(
            'background',
        backgrounds[current = ++current % backgrounds.length]);

        setTimeout(nextBackground, 5000);
    }
    setTimeout(nextBackground, 5000);
    carousel.css('background', backgrounds[0]);
});</script>
</body>
</html>
