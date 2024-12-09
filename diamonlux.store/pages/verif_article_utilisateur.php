<?php 
session_start();

//verifie que les champs sont completé
if(!isset($_POST['nom']) || !isset($_POST['type']) || !isset($_POST['marque']) || !isset($_POST['prix']) || !isset($_POST['secteur'])){	
	$msg = 'Vous devez remplir tout les champs';
	header('location: ajouter_article_utilisateur.php?message=' . $msg);
	exit;
}

if( $_POST['prix'] <= 0){
	$msg = 'Vous devez mettre un prix supperieur a 0';
	header('location: admin.php?message=' . $msg);
	exit;
}

// connection a la bdd
include("../includes/bdd.php");


// verifie si l'article existe deja 
$q = 'SELECT nom FROM article WHERE nom = :nom';
$req = $bdd->prepare($q);
$req->execute(['nom' => $_POST['nom']]);

$results = $req->fetchAll();

if(!empty($results)){
	$msg = 'L\'article existe deja';
	header('location: ajouter_article_utilisateur.php?message=' . $msg);
	exit;
}

// Pour l'image
// Si un fichier a été envoyé
if($_FILES['image']['error'] != 4){

	// Vérifier que le fichier est du bon type
	$acceptable = [
					'image/jpeg',
					'image/gif',
					'image/png'
				];
	// Si le type de fichier n'est pas dans le tableau $acceptable : redirection vers le formaulaire avec une erreur.
	if(!in_array($_FILES['image']['type'], $acceptable)){
		header ('location: add_pokemon.php?message=Type d\'image incorrect.&type=danger');
		exit;
	}
	
	// Vérifier que le fichier n'est pas trop lourd
	$maxSize = 2 * 1024 * 1024; // 2Mo
	// Si la taille du fichier est supérieure au max autorisé : redirection vers le formaulaire
	if($_FILES['image']['size'] > $maxSize){
		header('location: add_pokemon.php?message=L\'image ne doit pas dépasser 2Mo&type=danger');
		exit;
	}
	
	// Si le dossier uploads n'existe pas, le créer
	$path = 'uploads';
	if(!file_exists($path)){
		mkdir($path, 0777);
	}

	// Enregistrer le fichier sur le serveur
	$filename = $_FILES['image']['name'];

	$array = explode('.', $filename); // découper le nom selon les points
	$extension = end($array); 

	$filename = 'image-' . time() . '.' . $extension;

	$destination = $path . '/' . $filename;
	move_uploaded_file($_FILES['image']['tmp_name'], $destination);

}



// Ajout des elements
$req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
$req->execute([
	'email' => $_SESSION['email']
]); 
$resultat = $req->fetch(PDO::FETCH_ASSOC);

$q = 'INSERT INTO article (nom, marque, type, prix, date_vente, secteur, proprio, image ) VALUES (:nom, :marque, :type, :prix, NOW(), :secteur, :proprio, :image)';
$req2 = $bdd->prepare($q); 
$reponse = $req2->execute([ 
	'nom' => $_POST['nom'], 
	'marque' => $_POST['marque'],
    'type' => $_POST['type'],
	'prix' => $_POST['prix'],
	'secteur' =>  $_POST['secteur'],
    'proprio' => $resultat['id'],
	'image' =>  isset($filename) ? $filename : ''
]);

if(!$reponse){
    $msg = 'Erreur lors de l\'enregistrement.';
    header('location: ajouter_article_utilisateur.php?message=' . $msg);
    exit;
}
else{
    $msg = 'Article créé avec succès !!';
    header('location: ajouter_article_utilisateur.php?message=' . $msg);
    exit;
}

?>