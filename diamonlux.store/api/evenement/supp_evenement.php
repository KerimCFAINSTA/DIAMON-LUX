<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM evenement WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id,
        ]);

        $q2 = 'DELETE FROM participants WHERE id_evenement=:id'; 
        $req2 = $bdd-> prepare($q2); 
        $req2->execute([
            "id" => $id,
        ]);

        echo'<h1>Evenement supprimer</h1>';
    }

?>