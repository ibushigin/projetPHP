<?php
try
{			
    $connexion = new PDO('mysql:host=localhost;dbname=shop_project;charset=utf8', 'root', '',array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
                  );
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
