<?php

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix FROM evenement WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

           
        if(isset($resultat)){

        $date_debut = date("d/m/Y", strtotime($resultat['date_debut']));
        $date_fin = date("d/m/Y", strtotime($resultat['date_fin']));

        $heure_debut = substr($resultat['heure_debut'], 0, 5);
        $heure_fin = substr($resultat['heure_fin'], 0, 5);

        echo'  <div class="evenement">
                    <div class="info">
                        <div class="description">
                            <h3>'. $resultat["nom"] .'</h3>
                            <p> Il reste '.$resultat["nb_place"].' place pour '.$resultat["prix"].'€</p>
                            <p>'. $resultat["description"] .'</p>
                        </div>
                        <div class="lien">  
                            <p>Du '. $date_debut .' a '. $heure_debut .' au '. $date_fin .' a '. $heure_fin .'</p>
                            <p>A '. $resultat["Ville"] .' au '.$resultat["adresse"].'</p>
                        </div> 
                    </div>
                </div>
            ';

        }

    }



?>