<?php

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        include("../../includes/bdd.php"); 
        $req = $bdd->prepare("SELECT id, nom, prenom, ville, adresse, email, num_phone, date_naissance, droits,statut FROM users WHERE id=:id");
        $req->execute([
            'id' => $id
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // affiche tout les elements du profil
        if(isset($resultat)){
            echo '
            <div class="profil1">        
                <h2 id="nom">Nom : '.$resultat['nom'].'</h2>
                <h2 id="prenom">Prenom : '.$resultat['prenom'].'</h2>
                <h2 id="mail">Email : '.$resultat['email'].'</h2>
                <h2 id="adresse">Adresse : '.$resultat['ville'].', '.$resultat['adresse'].'</h2>
            </div>
            <div class="profil2">
                
                <h2 id="num_phone">Numeros de Telephone : '.$resultat['num_phone'].'</h2>
                <h2 id="date">Date de naissance : '.$resultat['date_naissance'].'</h2>
                <h2 id="droits">Droits : '.$resultat['droits'].'</h2>
                <h2 id="statut">Statut : '.$resultat['statut'].'</h2>
            </div>
            ';
        }
    }
?>