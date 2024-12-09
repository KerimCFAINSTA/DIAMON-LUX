<?php

if(isset($_GET['name'])) {

    $name = $_GET['name'];

    
    include("../../includes/bdd.php");

    $reponse = $bdd->prepare("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio, image, nb_article, etat, couleur FROM article WHERE nom LIKE ?");
    $reponse->execute(array("%$name%"));
    $donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

    if(empty($donnees)){
        echo '
            <div class="msg_error">
                <h3>Les articles que vous recherchez n\'existent pas encore</h3>
                <h3>Mais vous pouvez toujours changer les filtres choisis</h3>
            </div>
        ';
    }

    foreach ($donnees as $row) {
        if($row['nb_article'] > 0){
            $imagePath = 'uploads/' . $row['image'];
            echo '
                <div class="article">
                    <div class="img_article">
                        <img class="img_a" src="'. $imagePath .'" alt="Image Article">
                    </div>
                    <div class="description">
                        <h2 class="h2_article">'. $row["nom"] .'</h2>
                        <div style="display: flex; align-items: center;">
                            <button type="button" class="select_button">Sélectionner</button>
                            <h3 class="h3_article">'. $row["marque"] .'</h3>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <button type="button" class="select_button">Sélectionner</button>
                            <h3 class="h3_article">'. $row["type"] .'</h3>
                        </div>
                        <h3 class="h3_article">'. $row["prix"] .' €</h3>
                        <h3 class="h3_article">État : '. $row["etat"] .'</h3>
                        <h3 class="h3_article">Couleur : '. $row["couleur"] .'</h3>
            ';
            if($row["proprio"] == -1){
                echo' <h4 class="h4_article">Vendu par : DiamonLux</h4> ';
            }else{
                $req = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                $req->execute([
                    'id' => $row["proprio"]
                ]); 
                $resultat = $req->fetch(PDO::FETCH_ASSOC);
                
                echo' <h4 class="h4_article">Vendu par : '. $resultat["nom"].' '.$resultat["prenom"] .'</h4> ';
            }

            echo'
                        <h4 class="h4_article">'. $row["secteur"] .'</h4>
                        <h4 class="h4_article"><a href="voir_article.php?id='. +$row["id"].'" >Acheter</a></h4>
                    </div>
                </div>
            ';
        }
    }
}
?>
?>