<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/voir_article.css">
    <title>Article</title>
</head>
<body>
    <?php include("../includes/header.php") ?>
    <main>
        <h1 class="h1_article">Article</h1>

        <div class="tout_article">
        <?php
            include("../includes/bdd.php");

            if(!empty($_SESSION['email'])){

                $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
                $req->execute([
                    'email' => $_SESSION["email"]
                ]); 
                $resultat3 = $req->fetch(PDO::FETCH_ASSOC);

            }
        
            $reponse = $bdd->prepare("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image FROM article WHERE id=:id");
            $reponse->execute([
                'id' => $_GET['id']
            ]); 
            $resultat = $reponse->fetch(PDO::FETCH_ASSOC);  
            
            $req2 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
            $req2->execute([
                'id' => $resultat["proprio"]
            ]); 
            $resultat2 = $req2->fetch(PDO::FETCH_ASSOC);



            $imagePath = 'uploads/' . $resultat['image'];
            echo '
                <div class="article">
                    <div class="img_article">
                        <img class="img_a" src="'. $imagePath .'" alt="Image Article">
                    </div>
                    <div class="description">
                        <h2 class="h2_article">'. $resultat["nom"] .'</h2>
                        <h3 class="h3_article">'. $resultat["marque"] .'</h3>
                        <h3 class="h3_article">'. $resultat["type"] .'</h3>
            ';
            if($resultat["proprio"] == -1){
                echo' <h4 class="h4_article">Vendu par : DiamonLux</h4> ';
            }else{
                echo' <h4 class="h4_article">Vendu par : '. $resultat2["nom"].' '.$resultat2["prenom"] .'</h4> 
                ';
            }
                echo '<h3 class="h3_article">'. $resultat["prix"] .' €</h3>';
            echo'
                </div>  
                </div>
                <div class="prix">
                    
                </div>
            ';
            echo'
                <div class="achat">
                    <h4 class="h4_article">'. $resultat["secteur"] .'</h4>';
                    if(empty($_SESSION['email'])){
                        echo' <h2>Vous devez etres connecté pour acheter un article ';
                    }else{
                        echo' <button class="bouttons" id="boutton_rejoindre" onclick=ajouter_panier('. $resultat["id"] .','. $resultat3["id"] .')>ACHETER</button> ';
                    }
                    echo'
                    <div id="validation">

                    </div>

                </div>
            </div>
            ';
        ?>
        </div>
        
        <div class="commentaires">
            <div class="voir-commentaire">
                <h1 class="h1_com">Tout les commentaire</h1>
                <?php
                if($resultat["proprio"] == -1){
                        $reponse5 = $bdd->prepare("SELECT id_utilisateur, commentaire FROM commentaire_article WHERE id_article=:id");
                        $reponse5->execute([
                            'id' =>  $_GET['id']
                        ]); 
                        $resultat5 = $reponse5->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($resultat5 as $row) {

                            $req6 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                            $req6->execute([
                                'id' => $row["id_utilisateur"]
                            ]); 
                            $resultat6 = $req6->fetch(PDO::FETCH_ASSOC);

                            echo'
                                <div class="le_com">
                                    <h4 class="h4_com"> Par : '. $resultat6["nom"].' '.$resultat6["prenom"] .'</h4>
                                    <p class="le_commentaire">'. $row['commentaire'] .'<p>
                                </div>
                            ';
                        }
                    }else{
                        $reponse5 = $bdd->prepare("SELECT id_utilisateur_commentateur, commentaire FROM commentaire_utilisateur WHERE id_utilisateur_commenter=:id");
                        $reponse5->execute([
                            'id' => $resultat['proprio']
                        ]); 
                        $resultat5 = $reponse5->fetchAll(PDO::FETCH_ASSOC); 
                        foreach ($resultat5 as $row) {

                            $req6 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                            $req6->execute([
                                'id' => $row["id_utilisateur_commentateur"]
                            ]); 
                            $resultat6 = $req6->fetch(PDO::FETCH_ASSOC);

                            echo'
                                <div class="le_com">
                                    <h4 class="h4_com"> Par : '. $resultat6["nom"].' '.$resultat6["prenom"] .'</h4>
                                    <p class="le_commentaire">'. $row['commentaire'] .'<p>
                                </div>
                            ';
                        }
                    }
                ?>    
            </div>
            <div class="add_commentaire">
                <?php
                  if(empty($_SESSION['email'])){
                    
                      echo' 
                        <h1 class="h1_com">Laisser un commentaire.</h1>
                        <h2>Vous devez etres connecté pour laisser un commentaire</h2>
                      ';
                      
                  }else{
                      if($resultat["proprio"] == -1){
                          echo'
                              <h1 class="h1_com">Laisser un commentaire.<br>Pour l\'article</h1>
                              <div class="form_com">
                                  <form action="verif_commentaire_article.php" method="POST">
                                      <input class="input_com" type="text" name="commentaire" placeholder="Votre commentaire">
                                      <input type="hidden" name="id_article" value="'.$resultat['id'].'">
                                      <input class="valider_com" type="submit" value="Envoyer">
                                  </form>
                              </div>
                          ';
                      }else{
                          echo'
                              <h1 class="h1_com">Laisser un commentaire.<br>Pour '. $resultat2["nom"].' '.$resultat2["prenom"] .'</h1>
                              <div class="form_com">
                                  <form action="verif_commentaire_utilisateur.php" method="POST">
                                      <input class="input_com" type="text" name="commentaire" placeholder="Votre commentaire">
                                      <input type="hidden" name="id_utilisateur_commenter" value="'.$resultat['proprio'].'">
                                      <input type="hidden" name="id_article" value="'.$resultat['id'].'">
                                      <input class="valider_com" type="submit" value="Envoyer">
                                  </form>
                              </div>
                          ';
                      }
                  }
                ?>
            </div>
        </div>


    <script src="../Java-Script/admin.js"></script>
</main>
<?php include("../includes/footer.php") ?>
</body>
</html>