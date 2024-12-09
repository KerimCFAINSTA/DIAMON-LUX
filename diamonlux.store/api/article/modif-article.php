<?php

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, nom, type, marque, prix , proprio, secteur, nb_article FROM article WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        echo'
            <h4 class="h2_admin" id="article_js">Modifier l\'article '. $resultat['nom'].'</h4>
            <div class="form_article">
                <form action="verif_modif_article.php?id='. + $id .'" method="post">
                    <div class="input1">
                        <input class="input_admin" type="text" name="nom" placeholder="'. $resultat['nom'].'">
                        <input class="input_admin" type="text" name="type" placeholder="'. $resultat['type'].'">
                    </div>
                    <div class="iput2">
                        <input class="input_admin" type="text" name="marque" placeholder="'. $resultat['marque'].'">
                        <input class="input_admin" type="number" name="prix" placeholder="'. $resultat['prix'].'">
                        <input class="input_admin" type="number" name="nb_article" placeholder="'. $resultat['nb_article'].' articles" >
                    </div>
                    <div class="submit">
                        <input class="input_admin" type="file" name="image" accept="image/jpeg,image/png,image/gif">
                        <input class="submit" type="submit" value="Ajouter">
                    </div>
                </form>
            </div>
        ';

    }

?>