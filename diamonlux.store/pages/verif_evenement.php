<?php

if(!isset($_POST['nom']) || !isset($_POST['lieu']) || !isset($_POST['adresse']) || !isset($_POST['date_debut']) || !isset($_POST['date_fin']) || !isset($_POST['heure_debut']) || !isset($_POST['heure_fin']) || !isset($_POST['nb_places']) || !isset($_POST['prix']) || !isset($_POST['description']) || empty($_POST['nom']) || empty($_POST['lieu']) || empty($_POST['adresse']) || empty($_POST['date_debut']) || empty($_POST['date_fin']) || empty($_POST['heure_debut']) || empty($_POST['heure_fin']) || empty($_POST['nb_places']) || empty($_POST['prix']) || empty($_POST['description'])){	
	$msg = 'Vous devez remplir tout les champs';
	header('location: admin.php?message=' . $msg);
	exit;
}

$nom = $_POST['nom'];
$ville = $_POST['lieu'];
$adresse = $_POST['adresse'];

$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];

$heure_debut = $_POST['heure_debut'];
$heure_fin = $_POST['heure_fin'];

$nb_place = $_POST['nb_places'];
$prix = $_POST['prix'];

$Description = $_POST['description'];


// connection a la bdd
include("../includes/bdd.php");

// verifie si l'evenement existe deja 
$q = 'SELECT nom, date_debut FROM evenement WHERE nom = :nom AND date_debut = :date_debut';
$req = $bdd->prepare($q);
$req->execute([
	'nom' => $nom,
	'date_debut' => $date_debut
]);
$results = $req->fetchAll();

if(!empty($results)){
	$msg = 'L\'evenement existe deja';
	header('location: admin.php?message=' . $msg);
	exit;
}

//verifie que la date de debut est plus petite que la date de fin
$test_date_debut = new DateTime($date_debut);
$test_date_fin = new DateTime($date_fin);

if($test_date_debut > $test_date_fin){
    $msg = 'La date de debut doit etre plus recente que la date de fin';
    header('location: admin.php?message=' . $msg);
    exit;
}


$date_actuelle = new DateTime();

if( $test_date_debut < $date_actuelle){
	$msg = 'il y une rerreur dans les dates';
	header('location: admin.php?message=' . $msg);
	exit;
}

//verifie le prix et le nb de places

if($prix < 0){
	$msg = 'Votre prix ne doit pas etres negatif';
	header('location: admin.php?message=' . $msg);
	exit;
}

if($nb_place < 1){
	$msg = 'Il doit y avoir au moins un participant sinon ce n\'est pas drole';
	header('location: admin.php?message=' . $msg);
	exit;
}


//ajout dans la bdd
$q = "INSERT INTO evenement (nom, date_debut, date_fin, description, Ville, prix, nb_place, heure_debut, heure_fin, adresse) 
      VALUES (:nom, :date_debut, :date_fin, :description, :Ville, :prix, :nb_place, :heure_debut, :heure_fin, :adresse)";
$req = $bdd->prepare($q); 
$reponse = $req->execute([ 
        'nom' => $nom,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'description' => $Description,
        'Ville' => $ville,
        'prix' => $prix,
        'nb_place' => $nb_place,
        'heure_debut' => $heure_debut,
        'heure_fin' => $heure_fin,
        'adresse' => $adresse
    ]);

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
		header ('location: inscription.php?message=Type d\'image incorrect.&type=danger');
		exit;
	}
	
	// Vérifier que le fichier n'est pas trop lourd
	$maxSize = 5 * 1024 * 1024; // 2Mo
	// Si la taille du fichier est supérieure au max autorisé : redirection vers le formaulaire
	if($_FILES['image']['size'] > $maxSize){
		header('location: inscription.php?message=L\'image ne doit pas dépasser 2Mo&type=danger');
		exit;
	}
	
	// Si le dossier uploads n'existe pas, le créer
	$path = 'uploads';
	if(!file_exists($path)){
		mkdir($path, 0777); // chmod 777
	}

	// Enregistrer le fichier sur le serveur
	$filename = $_FILES['image']['name'];

	$array = explode('.', $filename); // découper le nom selon les points
	$extension = end($array); // récupérer le dernier élément du tableau

	$filename = 'image-' . time() . '.' . $extension;

	$destination = $path . '/' . $filename;
	move_uploaded_file($_FILES['image']['tmp_name'], $destination);

	$q = 'UPDATE evenement SET image = :image WHERE nom = :nom AND date_debut = :date_debut';
	$req = $bdd->prepare($q); 
	$reponse = $req->execute([ 
		'image' =>  isset($filename) ? $filename : '',
		'nom' => $nom,
		'date_debut' => $date_debut
	]);
}



if(!$reponse){
	$msg = 'Erreur lors de l\'enregistrement.';
	header('location: admin.php?message=' . $msg);
	exit;
}
else{
	$msg = 'Evenement créé avec succès !!';
	header('location: admin.php?message=' . $msg);
	exit;
}

?>