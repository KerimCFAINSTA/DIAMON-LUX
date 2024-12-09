<?php
    session_start();

    if(!isset($_POST['commentaire'])){	
        $msg = 'Vous devez remplir le champs';
        header('location: voir_article.php?id='. +$row["id"].'&message=' . $msg);
        exit;
    }

    include("../includes/bdd.php");

    $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
    $req->execute([
        'email' => $_SESSION["email"]
    ]); 
    $resultat = $req->fetch(PDO::FETCH_ASSOC);

    

    $commentaire = $_POST['commentaire'];
    $idArticle = $_POST['id_article'];
    $id_utilisateur = $resultat['id'];

    echo $idArticle;

    //ajout dans la bdd
    $q = 'INSERT INTO commentaire_article (id_utilisateur, id_article, commentaire) VALUES (:id_utilisateur, :id_article, :commentaire)';
    $req2 = $bdd->prepare($q); 
    $reponse = $req2->execute([ 
                                'commentaire' => $commentaire, 
                                'id_article' => $idArticle,
                                'id_utilisateur' => $id_utilisateur
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