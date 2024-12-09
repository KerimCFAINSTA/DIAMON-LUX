<?php

    $tab_marque = [];
    $tab_marque_affichage = [];

    $tab_type = [];
    $tab_tybe_affichage = [];

    $tab_lieu = [];
    $tab_lieu_affichage = [];



    include("../includes/bdd.php");

    $reponse_marque = $bdd->query("SELECT marque FROM article ORDER BY marque ASC");
    $donnees_marque = $reponse_marque-> fetchAll (PDO:: FETCH_ASSOC);

    if(!empty($donnees_marque)){
        foreach ($donnees_marque as $row) {
            array_push($tab_marque, $row["marque"]);;
        }
    
        $tab_marque_affichage = $tab_marque;
        for($i=0 ; $i<count($tab_marque) ; $i++){
            for($j=$i+1 ; $j<count($tab_marque) ; $j++){
                if($tab_marque[$i]==$tab_marque[$j]){
                    unset($tab_marque_affichage[$j]);
                }
            }
        }
    }

    $reponse_type = $bdd->query("SELECT type FROM article ORDER BY type ASC");
    $donnees_type = $reponse_type-> fetchAll (PDO:: FETCH_ASSOC);

    if(!empty($donnees_type)){
        foreach ($donnees_type as $row) {
            array_push($tab_type, $row["type"]);;
        }


        $tab_type_affichage = $tab_type;
        for($i=0 ; $i<count($tab_type) ; $i++){
            for($j=$i+1 ; $j<count($tab_type) ; $j++){
                if($tab_type[$i]==$tab_type[$j]){
                    unset($tab_type_affichage[$j]);
                }
            }
        }
    }

    $reponse_lieu = $bdd->query("SELECT secteur FROM article ORDER BY secteur ASC");
    $donnees_lieu = $reponse_lieu-> fetchAll (PDO:: FETCH_ASSOC);

    if(!empty($donnees_lieu)){
        foreach ($donnees_lieu as $row) {
            if($row["secteur"] != "france")
            array_push($tab_lieu, $row["secteur"]);
        }


        $tab_lieu_affichage = $tab_lieu;
        for($i=0 ; $i<count($tab_lieu) ; $i++){
            for($j=$i+1 ; $j<count($tab_lieu) ; $j++){
                if($tab_lieu[$i]==$tab_lieu[$j]){
                    unset($tab_lieu_affichage[$j]);
                }
            }
        }
    }

?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/article.css">
    <title>Article</title>
