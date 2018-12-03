<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Produits</title>
  <?php require_once('inc/header.php');
		?>
<div class="container">
	<div class="row ml-0">
		<div class="col-md-12">
			<h2 class="text-center mt-5 mb-5">Nos produits</h2>

			<!-- BARRE DE RECHERCHE -->
			<?php

			$select = $connexion->query('SELECT label, id FROM category ORDER BY label');
            $categories = $select->fetchAll();

            ?>
		<div class="row justify-content-center">
            	<form class="col-md-10" method="GET" action="recherche.php">
            		<!-- RECHERCHE PAR NOM -->
            		<div class="row">
            			<div class="col-md-3">
            				<input type="text" name="name" placeholder="Nom" class="form-control">
            			</div>

            		<!-- RECHERCHE PAR CATEGORIE -->
            			<div class="col-md-3">
	            			<select name="category" class="form-control">
	            				<option value="0">Choisir une catégorie</option>
	            				<?php

	            				foreach ($categories as $category) {

	            					?>
	            					<option value="<?= $category['id'] ?>"><?= $category['label'] ?></option>
	            					<?php
	            				}
	            				?>
	            			</select>
            			</div>

            			<!-- CLASSER PAR PRIX -->
            			<div class="col-md-3">
	            			<select name="prix" class="form-control">
	            				<option value="0">Ordre Prix</option>
	            				<option value="croissant">Croissant</option>
	            				<option value="decroissant">Décroissant</option>                   	
	            			</select>
	            		</div>
	            		<div class="col-md-3">
	            			<button type="submit" class="btn btn-primary">Rechercher</button>
	            		</div>
            		</div>
            	</form>
            </div>
			
			<!-- LISTE DES PRODUITS -->

				<div class="row justify-content-around mt-5">
			<?php
				$select = $connexion->query('SELECT * FROM pictures INNER JOIN products ON pictures.id_product = products.id ORDER BY date_create DESC');
				$products = $select->fetchAll();

				foreach($products as $product){
			?>
				<article>
					<h3><?= $product['name'] ?></h3>
					<img src="files/thumbnails/<?= $product['file_name'] ?>">
					<p>Prix : <?= $product['price'] ?>€</p>
					<a href="detail_produit.php?id=<?= $product['id'] ?>">Détail</a>
				</article>
			<?php	
				}
			?>
				</div>
		</div>
	</div>
</div>

</body>
</html>