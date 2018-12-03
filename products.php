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
	<div class="row ml-0">
		<div class="col-md-12">
			<h2 class="text-center mt-5 mb-5">Nos produits</h2>

			<!-- BARRE DE RECHERCHE -->
			<?php

			$select = $connexion->query('SELECT DISTINCT label FROM category ORDER BY label');
            $categories = $select->fetchAll();

            ?>
		<div class="row justify-content-center">
			<form class="col-md-2" method="GET" action="description_produit.php">
				<!-- RECHERCHE PAR NOM -->
				<div class="row mb-2">
                	<input type="text" name="name" placeholder="Nom" class="form-control col-md-12">
                </div>
                <!-- RECHERCHE PAR CATEGORIE -->
                <div class="row mb-2">
                    <select name="category" class="form-control col-md-12">
                        <option value="0">Choisir une catégorie</option>
                        <?php
                     
                        foreach ($categories as $category) {
                            ?>
                            <option><?= $category['label'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- CLASSER PAR PRIX -->
                <div class="row justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm col-md-6">Rechercher</button>
                    <select name="prix" class="form-control col-md-6">
                        <option value="0">Ordre Prix</option>
                        <option value="croissant">Croissant</option>
                        <option value="decroissant">Décroissant</option>                   	
                    </select>
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
				</article>
			<?php	
				}
			?>
				</div>
		</div>
	</div>

</body>
</html>