<?php

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, nom, marque, type, prix, Date_sortie, image FROM nouveaute WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        echo'
            <h4 class="h2_admin" id="nouveautee_js">Modifier '. $resultat['nom'].'</h4>
            <div class="form_nouveautee">
                <form action="verif_modif_nouveaute.php?id='. + $id .'" method="post" enctype="multipart/form-data">
                    <div class="input1">
                        <input class="input_admin" type="text" name="nom" placeholder="'. $resultat['nom'].'" >
                        <input class="input_admin" type="text" name="type" placeholder="'. $resultat['type'].'" >
                        <input class="input_admin" type="text" name="Marque" placeholder="'. $resultat['marque'].'" >
                    </div>
                    <div class="iput2">
                        <input class="input_admin" type="date" name="date" placeholder="Date de sortie" >
                        <input class="input_admin" type="number" name="prix" placeholder="'. $resultat['nom'].'" >
                    </div>
                    <div class="submit">
                        <input class="input_admin" type="file" name="image" accept="image/jpeg, image/png, image/gif" >
                        <input class="submit" type="submit" value="Ajouter">
                    </div>
                </form>
            </div>
            
        ';

    }

?>