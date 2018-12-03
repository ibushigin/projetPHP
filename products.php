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
			<form class="col-md-2" method="GET" action="recherche_par_auteur.php">
				<!-- RECHERCHE PAR NOM -->
				<div class="row">
                	<input type="text" name="nom" placeholder="Nom">
                    <button type="submit" class="btn btn-primary btn-sm col-md-3">Rechercher</button>
                </div>
                <!-- RECHERCHE PAR CATEGORIE -->
                <div class="row">
                    <select name="category" class="form-control col-md-9">
                        <option value="0">Choisir une catégorie</option>
                        <?php
                     
                        foreach ($categories as $category) {
                            ?>
                            <option><?= $category['label'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm col-md-3">Rechercher</button>
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