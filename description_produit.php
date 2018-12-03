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

			$select = $connexion->query('SELECT label, id FROM category ORDER BY label');
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
                            <option value="<?= $category['id'] ?>"><?= $category['label'] ?></option>
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
		if(!empty($_GET)){

			// RECHERCHE PAR NOM ET CATEGORIE
			if(isset($_GET['name']) && $_GET['name'] < 20){
				$sql = 'SELECT * FROM pictures INNER JOIN products ON pictures.id_product = products.id ';

				if(!empty($_GET['name'])){
					$sql .= ' AND name LIKE :name';
				}

				if(!empty($_GET['category'])){
					$sql .= ' AND products.id_category = :category';
				}

				$select = $connexion->prepare($sql);

				if(!empty($_GET['name'])){
					$select->bindValue(':name', '%' .$_GET['name'] . '%');
				}
				if(!empty($_GET['category'])){
					$select->bindValue(':category', $_GET['category']);
				}

        		$select->execute();
        		$products = $select->fetchAll();
                foreach($products as $product){
                    ?>
					<article>
						<h3><?= preg_replace('#(' . strip_tags($_GET['name']) . ')#i', "<span style='background-color:skyblue;'>$1</span>", $product['name']) ?></h3>
						<img src="files/thumbnails/<?= $product['file_name'] ?>">
						<p>Prix : <?= $product['price'] ?>€</p>
					</article>
                    <?php
                 }
			}else{
				$errors[] = 'Mauvaise saisie';
			}

		}
		else{			
			?>
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
		}
			?>
			</div>
		</div>
	</div>

</body>
</html>