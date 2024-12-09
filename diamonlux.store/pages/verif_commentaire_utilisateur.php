<?php
    session_start();

    if(!isset($_POST['commentaire'])){	
        $msg = 'Vous devez remplir le champs';
        header('location: voir_article.php?id='. +$idArticle["id"].'&message=' . $msg);
        exit;
    }

    include("../includes/bdd.php");

    $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
    $req->execute([
        'email' => $_SESSION["email"]
    ]); 
    $resultat = $req->fetch(PDO::FETCH_ASSOC);

    $idArticle = $_POST['id_article'];

    
    $id_utilisateur_commentateur  = $resultat['id'];
    $id_utilisateur_commenter = $_POST['id_utilisateur_commenter'];
    $commentaire = $_POST['commentaire'];

    echo $idArticle;

    //ajout dans la bdd
    $q = 'INSERT INTO commentaire_utilisateur (id_utilisateur_commentateur, id_utilisateur_commenter, commentaire) VALUES (:id_utilisateur_commentateur, :id_utilisateur_commenter, :commentaire)';
    $req2 = $bdd->prepare($q); 
    $reponse = $req2->execute([ 
                                'commentaire' => $commentaire, 
                                'id_utilisateur_commentateur' => $id_utilisateur_commentateur,
                                'id_utilisateur_commenter' => $id_utilisateur_commenter
                            ]);

    if(!$reponse){
        $msg = 'Erreur lors de l\'enregistrement.';
        header('location: voir_article.php?id='. +$idArticle.'&message=' . $msg);
        exit;
    }
    else{
        $msg = 'Commentaire créé avec succès !!';
        header('location: voir_article.php?id='. +$idArticle.'&message=' . $msg);
        exit;
    }

?>