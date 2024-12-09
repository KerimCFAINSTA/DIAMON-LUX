<?php //session_start() ?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/article.css">
 
    <title>Mes Article</title>
</head>
<?php include("../includes/header.php") ?>
<body>
    <main>
        <?php 
            if(empty($_SESSION['email'])){
                header('location: index.php');
                exit;
            }
        ?>

        <h1>VOS ARTICLE</h1>


        <?php
        //connexion a la bdd
        include("../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, nom FROM users WHERE email=:email"); 
        $req->execute([
            'email' => $_SESSION['email']
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $reponse = $bdd->prepare("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio, image, nb_article FROM article WHERE proprio=:id"); 
        $reponse->execute([
            'id' => $resultat['id']
        ]); 
        $donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);


        if(empty($donnees)){
                echo '
                    <div class="msg_error">
                        <h3>Vous n\'avais pas encore d\'article mis en vente</h3>
                        <h3>Mais vous pouvez toujours en ajouter</h3>
                    </div>
                ';
            }

            echo '<div id="toutLesArticles">
                    <div id="modif">

                    </diV>
            ';
                foreach ($donnees as $row) {
                    $imagePath = 'uploads/' . $row['image'];
                    echo '
                        <div class="article">
                                <div class="img_article">
                                    <img class="img_a" src="'. $imagePath .'" alt="Image Article">
                                    <div class="action">
                                        <button class="buttons" id="boutton_voir" onclick=supp_article_utilisateur('.$row['id'].')>Supprimer</button>
                                        <button class="buttons" id="boutton_modif" onclick=modif_article_utilisateur('.$row['id'].')>Modifier</button>
                                    </div>
                                </div>
                                <div class="description">
                                    <h2 class="h2_article" >'. $row["nom"] .'</h2>
                                    <h3 class="h3_article" >'. $row["marque"] .'</h3>
                                    <h3 class="h3_article" >'. $row["type"] .'</h3>
                                    <h3 class="h3_article" >'. $row["prix"] .' €</h3>
                                    <h4 class="h4_article" >'. $row["secteur"] .'</h4>
                    ';
                                    if($row["nb_article"]>0){
                                        echo '<h4 class="h4_article" >En vente</h4>';
                                    }else{
                                        echo '<h4 class="h4_article" >VENDU</h4>';
                                    }
                                    
                    echo '
                                </div>
                    
                            
                        </div>
                    ';
                }
            echo '</div>';

        ?>  

        
        </div>
    </main>
    <script src="../Java-Script/article_utilisateur.js"></script>
</body>
</html>