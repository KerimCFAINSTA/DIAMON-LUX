<?php
include("../includes/bdd.php");
// Vérifie que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie que tous les champs ont été remplis
    if (empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["ville"]) || empty($_POST["adresse"]) || empty($_POST["email"]) || empty($_POST["num_phone"]) || empty($_POST["password1"]) || empty($_POST["password2"]) || empty($_POST["code_postal"])) {
        $msg = "Tous les champs sont obligatoires.";
        header("Location: inscription.php?message= ". $msg);
        exit();
    } else {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];

        $ville = $_POST["ville"];
        $adresse = $_POST["adresse"];

        $email = $_POST["email"];
        $num_phone = $_POST["num_phone"];
		$code_postal = $_POST["code_postal"];

        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        $image = $_FILES["image"];
	}

	// Vérifie que l'email n'est pas déjà utilisé
	$sql = "SELECT * FROM users WHERE email = :email";
	$stmt = $bdd->prepare($sql);
	$stmt->execute(['email' => $email]);
	$user = $stmt->fetch();
	if ($user) {
		$msg = "Cet email est déjà utilisé.";
		header("Location: inscription.php?message= ". $msg);
		exit();
    } 

	// Vérifie que le mot de passe contient au moins 8 caractères dont une majuscule, une minuscule et un chiffre
	if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/', $password1)) {
	} else {
		$msg = "Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule et un chiffre.";
		header("Location: inscription.php?message= ". $msg);
		exit();
		
	}
	if($password1!=$password2){
		$msg = "Les mots de passe sont differents";
		header("Location: inscription.php?message= ". $msg);
		exit();
		
	}
            

	if($_FILES['image']['error'] != 4){

		// Vérifier que le fichier est du bon type
		$acceptable = [
						'image/jpeg',
						'image/gif',
						'image/png'
					];
		// Si le type de fichier n'est pas dans le tableau $acceptable : redirection vers le formaulaire avec une erreur.
		if(!in_array($_FILES['image']['type'], $acceptable)){
			header ('location: connexion.php?message=Type d\'image incorrect.&type=danger');
			exit;
		}
		
		// Vérifier que le fichier n'est pas trop lourd
		$maxSize = 2 * 1024 * 1024; // 2Mo
		// Si la taille du fichier est supérieure au max autorisé : redirection vers le formaulaire
		if($_FILES['image']['size'] > $maxSize){
			header('location: connexion.php?message=L\'image ne doit pas dépasser 2Mo&type=danger');
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

	$sql = "INSERT INTO users (nom, prenom, ville, adresse, password, email, num_phone, code_postal, image) VALUES (:nom, :prenom, :ville, :adresse, :password, :email, :num_phone, :code_postal, :image)";
	$stmt = $bdd->prepare($sql);
	$stmt->execute([
		'nom' => $nom,
		'prenom' => $prenom,
		'ville' => $ville,
		'adresse' => $adresse,
		'email' => $email,
		'num_phone' => $num_phone,
		'password' => $password1,
		'code_postal' => $code_postal,
		'image' => isset($filename) ? $filename : ''
	]);
	$msg = "Compte creer avec succès";
	header("Location: connexion.php?message= ". $msg);
	exit();
}
?>