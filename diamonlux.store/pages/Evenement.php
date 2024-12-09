<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/evenement.css">
    <title>Evenement</title>
</head>
<body>
<body>
<?php include("../includes/header.php") ?>
    <main>
        <?php
            $i = 0;
            $tab_ville = [];
            

            include("../includes/bdd.php");

            $reponse = $bdd->query("SELECT ville FROM evenement ORDER BY ville ASC");
            $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);

            foreach ($donnees as $row) {
                array_push($tab_ville, $row["ville"]);
            }

            
            $tab_ville_affichage = $tab_ville;
            for($i=0 ; $i<count($tab_ville) ; $i++){
                for($j=$i+1 ; $j<count($tab_ville) ; $j++){
                    if($tab_ville[$i]==$tab_ville[$j]){
                        unset($tab_ville_affichage[$j]);
                    }
                }
            }

        ?>


        <h1 class="h1_evenement" >Evenement</h1>
        <form id="recherche" method="post">
            <select name="ville" id="ville'">
                <option selected disabled hidden id="choix">Choisissez une ville</option>
        <?php
        foreach($tab_ville_affichage as $element) {
            echo'  <option value="'.$element.'">'.$element.'</option>';
        }
        ?>
                </select>
            <input type="submit" value="Envoyer">
        </form>

        <?php 

            if (empty($_POST['ville'])){

                include("../includes/bdd.php");
    
                $reponse = $bdd->query("SELECT id, nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix FROM evenement");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
            }
            if (!empty($_POST['ville'])){

                include("../includes/bdd.php");
    
                $reponse = $bdd->query("SELECT id, nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix FROM evenement WHERE Ville='{$_POST['ville']}'");
                $donnees = $reponse-> fetchAll (PDO:: FETCH_ASSOC);
        
            }

            foreach ($donnees as $row) {

                $date_debut = date("d/m/Y", strtotime($row['date_debut']));
                $date_fin = date("d/m/Y", strtotime($row['date_fin']));

                $heure_debut = substr($row['heure_debut'], 0, 5);
                $heure_fin = substr($row['heure_fin'], 0, 5);

                $req = $bdd->prepare("SELECT image FROM evenement WHERE id=:id");
                $req->execute([
                    'id' => $row["id"]
                ]); 
                $resultat = $req->fetch(PDO::FETCH_ASSOC);

                if(empty($resultat['image'])){

                    echo'  <div class="evenement">
                                <div class="info">
                                    <div class="description">
                                        <h2>'. $row["nom"] .'</h2>
                                        <p>'. $row["description"] .'<p>
                                        <p> Il reste '.$row["nb_place"].' place pour '.$row["prix"].'€ </p>
                                    </div>
                                    <div class="lien">  
                                        <h3>Du '. $date_debut .' a '. $heure_debut .' au '. $date_fin .' a '. $heure_fin .'</h3>
                                        <h2>A '. $row["Ville"] .' au '.$row["adresse"].'</h2>
                                        <h3><a href="rejoindre_evenement.php?id='. +$row["id"].' " >Rejoindre</a></h3>
                                    </div> 
                                </div>
                            </div>
                        ';
                }else{
                    $imagePath = 'uploads/' . $resultat['image'];

                    echo'  <div class="evenement">
                                <div class="img_evenement">
                                    <img class="img_e" src="'. $imagePath .'" alt="Image evenement">
                                </div>
                                <div class="info">
                                    <div class="description">
                                        <h2>'. $row["nom"] .'</h2>
                                        <p>'. $row["description"] .'<p>
                                        <p> Il reste '.$row["nb_place"].' place pour '.$row["prix"].'€ </p>
                                    </div>
                                    <div class="lien">  
                                        <h3>Du '. $date_debut .' a '. $heure_debut .' au '. $date_fin .' a '. $heure_fin .'</h3>
                                        <h2>A '. $row["Ville"] .' au '.$row["adresse"].'</h2>
                                        <h3><a href="rejoindre_evenement.php?id='. +$row["id"].' " >Rejoindre</a></h3>
                                    </div> 
                                </div>
                            </div>
                        ';
                }

            }
        
        ?>
    </main>
    <?php include("../includes/footer.php") ?>
</body>
</html>