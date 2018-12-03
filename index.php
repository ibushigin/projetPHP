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


	?>

	<div class="row background ml-0">
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
		<div class="col-md-7">
		</div>
		<div class="col-md-2 description text-center">
			<div class="row">
				<h2 class="col-md-12 mt-3">Top Ventes</h2>
				<p></p>
			</div>

			<div class="row mt-5">
				<div class="col-md-12">
				<?php
					$select = $connexion->query('SELECT * FROM products ORDER BY date_create DESC, name LIMIT 4');
					$products = $select->fetchAll();

					foreach($products as $product){
				?>
					<img src="<?php $product['name'] ?>">
				<?php	
					}
				?>
				</div>
			</div>


		</div>
	</div>
</body>
</html>
