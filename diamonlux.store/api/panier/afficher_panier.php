<?php

if(isset($_GET['idU'])) {

    $idU = $_GET['idU'];

    include("../../includes/bdd.php");

    $req = $bdd->prepare("SELECT id_article FROM panier WHERE id_utilisateur =:id_utilisateur "); 
    $req->execute([
        'id_utilisateur' => $idU
    ]);
    $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($resultat2)) {
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
        
    }else{
        echo '
            <div class="msg_error">
                <h3>Votre panier est vide !!</h3>
            </div>
        ';
    }   
    

}


?>