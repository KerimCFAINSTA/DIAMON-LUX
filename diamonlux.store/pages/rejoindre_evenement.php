<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/rejoindre_evenement.css">
    <title>Evenement</title>
</head>
<body>
<?php include("../includes/header.php") ?>
<main>
<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        include("../includes/bdd.php");
            
        if(!empty($_SESSION['email'])){

            $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
            $req->execute([
                'email' => $_SESSION["email"]
            ]); 
            $resultat = $req->fetch(PDO::FETCH_ASSOC);

        }

        $reponse = $bdd->query("SELECT id, nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix, image FROM evenement WHERE id=$id");
        $donnees = $reponse-> fetch (PDO:: FETCH_ASSOC);


        $date_debut = date("d/m/Y", strtotime($donnees['date_debut']));
        $date_fin = date("d/m/Y", strtotime($donnees['date_fin']));

        $heure_debut = substr($donnees['heure_debut'], 0, 5);
        $heure_fin = substr($donnees['heure_fin'], 0, 5);


        if(empty($donnees['image'])){
            echo'  <div class="evenement">
                        <div class="ligne1">
                            <div class="nom">
                                <h1>'. $donnees["nom"] .'</h1>
                                <h3>Du '. $date_debut .' a '. $heure_debut .' au '. $date_fin .' a '. $heure_fin .'</h3>
                            </div>
                        </div>
                        <div class="ligne2">
                            <p class="description">'. $donnees["description"] .'<br>
                                Il reste '.$donnees["nb_place"].' place pour '.$donnees["prix"].'€ chacune</p>

                            <div class="map">
                                <h3>A '. $donnees["Ville"] .' au '. $donnees["adresse"] .'</h3>
                                
                            </div>
                        </div>
                        <div class="rejoindre"> ';
                            if($donnees["nb_place"] == 0){
                                echo' <h1>Cette evenement est deja complet</h1>';
                            }else if(empty($_SESSION['email'])){
                                echo'<h2>Vous devez etres connecté pour pour rejoindre cette evenement</h2>';
                            }else{
                                // Requette pour verifier si l'utilisateur n'as pas plus de 4 ticket
                                $req2 = $bdd->prepare("SELECT id FROM participants WHERE id_utilisateur=:idU AND id_evenement=:idE"); 
                                $req2->execute([
                                    'idU' => $resultat["id"],
                                    'idE' => $id
                                ]); 
                                $resultat2 = $req2->fetchAll(PDO::FETCH_ASSOC);

                                $nombreTicket = count($resultat2);
                                

                                if($nombreTicket<4){
                                    echo' <a class="bouttons" id="boutton_rejoindre" href="acheter_ticket_evenement.php?id='. +$donnees["id"].' " >Acheter ticket</a>';
                                }else{
                                    echo' <h2>Vous avez deja prix trop de ticket pour cette evenement</h2>';
                                }

                                
                            }
            echo'       </div>
                    </div>
                ';
        }else{

            $imagePath = 'uploads/' . $donnees['image'];
            echo'  <div class="evenement">
                        <div class="ligne1">
                            <img class="img_e" src="'. $imagePath .'" alt="Image evenement">
                            <div class="nom">
                                <h1>'. $donnees["nom"] .'</h1>
                                <h3>Du '. $date_debut .' a '. $heure_debut .' au '. $date_fin .' a '. $heure_fin .'</h3>
                            </div>
                        </div>
                        <div class="ligne2">
                            <p class="description">'. $donnees["description"] .'<br>
                                Il reste '.$donnees["nb_place"].' place pour '.$donnees["prix"].'€ chacune</p>
                                
                            <div class="map">
                                <h3>A '. $donnees["Ville"] .' au '. $donnees["adresse"] .'</h3>
                                
                            </div>
                        </div>
                        <div class="rejoindre"> ';

                            if($donnees["nb_place"] == 0){
                                echo' <h1>Cette evenement est deja complet</h1>';
                            }else if(empty($_SESSION['email'])){
                                echo'<h2>Vous devez etres connecté pour pour rejoindre cette evenement</h2>';                        
                            }else{
                                // Requette pour verifier si l'utilisateur n'as pas plus de 4 ticket
                                $req2 = $bdd->prepare("SELECT id FROM participants WHERE id_utilisateur=:idU AND id_evenement=:idE"); 
                                $req2->execute([
                                    'idU' => $resultat["id"],
                                    'idE' => $id
                                ]); 
                                $resultat2 = $req2->fetchAll(PDO::FETCH_ASSOC);

                                $nombreTicket = count($resultat2);


                                if($nombreTicket<4){
                                    echo' <a class="bouttons" id="boutton_rejoindre" href="acheter_ticket_evenement.php?id='. +$donnees["id"].' " >Acheter ticket</a>';
                                }else{
                                    echo' <h2>Vous avez deja prix trop de ticket pour cette evenement</h2>';
                                }
                            }
            echo'       </div>
                    </div>
                ';
        }
    }

?>
<script src="../Java-Script/admin.js"></script>
</main>
<?php include("../includes/footer.php") ?>
</body>
</html>