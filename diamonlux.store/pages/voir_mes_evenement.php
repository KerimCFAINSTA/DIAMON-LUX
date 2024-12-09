<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/mes_evenement.css">
    <title>Evenement</title>
</head>

<body>
    <?php include("../includes/header.php") ?>
    <main>
        <h1>Evenement suivie</h1>
        <?php
        include("../includes/bdd.php");

        $req = $bdd->prepare("SELECT id FROM users WHERE email=:email");
        $req->execute([
            'email' => $_SESSION['email']
        ]);
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $req2 = $bdd->prepare("SELECT id_evenement, prenom FROM participants WHERE id_utilisateur=:id_utilisateur");
        $req2->execute([
            'id_utilisateur' => $resultat['id']
        ]);
        $resultat2 = $req2->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultat2)) {
            foreach ($resultat2 as $row) {

                $req3 = $bdd->prepare("SELECT id, nom, date_debut, date_fin, description, Ville, adresse, heure_debut, heure_fin, nb_place, prix FROM evenement WHERE id=:id");
                $req3->execute([
                    'id' => $row['id_evenement']
                ]);
                $resultat3 = $req3->fetch(PDO::FETCH_ASSOC);

                $date_debut = date("d/m/Y", strtotime($resultat3['date_debut']));
                $date_fin = date("d/m/Y", strtotime($resultat3['date_fin']));

                $heure_debut = substr($resultat3['heure_debut'], 0, 5);
                $heure_fin = substr($resultat3['heure_fin'], 0, 5);

                echo '  
                        <div class="evenement">
                            <div class="info">
                                <div class="description">
                                    <h3>' . $resultat3["nom"] . '</h3>
                                    <p>Ticket de : ' . $row["prenom"] . '<p>
                                    <a class="bouttons_voir" href="rejoindre_evenement.php?id=' . +$resultat3["id"] . ' " >Consulter</a>
                                    <button class="bouttons_supp" id="boutton_supp" onclick="supp_ma_participation(' . $resultat["id"] . ',' . $resultat3["id"] . ',\'' . $row["prenom"] . '\')">Supprimer</button>
                                </div>
                                <div class="lien">  
                                    <p>Du ' . $date_debut . ' a ' . $heure_debut . ' au ' . $date_fin . ' a ' . $heure_fin . '</p>
                                    <p>A ' . $resultat3["Ville"] . ' au ' . $resultat3["adresse"] . '</p>
                                </div> 
                            </div>
                        </div>
                    ';
            }
        } else {
            echo '
                    <div class="msg_error">
                        <h3>Vous n\'avais pas encore rejoin d\'evenement</h3>
                        <h3>Mais vous pouvez toujours en rejoindre un</h3>
                    </div>
                ';
        }
        ?>
        <script src="../Java-Script/admin.js"></script>
    </main>
</body>
<?php include("../includes/footer.php") ?>

</html>