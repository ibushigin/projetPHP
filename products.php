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
				<div class="row justify-content-around">
			<?php
				$select = $connexion->query('SELECT * FROM pictures INNER JOIN products ON pictures.id_product = products.id ORDER BY date_create DESC');
				$products = $select->fetchAll();

				foreach($products as $product){
			?>
				<article>
					<h3><?= $product['name'] ?></h3>
					<img src="files/thumbnails/<?= $product['file_name'] ?>">
					<p><?= $product['price'] ?>€</p>
				</article>
			<?php	
				}
			?>
				</div>
		</div>
	</div>

</body>
</html>