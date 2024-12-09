<?php
    session_start();

    // Connexion à la BDD
    include("../includes/bdd.php");
    
    //verifie pour chaque champs si il est modifié si oui modifie la valeur dans la bdd
    if(isset($_POST['nom']) && !empty($_POST['nom'])) {
        $q = 'UPDATE users SET nom = :nom WHERE email=:email'; 
        $req = $bdd->prepare($q); 
        $reponse = $req->execute([ 
            'nom' => $_POST['nom'], 
            'email' => $_SESSION['email']
        ]);
    }

    if(isset($_POST['prenom']) && !empty($_POST['prenom'])) {
        $q = 'UPDATE users SET prenom = :prenom WHERE email=:email'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'email' => $_SESSION['email'],
                'prenom' => $_POST['prenom']
            ]); 
    }
   
    if(isset($_POST['ville']) && !empty($_POST['ville'])) {
        $q = 'UPDATE users SET ville = :ville WHERE email=:email'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'ville' => $_POST['ville'], 
                'email' => $_SESSION['email']
            ]); 
    }

    if(isset($_POST['adresse']) && !empty($_POST['adresse'])) {
        $q = 'UPDATE users SET adresse = :adresse WHERE email=:email'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'adresse' => $_POST['adresse'], 
                'email' => $_SESSION['email']
            ]); 
    }

    if(isset($_POST['num_phone']) && !empty($_POST['num_phone'])) {
        $q = 'UPDATE users SET num_phone = :num_phone WHERE email=:email'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'num_phone' => $_POST['num_phone'], 
                'email' => $_SESSION['email']
            ]); 
    }

    if(isset($_POST['code_postal']) && !empty($_POST['code_postal'])) {
        $q = 'UPDATE users SET code_postal = :code_postal WHERE email=:email'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            'code_postal' => $_POST['code_postal'], 
            'email' => $_SESSION['email']
        ]); 
    }

    // Renvoie vers la page du profil si tout a ete changé avec succes
    $msg = 'Profil modifie avec succès !!';
	header('location: profil.php?message=' . $msg);
	exit;

?>