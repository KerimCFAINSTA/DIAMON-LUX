<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/nouveaute.css">
    <title>Nouveaute</title>
</head>
<body>
    <?php include("../includes/header.php") ?>
    <main>
    <?php

            $tab_marque = [];
            $tab_marque_affichage = [];
            $tab_type = [];
            $tab_tybe_affichage = [];
            

            include("../includes/bdd.php");

            $reponse_marque = $bdd->query("SELECT marque FROM nouveaute ORDER BY marque ASC");
            $donnees_marque = $reponse_marque-> fetchAll (PDO:: FETCH_ASSOC);

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

            $reponse_type = $bdd->query("SELECT type FROM nouveaute  ORDER BY type ASC");
            $donnees_type = $reponse_type-> fetchAll (PDO:: FETCH_ASSOC);

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

        ?>

        <h1 class="h1_nouveaute">Nouveaute</h1>
        <form id="recherche" method="post">
            <select name="marque" id="marque">
                <option selected disabled hidden id="choix">Choisir une marque</option>
                <?php
                    foreach($tab_marque_affichage as $element) {
                        echo'  <option value="'.$element.'">'.$element.'</option>';
                    }
                ?>
            </select>
            <select name="type" id="type">
                <option selected disabled hidden id="choix">Choisissez un type d'article</option>
                <?php
                    foreach($tab_type_affichage as $element) {
                        echo'  <option value="'.$element.'">'.$element.'</option>';
                    }
                ?>
            </select>
            <input type="submit" value="Envoyer">
        </form>
<?php
    
    if (empty($_POST['marque']) && empty($_POST['type'])){
        include("../includes/bdd.php");

        $reponse = $bdd->query("SELECT Nom, Marque, Type, Prix, Date_sortie, image FROM nouveaute");
        $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

        if(empty($donnees)){
            echo '
                <div style="background-color: white;" class="msg_error">
                    <h3 class="h3_nouveaute">Les articles que vous recherchez n\'existe pas encore</h3>
                    <h3 class="h3_nouveaute">Mais vous pouvez toujours changer les filtres choisis</h3>
                </div>
            ';
        }

    }else if (!empty($_POST['marque']) && !empty($_POST['type'])){
        include("../includes/bdd.php");

        $reponse = $bdd->query("SELECT Nom, Marque, Type, Prix, Date_sortie, image FROM nouveaute WHERE Marque='{$_POST['marque']}' AND Type='{$_POST['type']}'");
        $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

        if(empty($donnees)){
            echo '
                <div style="background-color: white;" class="msg_error">
                    <h3 class="h3_nouveaute">Les articles que vous recherchez n\'existe pas encore</h3>
                    <h3 class="h3_nouveaute">Mais vous pouvez toujours changer les filtres choisis</h3>
                </div>
            ';
        }
    
    }else if (!empty($_POST['marque']) ){
        include("../includes/bdd.php");

        $reponse = $bdd->query("SELECT Nom, Marque, Type, Prix, Date_sortie, image FROM nouveaute WHERE Marque='{$_POST['marque']}'");
        $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

        if(empty($donnees)){
            echo '
                <div style="background-color: white;" class="msg_error">
                    <h3 class="h3_nouveaute">Les articles que vous recherchez n\'existe pas encore</h3>
                    <h3 class="h3_nouveaute">Mais vous pouvez toujours changer les filtres choisis</h3>
                </div>
            ';
        }

    }else if (!empty($_POST['type']) ){
        include("../includes/bdd.php");

        $reponse = $bdd->query("SELECT Nom, Marque, Type, Prix, Date_sortie, image FROM nouveaute WHERE Type='{$_POST['type']}'");
        $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

        if(empty($donnees)){
            echo '
                <div style="background-color: white;" class="msg_error">
                    <h3 class="h3_nouveaute">Les articles que vous recherchez n\'existe pas encore</h3>
                    <h3 class="h3_nouveaute">Mais vous pouvez toujours changer les filtres choisis</h3>
                </div>
            ';
        }
    }
    
    foreach ($donnees as $row) {

        $imagePath = 'uploads/' . $row['image'];
        $date_sortie = date("d/m/Y", strtotime($row['Date_sortie']));

        echo '  <div class="nouveaute">
                    <div class="img_nouveaute">
                        <img class="img_n" src="'.$imagePath.'" alt="test">
                    </div>
                    <div class="description">
                        <h2 class="h2_nouveaute">'. $row["Nom"] .'</h2>
                        <h3 class="h3_nouveaute">'. $row["Marque"] .'</h3>
                        <h3 class="h3_nouveaute">'. $row["Type"] .'</h3>
                    </div>
                    <div class="prco">  
                        <h3 class="h3_nouveaute">Le '. $date_sortie .'</h3>
                        <h3 class="h3_nouveaute">'. $row["Prix"] .'€</h3>
                    </div> 
                </div>
                <br>
            ';
    }
?>
        
    </main>
    <?php include("../includes/footer.php") ?>
</body>
</html>