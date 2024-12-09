<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        include("../includes/bdd.php");

        $q2 = 'DELETE FROM article WHERE id =:id'; 
        $req2 = $bdd-> prepare($q2); 
        $req2->execute([
            "id" => $id
        ]);

        echo'<h1>Article supprimer</h1>';

        
    }

?>