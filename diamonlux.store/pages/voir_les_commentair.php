<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/voir_commentaires.css">
    <title>profil</title>
</head>
<body>
<?php include("../includes/header.php"); ?>
<main>
        <?php 
            if(empty($_SESSION['email'])){
                header('location: index.php');
                exit;
            }
        ?>
        <h1>Commentaires</h1>
        <div class="commentaires">
            <div class="voir-commentaire">
                <h1 class="h1_com">Les commentaires</h1>
                <?php
                    
                    include("../includes/bdd.php");

                    $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
                    $req->execute([
                        'email' => $_SESSION['email']
                    ]); 
                    $resultat = $req->fetch(PDO::FETCH_ASSOC);

                    $reponse2 = $bdd->prepare("SELECT id_utilisateur_commentateur, commentaire FROM commentaire_utilisateur WHERE id_utilisateur_commenter=:id");
                    $reponse2->execute([
                        'id' => $resultat['id']
                    ]); 
                    $resultat2 = $reponse2->fetchAll(PDO::FETCH_ASSOC); 

                    if(empty($resultat2)){
                        echo'
                            <div class="le_com">
                                <p> Personne ne vous a laissé de commentaire</p>
                            </div>
                        ';

                    }else{
                        foreach ($resultat2 as $row) {
                            $req2 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                            $req2->execute([
                                'id' => $row["id_utilisateur_commentateur"]
                            ]); 
                            $resultat3 = $req2->fetch(PDO::FETCH_ASSOC);

                            echo'
                                <div class="le_com">
                                    <h4 class="h4_com"> Par : '. $resultat3["nom"].' '.$resultat3["prenom"] .'</h4>
                                    <p class="le_commentaire">'. $row['commentaire'] .'</p>
                                </div>
                            ';
                        }
                    }
                    
                ?>
            </div>
            <div class="mes_commentaire">
                <h1 class="h1_com">Vos Commentaire</h1>
                <?php
                    include("../includes/bdd.php");

                    $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
                    $req->execute([
                        'email' => $_SESSION['email']
                    ]); 
                    $resultat = $req->fetch(PDO::FETCH_ASSOC);

                    $reponse2 = $bdd->prepare("SELECT id, id_utilisateur_commenter, commentaire FROM commentaire_utilisateur WHERE id_utilisateur_commentateur=:id");
                    $reponse2->execute([
                        'id' => $resultat['id']
                    ]); 
                    $resultat2 = $reponse2->fetchAll(PDO::FETCH_ASSOC); 

                    $reponse3 = $bdd->prepare("SELECT id, id_article, commentaire FROM commentaire_article WHERE id_utilisateur=:id");
                    $reponse3->execute([
                        'id' => $resultat['id']
                    ]); 
                    $resultat3 = $reponse3->fetchAll(PDO::FETCH_ASSOC); 

                    if(empty($resultat2) && empty($resultat3)){
                        echo'
                            <div class="le_com">
                                <p>Vous n\'avais pas  encore mis de commentaire</p>
                            </div>
                        ';

                    }else{

                        foreach ($resultat2 as $row) {
                            $req2 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                            $req2->execute([
                                'id' => $row["id_utilisateur_commenter"]
                            ]); 
                            $resultat4 = $req2->fetch(PDO::FETCH_ASSOC);

                            echo'
                                <div class="le_com">
                                    <h4 class="h4_com"> Pour : '. $resultat4["nom"].' '.$resultat4["prenom"] .'</h4>
                                    <p class="le_commentaire">'. $row['commentaire'] .'</p>
                                    <button class="buttons" id="boutton_voir" onclick=supp_commentaire_utilisateur('. $row['id'] .',1)>Supprimer</button>
                                </div>
                            ';
                        }

                        foreach ($resultat3 as $row) {
                            $req3 = $bdd->prepare("SELECT id, nom FROM article WHERE id=:id"); 
                            $req3->execute([
                                'id' => $row["id_article"]
                            ]); 
                            $resultat5 = $req3->fetch(PDO::FETCH_ASSOC);
                            if(!empty($resultat5)){
                                echo'
                                    <div class="le_com">
                                        <h4 class="h4_com"> Pour l\'article: '. $resultat5["nom"].'</h4>
                                        <p class="le_commentaire">'. $row['commentaire'] .'</p>
                                        <button class="buttons" id="boutton_voir" onclick=supp_commentaire_utilisateur('. $row['id'] .',-1)>Supprimer</button>
                                    </div>
                                ';
                            }
                        }
                    }

                    
                    
                ?>
            
            </div>
        </div>
        <script src="../Java-Script/admin.js"></script>
<main>
<?php include("../includes/footer.php") ?>
<body>
</html>