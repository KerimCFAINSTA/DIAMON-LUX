<?php
 
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        include("../../includes/bdd.php");

    
        $req = $bdd->prepare("SELECT  id_utilisateur, nom, prenom   FROM participants WHERE id_evenement=:id_evenement"); 
        $req->execute([
            'id_evenement' => $id
        ]);
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        
        if(!empty($resultat)){           
            echo'
                <h1>Participants</h1>
                <div class="voir_paticipant">
                    <table  class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom Acheteur</th>
                                <th>Statut Acheteur</th>
                                <th>Nom-Prenom sur le ticket</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tab_users">
            ';
                foreach ($resultat as $row){
                    $req2 = $bdd->prepare("SELECT id, nom, prenom, email, statut FROM users WHERE id=:id"); 
                    $req2->execute([
                        'id' => $row['id_utilisateur']
                    ]);
                    $resultat2 = $req2->fetch(PDO::FETCH_ASSOC);

                                echo '<tr>';
                                echo '<td>'. $resultat2['nom'] . '</td>';
                                echo '<td>' . $resultat2['statut'] . '</td>';
                                echo '<td>' . $row['nom'] . '-'. $row['prenom'].'</td>';
                                echo '<td>';
                                echo '<button class="bouttons" id="boutton_supp" onclick="supp_participants(`'. $resultat2['id'] .'`,'. $id .',\''. $row["nom"] .'\',\''. $row["prenom"] .'\')">Supprimer</button>';
                                echo '</td>';
                                echo '</tr>';
                }
            echo'               
                        </tbody>
                    </table>
                </div>

            ';
        }else{
            echo '
                    <div class="msg_error">
                        <h3>Il n\'y toujours pas de participant</h3>
                        <h3>Un peu de patience </h3>
                    </div>
                ';
        }
    }

?>