<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];
        include("../../includes/bdd.php");

        $q = 'UPDATE users SET statut = "ban" WHERE id=:id'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "id" => $id
        ]);

    }


?>