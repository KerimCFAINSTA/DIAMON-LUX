<?php

    if(isset($_GET['idU']) && isset($_GET['idE']) && isset($_GET['nom']) && isset($_GET['prenom'])) {

        $idU = $_GET['idU'];
        $idE = $_GET['idE'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];

        include("../../includes/bdd.php");

        $q = 'DELETE FROM participants WHERE id_utilisateur =:idU AND id_evenement=:idE	AND nom=:nom AND prenom=:prenom'; 
        $req = $bdd-> prepare($q); 
        $req->execute([
            "idU" => $idU,
            "idE" => $idE,
            "nom" => $nom,
            "prenom" => $prenom
        ]);

        $q2 = 'UPDATE evenement SET nb_place=nb_place+1 WHERE id=:idE';
            $req2 = $bdd-> prepare($q2); 
            $req2->execute([
                "idE" => $idE
            ]); 
    }

    echo"<h3>Participant supprime avec succes</h3>"


?>