<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../../includes/bdd.php");   

        $req2 = $bdd->prepare("SELECT id_article FROM panier WHERE id_utilisateur =:id_utilisateur "); 
        $req2->execute([
            'id_utilisateur' => $id
        ]);
        $resultat2 = $req2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($resultat2 as $row) {
            $q1 = "UPDATE article SET nb_article = nb_article-1 WHERE id=:id"; 
            $res1 = $bdd-> prepare($q1); 
            $res1->execute([
                "id" => $row['id_article'],
            ]);
        }



        $q2 = 'DELETE FROM panier WHERE id_utilisateur=:id'; 
        $res2 = $bdd-> prepare($q2); 
        $res2->execute([
            "id" => $id,
        ]);

        echo'<h1>Achat efectuer avec succes</h1>';

    }

?>