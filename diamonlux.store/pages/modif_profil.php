<?php //session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../css/modif_profil.css">

    <title>Modifier votre profil</title>
</head>
<body>
<?php include("../includes/header.php") ?>
<main>
        <?php 
            if(empty($_SESSION['email'])){
                header('location: index.php');
                exit;
            }
        ?>
    <div class="recap_profil">
        <h1 class="h1_profil">Modifier votre profil</h1>
        <form id="recherche" action="verif_modif_profil.php" method="post">
            <div class="profil">
                <?php
                include("../includes/bdd.php");
                
                $req = $bdd->prepare("SELECT nom, prenom, ville, adresse, email, num_phone, code_postal, droits FROM users WHERE email=:email"); 
                $req->execute([
                    'email' => $_SESSION['email']
                ]); 
                $resultat = $req->fetch(PDO::FETCH_ASSOC);

                //affiche chaque ellement du profil avec un input pour changer un au plusieurs elements
                if(isset($resultat)){
                    echo '
                    
                        <div class="profil1">        
                            <h1 class="nom_prenom" id="nom" onclick="modif(1)">Nom : '.$resultat['nom'].'</h2> 
                                <input id="input-1" type="text" name="nom" placeholder="'.$resultat['nom'].'">
                            <h1 class="nom_prenom" id="prenom" onclick="modif(2)">Prenom : '.$resultat['prenom'].'</h2> 
                                <input id="input-2" type="text" name="prenom" placeholder="'.$resultat['prenom'].'">

                        </div>
                        <div class="profil2">
                            <h2 class="h2_profil" id="adresse" onclick="modif(3)">Adresse : '.$resultat['ville'].', '.$resultat['adresse'].'</h2> 
                                <div id="input-3" style="display: none;">
                                    <input type="text" name="ville" placeholder="'.$resultat['ville'].'"> 
                                    <input type="text" name="adresse" placeholder="'.$resultat['adresse'].'">
                                </div>
                            <h2 class="h2_profil" id="date" onclick="modif(5)">Code postal : '.$resultat['code_postal'].'</h2>
                                <input class="input_profil" id="input-5" type="text" name="code_postal" placeholder="'.$resultat['code_postal'].'">
                            <h2 class="h2_profil" id="num_phone" onclick="modif(4)">Numeros de Telephone : '.$resultat['num_phone'].'</h2>
                                <input id="input-4" type="text" name="num_phone" placeholder="'.$resultat['num_phone'].'">
                        </div>
                    
                    ';

                }

                ?>
                
                <input id="valid" type="submit" value="Valider">
            </div>
        </form>
    </div>
    <script src="../Java-Script/modif_profil.js"></script>
</main>
</body>
</html>