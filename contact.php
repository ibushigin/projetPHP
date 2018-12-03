<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

  <?php
	require_once('inc/header.php');
	$select = $connexion -> query('SELECT address FROM address');
	$address = $select -> fetch();
	$map_address = $address['address'];
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address={".urlencode($map_address)."}&key=AIzaSyBjslA2cbupRwG-dJvPAKcfZp0ruzEFM38";

	$resultat = json_decode(file_get_contents($url, false), true);
	//var_dump($resultat);
	$lat = $resultat['results'][0]['geometry']['location']['lat'];
	$lng = $resultat['results'][0]['geometry']['location']['lng'];
	 ?>
	<h2>Adresse</h2>
 	<p>Vous pouvez nous retrouvez au <?=$map_address?></p>
	<div id="map"></div>
	<div name="message">
		<h2>Contactez-nous</h2>
		<form action="">
			<label for="name">Votre nom</label>
			<input type="text" name="name">
			<label for="email">Votre email</label>
			<input type="email" name="email">
			<label for"message">Votre message</label>
			<textarea name="message" rows="8" cols="80"></textarea>
			<button type="submit" name="button">Envoyer</button>
		</form>
	</div>
	 <script>
		 function initMap() {
			 var shop = {lat: <?= $lat ?>,  lng: <?= $lng ?>};
			 var map = new google.maps.Map(document.getElementById('map'), {
				 zoom: 17,
				 center: shop
			 });
			 var marker = new google.maps.Marker({
				 position: shop,
				 map: map
			 });
		 }
	 </script>
<script async defer
					src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0xJoi5c9MwYIYQlwIEfLqLh95hLtcaYA&callback=initMap">
</script>
</body>
</html>
