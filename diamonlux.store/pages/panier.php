<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/panier.css">
    <title>Panier</title>
</head>
<body>
<?php include("../includes/header.php") ?>
    <main> 
    <h1 class="h1_panier">Votre Paniers</h1>
        <div class="panier">
        <?php
            
            include("../includes/bdd.php");

            $nb_article = 0;

            $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
            $req->execute([
                'email' => $_SESSION['email']
            ]);
            $resultat = $req->fetch(PDO::FETCH_ASSOC);

           

            $req2 = $bdd->prepare("SELECT id_article FROM panier WHERE id_utilisateur =:id_utilisateur "); 
            $req2->execute([
                'id_utilisateur' => $resultat['id']
            ]);
            $resultat2 = $req2->fetchAll(PDO::FETCH_ASSOC);
            
           

            if (!empty($resultat2)) {
                echo '<div id="msg"> </div>';
                echo '<div id="articles">';
                foreach ($resultat2 as $row) {

                    $req3 = $bdd->prepare("SELECT id, nom, type, marque, prix , proprio, secteur, image FROM article WHERE id=:id"); 
                    $req3->execute([
                        'id' => $row['id_article']
                    ]);
                    $resultat3 = $req3->fetch(PDO::FETCH_ASSOC);

                    $imagePath = 'uploads/' . $resultat3['image'];
                    echo'  
                        <div class="un_article">
                            <div class="info">
                                <div class="img_panier">
                                    <img class="img_p" src="'. $imagePath .'" alt="Image Article">
                                </div>
                                <div class="description">
                                    <h3>'. $resultat3["nom"] .'</h3>
                                    <p>'. $resultat3["type"] .'<p>
                                </div>
                                <div class="description">
                                    <p>'. $resultat3["prix"] .'€<p>
                                    <p>'. $resultat3["marque"] .'<p>
                                </div>
                                <div class="lien">';
                                if($resultat3["proprio"] == -1){
                                    echo' <p> Vendu par DiamonLux <p> ';
                                }else{
                                    $req4 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                                    $req4->execute([
                                        'id' => $resultat3["proprio"]
                                    ]); 
                                    $resultat4 = $req4->fetch(PDO::FETCH_ASSOC);
                                    
                                    echo' <p> Vendu par '. $resultat4["nom"].' '.$resultat4["prenom"] .'</p> ';
                                }
                                echo' 
                                    <h4>'. $resultat3["secteur"] .'</h4>
                                    
                                </div>
                            </div>
                            <div class="action">
                                    <button class="buttons" ><a class="consulter" href="voir_article.php?id='. +$resultat3["id"].' " >Consulter</a></button>
                                    <button class="buttons" id="boutton_voir" onclick=supp_article('. $resultat3['id'] .','.$resultat['id'].')>Supprimer</button>
                            </div>
                        </div>
                        
                    ';
                    $nb_article = $nb_article + 1;
                }
                echo '</div>';
            }else{
                echo '
                    <div class="msg_error">
                        <h3>Votre panier est vide !!</h3>
                    </div>
                ';
            }   
        ?>
            <div class="payment">
                <h1 class="h1_panier">Payment</h1>
                <?php
                    echo' 
                        <p class="nb_article">Vous avez actuelement '.$nb_article.' article dans votre panier</p>
                
                        <button class="button_payer" onclick=payer_panier('.$resultat['id'].')>PAYER</button>
                    ';
                ?>
            </div>
            
        </div>
        <script src="../Java-Script/panier.js"></script>
    </main>
</body>
</html>