
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/profil.css">
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

    <div class="recap_profil">
        <h1 class="h1">Votre profil</h1>
        <div class="profil">
            <?php
            //connexion a la bdd

            include("../includes/bdd.php");
            
            $req = $bdd->prepare("SELECT nom, prenom, ville, adresse, email, num_phone, code_postal, droits FROM users WHERE email=:email"); 
            $req->execute([
                'email' => $_SESSION['email']
            ]); 
            $resultat = $req->fetch(PDO::FETCH_ASSOC);

            // affiche tout les elements du profil
            if(isset($resultat)){
                echo '
                <div class="profil1">        
                    <h2 id="nom">Nom : '.$resultat['nom'].'</h2>
                    <h2 id="prenom">Prenom : '.$resultat['prenom'].'</h2>
                    <h2 id="mail">Email : '.$resultat['email'].'</h2>
                </div>
                <div class="profil2">
                    <h2 id="adresse">Adresse : '.$resultat['ville'].', '.$resultat['adresse'].'</h2>
                    <h2 id="date">Code_postal : '.$resultat['code_postal'].'</h2>
                    <h2 id="num_phone">Numeros de Telephone : '.$resultat['num_phone'].'</h2>  
                </div>
                ';

            }

            ?>
            <div class="parametre">
                    <h1><a class="a_article" href="modif_profil.php" id="modif">Modifier</a></h1>
                    <h3><a class="a_article" href="deconnexion.php">Déconnexion</a></h3>
            </div>
        </div>
        <div class="voir_evenement">
            <h1 class="h1">Evenement suivie</h1>
            <h2><a class="a_article" href="voir_mes_evenement.php" id="ajouter">Voir les evenements</a></h2>
            
            <br>
        </div>

        <div class="les_commentairs">
            <h1 class="h1">Commentaire</h1>
            <h2><a class="a_article" href="voir_les_commentair.php" id="voir">Voir touts les commentaires</a></h2>
            <br>
        </div>

        <div class="mes_articles">
            <h1 class="h1">Mes ventes</h1>
            <h2><a class="a_article" href="ajouter_article_utilisateur.php" id="ajouter">Ajouter un article</a></h2>
            <h2><a class="a_article" href="article_utilisateur.php" id="voir">Regarder mes article</a></h2>
            <br>
        </div>
    </div>
    <br>


    <?php
        if($resultat['droits']=='admin' || $resultat['droits']=='SuperAdmin'){
           echo '
                <div class="admin">
                    <h1 class="h1"><a href="admin.php">Page d\'administration</a></h1>
                </div>
                ';
        }
        
    ?>

   
</main>
</body>
</html>