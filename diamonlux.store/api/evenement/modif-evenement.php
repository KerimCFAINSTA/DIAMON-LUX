<?php

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix FROM evenement WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        echo'
            <h4 class="h2_admin" id="evenement_js">Modifier l\'evenement evenement'. $resultat['nom'] .'</h4>
            <div class="form_evenement">
                <form action="verif_modif_evenement.php?id='. + $id .'" method="post" >
                    <div class="input1">
                        <input class="input_admin" type="text" name="nom" placeholder="'. $resultat['nom'] .'" >
                        <input class="input_admin" type="text" name="lieu" placeholder="'. $resultat['Ville'] .'" >
                        <input class="input_admin" type="text" name="adresse" placeholder="'. $resultat['adresse'] .'" >
                    </div>

                    <div class="input2">
                        <input class="input_admin" type="date" name="date_debut" >
                        <input class="input_admin" type="date" name="date_fin" >
                    </div>

                    <div class="input2">
                        <input class="input_admin" type="time" name="heure_debut" >
                        <input class="input_admin" type="time" name="heure_fin" >
                    </div>

                    <div class="input2">
                        <input class="input_admin" type="number" name="nb_place" placeholder="'. $resultat['nb_place'] .' place" >
                        <input class="input_admin" type="number" name="prix" placeholder="'. $resultat['prix'] .'€" >
                    </div>

                    <input class="input_com" type="text" name="description" placeholder="'. $resultat['description'] .'" >
                    
                    <div class="submit">
                        <input class="input_admin" type="file" name="image" accept="image/jpeg, image/png, image/gif">
                        <input class="submit" type="submit" value="Modifier les champs remplies">
                    </div>
                </form>
            </div> 
        ';

    }

?>