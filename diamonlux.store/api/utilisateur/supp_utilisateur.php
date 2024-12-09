<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM users WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id
        ]);

        $q2 = 'DELETE FROM participant WHERE id_article =:id'; 
        $req2 = $bdd-> prepare($q2); 
        $req2->execute([
            "id" => $id
        ]);

        $req = $bdd->prepare("SELECT id FROM article WHERE id=:id"); 
        $req->execute([
            'id' => $id
        ]);
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $q4 = 'DELETE FROM panier WHERE id_article =:id'; 
        $req4 = $bdd-> prepare($q4); 
        $req4->execute([
            "id" => $resultat['id']
        ]);

        $q3 = 'DELETE FROM article WHERE proprio =:id'; 
        $req3 = $bdd-> prepare($q3); 
        $req3->execute([
            "id" => $id
        ]);

        echo'<h1>Article supprimer</h1>';
    }

?>