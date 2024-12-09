<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM nouveaute WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id,
        ]);


        echo'<h1>Nouveaute supprimer</h1>';
    }

?>