</head>
<body>
    <?php include("../includes/header.php") ?>
    <main>
        <h1 class="h1_article">Article</h1>
        <div class="filtre">
            <div  class="barre_de_recherche">
                <input type="text" id="search-article-input" oninput="searchArticle()" placeholder="Nom de l'article ">
                <button class="boutton" id="refresh" onclick="allArticle()"><img id="img_refresh" src="../images/refresh.png"></button>
            </div>
            <div  class="tout_les_filtre">
                <form id="recherche" method="post">
                    <select class="boutton" name="marque" id="marque">
                        <option selected disabled hidden id="choix">Choisir une marque</option>
                        <?php
                            foreach($tab_marque_affichage as $element) {
                                echo'  <option value="'.$element.'">'.$element.'</option>';
                            }
                        ?>
                    </select>
                    <select class="boutton" name="type" id="type">
                        <option selected disabled hidden id="choix">Choisir un type</option>
                        <?php
                            foreach($tab_type_affichage as $element) {
                                echo'  <option value="'.$element.'">'.$element.'</option>';
                            }
                        ?>
                    </select>
                    <select class="boutton"name="lieu" id="type">
                        <option selected disabled hidden id="choix">Choisir un lieu</option>
                        <?php
                            foreach($tab_lieu_affichage as $element) {
                                echo'  <option value="'.$element.'">'.$element.'</option>';
                            }
                        ?>
                    </select>
                    <br>
                    <input type="radio" name="proprio" value="diamonLux">Par DiamonLux<br>
                    <input type="radio" name="proprio" value="autre">Par des particulier<br>
                    <input class="boutton" type="submit" value="Envoyer">
                </form>
            </div>
        </div>


        <?php

            if (empty($_POST['marque']) && empty($_POST['type']) && empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article FROM article");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && empty($_POST['type']) && empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(empty($_POST['marque']) && !empty($_POST['type']) && empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && !empty($_POST['type']) && empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}'  AND marque='{$_POST['marque']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(empty($_POST['marque']) && empty($_POST['type']) && !empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image FROM, nb_article  article WHERE secteur='{$_POST['lieu']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && empty($_POST['type']) && !empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image FROM, nb_article  article WHERE secteur='{$_POST['lieu']}' AND marque='{$_POST['marque']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && !empty($_POST['type']) && !empty($_POST['lieu']) && empty($_POST['proprio'])){
                include("../includes/bdd.php");
        
                $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE secteur='{$_POST['lieu']}' AND marque='{$_POST['marque']}' AND type='{$_POST['type']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

        
            }else if(empty($_POST['marque']) && empty($_POST['type']) && empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio'] == 'diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && empty($_POST['type']) && empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(empty($_POST['marque']) && !empty($_POST['type']) && empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && !empty($_POST['type']) && empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND type='{$_POST['type']}' AND marque='{$_POST['marque']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND type='{$_POST['type']}' AND marque='{$_POST['marque']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(empty($_POST['marque']) && empty($_POST['type']) && !empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE secteur='{$_POST['lieu']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE secteur='{$_POST['lieu']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && empty($_POST['type']) && !empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND secteur='{$_POST['lieu']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND secteur='{$_POST['marque']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(empty($_POST['marque']) && !empty($_POST['type']) && !empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}' AND secteur='{$_POST['lieu']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE type='{$_POST['type']}' AND secteur='{$_POST['marque']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }else if(!empty($_POST['marque']) && !empty($_POST['type']) && !empty($_POST['lieu']) && !empty($_POST['proprio'])){
                include("../includes/bdd.php");
                
                if($_POST['proprio']=='diamonLux'){
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND type='{$_POST['type']}' AND secteur='{$_POST['lieu']}' AND proprio=-1");
                }else{
                    $reponse = $bdd->query("SELECT id, nom, type, prix, marque, date_vente, secteur, proprio,image, nb_article  FROM article WHERE marque='{$_POST['marque']}' AND type='{$_POST['type']}' AND secteur='{$_POST['marque']}' AND proprio!=-1");
                }
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }



            if(empty($donnees)){
                echo '
                    <div class="msg_error">
                        <h3>Les articles que vous recherchez n\'existe pas encore</h3>
                        <h3>Mais vous pouvez toujours changer les filtres choisis</h3>
                    </div>
                ';
            }

            echo '<div id="toutLesArticles">';
                
                foreach ($donnees as $row) {
                    if($row['nb_article'] > 0){
                        $imagePath = 'uploads/' . $row['image'];
                        echo '
                            <div class="article">
                                <div class="img_article">
                                    <img class="img_a" src="'. $imagePath .'" alt="Image Article">
                                </div>
                                <div class="description">
                                    <h2 class="h2_article">'. $row["nom"] .'</h2>
                                    <h3 class="h3_article">'. $row["marque"] .'</h3>
                                    <h3 class="h3_article">'. $row["type"] .'</h3>
                                    <h3 class="h3_article">'. $row["prix"] .' €</h3>
                        ';
                        if($row["proprio"] == -1){
                            echo' <h4 class="h4_article">Vendu par : DiamonLux</h4> ';
                        }else{
                            $req = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
                            $req->execute([
                                'id' => $row["proprio"]
                            ]); 
                            $resultat = $req->fetch(PDO::FETCH_ASSOC);
                            
                            echo' <h4 class="h4_article">Vendu par : '. $resultat["nom"].' '.$resultat["prenom"] .'</h4> ';
                        }

                        echo'
                                    <h4 class="h4_article">'. $row["secteur"] .'</h4>
                                    <h4 class="h4_article"><a href="voir_article.php?id='. +$row["id"].'" >Acheter</a></h4>
                                </div>
                            </div>
                        ';
                    }
                }
                echo '  <div id="liste-article">
                        </div>
                ';

            echo '</div>';

        ?>  
        <div id="liste-article">

        
        </div>
    <script src="../Java-Script/recherche.js"></script>
    </main>
<?php include("../includes/footer.php") ?>
</body>
</html>