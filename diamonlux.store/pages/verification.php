<?php 

	error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  
	function writeLogLine($success, $email){
		$log = fopen('log.txt', 'a+');
		$value = $success ? 'réussie' : 'échouée';
		$line = date('Y-m-d H:i:s') . ' - Tentative de connexion ' . $value . ' de ' . $email . "\n";
		fputs($log, $line);
		fclose($log);
	}

	//$_POST['email']
	//$_POST['password']
	
	// Si le parametre email existe et n'est pas vide : créer un cookie email
	if(isset($_POST['email']) && !empty($_POST['email'])){
		setcookie('email', $_POST['email'], time() + 24 * 60 * 60);
	}

	// Si email vide ou password vide : redirection vers le formulaire avec un message
	if(empty($_POST['email']) || empty($_POST['password'])){
		header('location: connexion.php?message=Vous devez remplir les 2 champs.&type=danger');
		exit;
	}

	// Si l'email n'est pas valide : redirection vers le formulaire avec un message
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		header('location: connexion.php?message=Email invalide.&type=danger');
		exit;
	}
	
	include('../includes/bdd.php');

	$q = 'SELECT id, Statut FROM users WHERE email = :email AND password = :password';
	$req = $bdd->prepare($q);
	$req->execute([
					'email' => $_POST['email'],
					'password' => $_POST['password']
				]);
	$results = $req->fetch();
 
  
 

	// Si le tableau de résultats est vide : redirection vers le formulaire avec un message
	if(($results) == 0){

		writeLogLine(false, $_POST['email']);

		header('location: connexion.php?message=Identifiants incorrects&type=danger');
		exit;
	}
 
 if($results['Statut']=="ban"){
 
   writeLogLine(false, $_POST['email']);

	header('location: connexion.php?message=Vous ne pouvez pas vous connecter');
	exit;
 
 }


	// Ecriture dans le fichier log
	writeLogLine(true, $_POST['email']);

	// Ouverture d'une session utilisateur et enregistrement de l'email
	session_start();
	$_SESSION['email'] = $_POST['email'];

	// Redirection vers la page d'accueil
	header('location: ../index.php');
	exit;
?>
