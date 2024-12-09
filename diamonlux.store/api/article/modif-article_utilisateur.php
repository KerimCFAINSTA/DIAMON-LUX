<?php

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, nom, type, marque, prix, secteur, etat, couleur FROM article WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        

        echo '
            <h4>Modifier l\'article '.$resultat['nom'].'</h4>
            <form action="verif_modif_article_utilisateur.php?id='. + $id .'" method="post" enctype="multipart/form-data">
                <input type="text" name="nom" placeholder="'.$resultat['nom'].'" >
                <div style="display: flex; align-items: center;">
                    <button type="button" class="select_button">Sélectionner</button>
                    <input type="text" name="type" placeholder="'.$resultat['type'].'" >
                </div>
                <div style="display: flex; align-items: center;">
                    <button type="button" class="select_button">Sélectionner</button>
                    <input type="text" name="marque" placeholder="'.$resultat['marque'].'" >
                </div>
                <input type="number" name="prix" placeholder="'.$resultat['prix'].'" >
                <input type="text" name="secteur" placeholder="A '.$resultat['secteur'].'" >
                <input type="text" name="etat" placeholder="État : '.$resultat['etat'].'" >
                <input type="text" name="couleur" placeholder="Couleur : '.$resultat['couleur'].'" >
                <div style="display:flex; gap:5px;">
                    <label for="image" class="add_img">Image:</label>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" >
                </div>
                <input class="submit" type="submit" value="Modifier">
            </form>
        ';

    }

?>