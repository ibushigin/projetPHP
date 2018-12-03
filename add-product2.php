<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add - modify product</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
	<?php require_once('inc/header.php');

if(!empty($_SESSION['role']) && ($_SESSION['role'] == 'ROLE_ADMIN' || $_SESSION['role'] == 'ROLE_VENDOR')) {

	$select = $connexion->query('SELECT label, id FROM category');
	$labels = $select->fetchAll();

	?>

<div class="container">
    <div class="row">

    	<!-- AJOUTER UN PRODUIT -->
        <div class="col-md-6">
    		<h2>Ajouter un produit</h2>
			<form action="add-product.php" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label>Nom</label>
					<input type="text" name="nom">
				</div>
				<div class="form-group">
					<label>Prix en euros</label>
					<input type="text" name="prix">
				</div>
				<div class="form-group">
					<label>Catégorie</label>
					<select name="categorie">
						<option value="0">Choisissez une catégorie</option>
						<?php
						foreach ($labels as $label) {
							?>
							<option value="<?= $label['id'] ?>"><?= $label['label'] ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Disponibilité</label>
					<select name="dispo">
						<option value="0">Produit dispo ?</option>
						<option value="oui">oui</option>
						<option value="non">non</option>
					</select>
				</div>
				<div class="form-group">
					<label>Photo</label>
					<input type="file" name="photo">
				</div>
				<button type="submit" class="btn btn-info" name="btnAdd">Ajouter ce produit</button>
			</form>
		</div>


	<?php


	if (!empty($_FILES) && !empty($_POST)) {

		if (isset($_POST['btnAdd'])) {

			$post = [];
			foreach ($_POST as $key => $value) {
				$post[$key] = strip_tags(trim($value));
			}

			$errors = [];
			if (empty($post['nom'])) {
				$errors[] = 'Nom de produit invalide';
			}
			if (empty($post['prix']) || !preg_match('#^\d+$#', $post['prix'])) {
				$errors[] = 'Prix invalide';
			}
			if (empty($post['categorie']) || !preg_match('#^\w+$#', $post['categorie'])) {
				$errors[] = 'Catégorie invalide';
			}
			if (empty($post['dispo']) || ($post['dispo'] !== 'oui' && $post['dispo'] !== 'non')) {
				$errors[] = 'Disponibilité invalide';
			}


			if (empty($errors)) {

				//var_dump($post['dispo']);

				$insert = $connexion->prepare('INSERT INTO products (name, price, category, availability, date_create) VALUES (:name, :price, :category, :availability, :date_create)');
				$insert->bindValue(':name', $post['nom']);
				$insert->bindValue(':price', $post['prix']);
				$insert->bindValue(':category', $post['categorie']);
				$insert->bindValue(':availability', $post['dispo']);
				$insert->bindValue(':date_create', date('Y-m-d'));

				if ($insert->execute()) {

					$idProduct = $connexion->lastInsertId();

					echo 'produit ajouté !';

					if ($_FILES['photo']['error'] == 0) {

						$maxSize = 500 * 1024;

						if ($_FILES['photo']['size'] <= $maxSize) {

							$fileInfo = pathinfo($_FILES['photo']['name']);
							$extension = strtolower($fileInfo['extension']);
							$extensionsAutorisees = ['jpg', 'jpeg', 'png', 'svg', 'gif'];

							if (in_array($extension, $extensionsAutorisees)) {

								$newName = md5(uniqid(rand(), true));
								//echo $newName;
								// création miniatures
								$newWidth = 100;
								if ($extension === 'jpg' || $extension === 'jpeg') {
									$newImage = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
								}
								elseif ($extension === 'png') {
									$newImage = imagecreatefrompng($_FILES['photo']['tmp_name']);
								}
								elseif ($extension === 'gif') {
									$newImage = imagecreatefromgif($_FILES['photo']['tmp_name']);
								}
								$oldWidth = imagesx($newImage);
								$oldHeight = imagesy($newImage);
								$newHeight = ($oldHeight * $newWidth) / $oldWidth;

								$miniature = imagecreatetruecolor($newWidth, $newHeight);

								imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

								$folder = 'files/thumbnails/';

								if ($extension === 'jpg' || $extension === 'jpeg') {
									imagejpeg($miniature, $folder . $newName . '.' . $extension);
								}
								elseif ($extension === 'png') {
									imagepng($miniature, $folder . $newName . '.' . $extension);
								}
								elseif ($extension === 'gif') {
									imagegif($miniature, $folder . $newName . '.' . $extension);
								}
								move_uploaded_file($_FILES['photo']['tmp_name'], 'files/' . $newName . '.' . $extension);

								$insert = $connexion->query("INSERT INTO pictures (file_name, id_product) VALUES ('$newName.$extension', '".$idProduct."')");

								if ($insert) {
									echo 'photo ajoutée !';
								}
								else {
									echo 'problème d\'ajout photo';
								}
							}
						}

					}

				}
				else {
					echo 'problème d\'ajout produit';
				}


			}

			else {
				echo implode('<br>', $errors);
			}

		}

	}

	?>



		<!-- MOFIIER UN PRODUIT -->
	    <div class="col-md-6">
    		<h2>Modifier un produit</h2>
			<form action="add-product.php" method="GET">
			<label>Choisir le produit à modifier</label>
				<select name="idProduct">
					<option value="0"></option>
					<?php
					$select = $connexion->query('SELECT * FROM products');
					$products = $select->fetchAll();
					foreach ($products as $product) {
						?>
						<option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
						<?php
					}
					?>
				</select>
				<button type="submit">Choisir ce produit</button>
			</form>

			<?php

			if (!empty($_GET) && preg_match('#^\d+$#', $_GET['idProduct'])) {

				$select = $connexion->prepare('SELECT * FROM products WHERE id = :id');
				$select->bindValue(':id', strip_tags($_GET['idProduct']));
				$select->execute();
				$product = $select->fetchAll();
				?>

				<form action="add-product.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nom</label>
						<input type="text" name="nvNom" placeholder="<?= $product[0]['name'] ?>">
					</div>
					<div class="form-group">
						<label>Prix en euros</label>
						<input type="text" name="nvPrix" placeholder="<?= $product[0]['price'] ?>">
					</div>
					<div class="form-group">
						<label>Catégorie</label>
						<select name="nvCategorie">
							<option value="0">Choisissez une catégorie</option>
							<?php
							foreach ($labels as $label) {
								?>
								<option value="<?= $label['id'] ?>"><?= $label['label'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Disponibilité</label>
						<select name="nvDispo">
							<option value="0">Produit dispo ?</option>
							<option value="oui">oui</option>
							<option value="non">non</option>
						</select>
					</div>
					<div class="form-group">
						<label>Photo</label>
						<input type="file" name="nvPhoto">
					</div>
					<input type="hidden" name="idProduct" value="<?= $_GET['idProduct'] ?>">
					<button type="submit" class="btn btn-info" name="btnModif">Modifier ce produit</button>
				</form>
				<?php

			}


				if (!empty($_FILES) && !empty($_POST)) {


					if (isset($_POST['btnModif'])) {

						$post = [];
						foreach ($_POST as $key => $value) {
							$post[$key] = strip_tags(trim($value));
						}

						$errors = [];
						if (empty($post['nvNom'])) {
							$errors[] = 'Nouveau nom invalide';
						}
						if (empty($post['nvPrix']) || !preg_match('#^\d+$#', $post['nvPrix'])) {
							$errors[] = 'Nouveau prix invalide';
						}
						if (empty($post['nvCategorie']) || !preg_match('#^\d+$#', $post['nvCategorie'])) {
							$errors[] = 'Nouvelle catégorie invalide';
						}
						if (empty($post['nvDispo']) || ($post['nvDispo'] !== 'oui' && $post['nvDispo'] !== 'non')) {
							$errors[] = 'Nouvelle disponibilité invalide';
						}


						if (empty($errors)) {

							$update = $connexion->prepare('UPDATE products SET name = :name, price = :price, category = :category, availability = :availability, date_create = :date_create WHERE id = :id');
							$update->bindValue(':name', $post['nvNom']);
							$update->bindValue(':price', $post['nvPrix']);
							$update->bindValue(':category', $post['nvCategorie']);
							$update->bindValue(':availability', $post['nvDispo']);
							$update->bindValue(':date_create', date('Y-m-d'));
							$update->bindValue(':id', $post['idProduct']);
							if ($update->execute()) {
								echo 'Le produit a été modifié';
							}
							else {
								echo 'Problème de modification';
							}
						}

						else {
							echo implode ('<br>', $errors);
						}




					}

				}

			?>
		</div>

	</div>


<?php

}
else {
	echo 'Vous devez être connecté ou avoir les droits pour accéder à cette page';
}
?>









</body>
</html>
