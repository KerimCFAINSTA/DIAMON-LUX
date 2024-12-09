<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $q = $bdd->prepare("SELECT id, nom, marque, type, prix, Date_sortie, image FROM nouveaute WHERE id=:id ORDER BY nom ASC ");
        $q->execute([
            'id' => $id
        ]);
        $resultat = $q->fetch(PDO::FETCH_ASSOC);

        $date_sortie= date("d/m/Y", strtotime($resultat['Date_sortie']));
        $imagePath = 'uploads/' . $resultat['image'];
        echo'  
            <div class="info_article">
                <div class="img_article">
                    <img class="img_a" src="'. $imagePath .'" alt="Image Article">
                </div>
                <div class="description">
                    <h3>'. $resultat["nom"] .'</h3>
                    <p>'. $resultat["type"] .'<p>
                    <p>'. $resultat["marque"] .'<p>
                </div>
                <div class="description">
                    <p>'. $resultat["prix"] .'€<p>
                    <p>Le '. $date_sortie .' </p>
                </div>
            </div>
        ';
    }
?>