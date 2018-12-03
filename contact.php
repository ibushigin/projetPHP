<?php
session_start();
require_once('inc/connexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout user</title>
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
	 <div id="map"></div>
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
