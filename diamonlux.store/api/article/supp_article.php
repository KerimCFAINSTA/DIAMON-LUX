<?php
        
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM article WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id,
        ]);

        $q2 = 'DELETE FROM panier WHERE id_article =:id'; 
        $req2 = $bdd-> prepare($q2); 
        $req2->execute([
            "id" => $id,
        ]);

        echo'<h1>Article supprimer</h1>';
    }

?>