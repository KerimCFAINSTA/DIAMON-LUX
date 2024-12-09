<?php
    
    
    if(isset($_GET['idA']) && isset($_GET['idU'])){

        $idA = $_GET['idA'];
        $idU = $_GET['idU'];
        include("../../includes/bdd.php");

        $q = 'INSERT INTO panier (id_utilisateur, id_article) VALUES (:idU, :idA)';
        $req = $bdd-> prepare($q); 
        $req->execute([
            "idA" => $idA,
            "idU" => $idU
        ]);
        echo ' Vous avez bien ajouté l\'article a votre panier';
        
        
    }
?>