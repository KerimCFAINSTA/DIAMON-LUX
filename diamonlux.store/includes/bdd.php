<?php


// Connexion à la base de données
try{
	$bdd = new PDO('mysql:host=localhost;dbname=diamonlux', 'root', ''); 
}
catch(Exeption $e){
	die('Erreur: ' . $e->getMessage());
}
?> 
