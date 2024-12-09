<?php

    include("../../includes/bdd.php");

    $q = 'SELECT id, nom, type, marque, prix , proprio, secteur, image FROM article ORDER BY nom ASC';
    $req = $bdd->query($q);
    $results = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $key => $user) {
        echo '<tr>';
        echo '<td>'. $user['nom'] . '</td>';
        echo '<td>'. $user['marque'] . '</td>';
        echo '<td>' . $user['type'] . '</td>';
        if($user["proprio"] == -1){
            echo' <td>DiamonLux</td> ';
            echo '<td>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_article('. $user['id'] .')>Consulter</button>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_commentaire('. $user['id'] .','. $user['proprio'] .')>Commentaires</button>';
            echo '<button class="bouttons" id="boutton_voir" onclick=modif_article('. $user['id'] .')>Modifier</button>';
            echo '<button class="bouttons" id="boutton_supp" onclick=supp_article('. $user['id'] .')>Suprimmer</button>';
            echo '</td>';
            echo '</tr>';
        }else{
            $req2 = $bdd->prepare("SELECT nom, prenom FROM users WHERE id=:id"); 
            $req2->execute([
                'id' => $user["proprio"]
            ]); 
            $resultat = $req2->fetch(PDO::FETCH_ASSOC);
            
            echo' <td>'. $resultat["nom"].' '.$resultat["prenom"] .'</td> ';
            echo '<td>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_article('. $user['id'] .')>Consulter</button>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_commentaire('. $user['id'] .','. $user['proprio'] .')>Commentaires</button>';
            echo '<button class="bouttons" id="boutton_supp" onclick=supp_article('. $user['id'] .')>Suprimmer</button>';
            echo '</td>';
            echo '</tr>';
        }
    }
?>