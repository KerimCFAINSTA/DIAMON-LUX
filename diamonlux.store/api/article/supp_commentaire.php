<?php

    if($_GET['type'] == -1 && isset($_GET['id_commentaire'])){

        $id_commentaire = $_GET['id_commentaire'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM commentaire_article WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id_commentaire,
        ]);

    }else if($_GET['type'] != -1 && isset($_GET['id_commentaire'])){
        
        $id_commentaire = $_GET['id_commentaire'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM commentaire_utilisateur WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id_commentaire,
        ]);

    }

?>