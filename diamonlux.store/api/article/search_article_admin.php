<?php
    if(isset($_GET['name'])) {
        $name = $_GET['name'];

        include("../../includes/bdd.php");

        $q = $bdd->prepare ("SELECT id, nom, type, marque, prix , proprio, secteur, image FROM article WHERE nom LIKE ? ORDER BY nom ASC");
        $q->execute(array("%$name%"));
        $results = $q->fetchAll(PDO::FETCH_ASSOC);

        if(empty($results)){
            echo '
                <div class="msg_error">
                    <h3>L\'article que vous recherchez n\'existe pas</h3>
                </div>
            ';
        }             

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
    }
    
?>