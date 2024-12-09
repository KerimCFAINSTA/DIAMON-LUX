<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/acheter_ticket_evenement.css">
    <title>Acheter des ticket</title>
</head>
<body>
<?php include("../includes/header.php") ?>
<main>
    <h1>Achat de ticket</h1>
    <?php
    if(isset($_GET['id'])){

        $idE=$_GET['id'];

        $req = $bdd->prepare("SELECT nom, prix, nb_place  FROM evenement WHERE id=:idE"); 
        $req->execute([
            'idE' => $idE
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $req2 = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
        $req2->execute([
            'email' => $_SESSION["email"]
        ]); 
        $resultat2 = $req2->fetch(PDO::FETCH_ASSOC);

        // Requette pour verifier si l'utilisateur n'as pas plus de 4 ticket
        $req3 = $bdd->prepare("SELECT id FROM participants WHERE id_utilisateur=:idU AND id_evenement=:idE"); 
        $req3->execute([
            'idU' => $resultat2["id"],
            'idE' => $idE
        ]); 
        $resultat3 = $req3->fetchAll(PDO::FETCH_ASSOC);

        $nombreTicket = count($resultat3);

        if($resultat["nb_place"] >= 4){

            echo'
                <div class="choix_ticket">
                    <form id="recherche" method="post">
                        <select name="nb_ticket" id="nb_ticket">
                            <option selected disabled hidden id="choix">Choisissez un nombre de ticket</option>
                ';
            for($i=1 ; $i<5-$nombreTicket ; $i++) {
                echo'  <option value="'.$i.'"> '.$i.' </option>';
            }
            
            echo '
                            </select>
                        <input type="submit" value="Envoyer">
                    </form>
                </div>
                ';
    
        }else{

            if($resultat["nb_place"]-$nombreTicket >= 0){
                $nbTicketAchete = 4 - $nombreTicket;
            }else{
                $nbTicketAchete = $resultat["nb_place"];
            }

            echo'
            <div class="choix_ticket">
                <form id="recherche" method="post">
                    <select name="nb_ticket" id="nb_ticket">
                        <option selected disabled hidden id="choix">Choisissez un nombre de ticket</option>
            ';
            for($i=1 ; $i<= $nbTicketAchete ; $i++) {
                echo'  <option value="'.$i.'"> '.$i.' </option>';
            }
            echo '
                            </select>
                        <input class="input_ticket" type="submit" value="Envoyer">
                    </form>
                </div>
                ';
        }

        if (!empty($_POST['nb_ticket'])){
            
            $nb_ticket = $_POST['nb_ticket'];

            $prix_max = $nb_ticket*$resultat["prix"];

            echo'
                <div class="recap">
                    <h3> Recap de vos ticket pour l\'evenement '.$resultat["nom"].'</h3>
                    <h4>Nb ticket : '.$nb_ticket.'</h4>
                    <h4>Pour un total de : '.$prix_max.'€</h4>
                </div>
            ';
           
            echo '
                <div class="acheter">
                    <form action="finalisation_achat.php?id='. +$idE.' " method="post">
                ';
            for($i=1 ; $i<=$nb_ticket ; $i++){
                echo'
                    <div class="info_ticket">
                        <input type="text" name="nom'.$i.'" placeholder="Nom '.$i.'" required>
                        <input type="text" name="prenom'.$i.'" placeholder="Prenom '.$i.'" required>
                    </div>
                ';
            }
            echo'
                        <input class="submit" type="submit" value="Valider">
                    </form>
                </div>
            ';

        }

    }else{
        header('location: rejoindre_evenement.php');
    }
    ?>
</main>
</body>
</html>