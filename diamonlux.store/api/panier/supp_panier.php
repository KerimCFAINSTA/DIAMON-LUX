<?php

    if(isset($_GET['idU']) && isset($_GET['idA'])) {

        $idA = $_GET['idA'];
        $idU = $_GET['idU'];

        include("../../includes/bdd.php");

        $q2 = 'DELETE FROM panier WHERE id_article =:idA AND id_utilisateur=:idU'; 
        $req2 = $bdd-> prepare($q2); 
        $req2->execute([
            "idA" => $idA,
            "idU" => $idU
        ]);

        echo'<h1>Article supprimer du panier </h1>';

        
    }

?>