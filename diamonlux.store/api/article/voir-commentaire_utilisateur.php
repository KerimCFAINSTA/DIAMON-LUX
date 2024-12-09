<?php
          

    if(isset($_GET['id'])) {
        $id_utilisateur_commenter = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, id_utilisateur_commentateur, commentaire FROM commentaire_utilisateur WHERE id_utilisateur_commenter=:id"); 
        $req->execute([
            'id' => $id_utilisateur_commenter
        ]);
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($resultat)){           
            echo'
                <h1>Commentaires</h1>
                <div class="voir_paticipant">
                    <table  class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom utilisateur</th>
                                <th>Commentaire</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tab_users">
            ';
            foreach ($resultat as $row){
                $req2 = $bdd->prepare("SELECT id, nom FROM users WHERE id=:id"); 
                $req2->execute([
                    'id' => $row['id_utilisateur_commentateur']
                ]);
                $resultat2 = $req2->fetch(PDO::FETCH_ASSOC);

                            echo '<tr>';
                            echo '<td>'. $resultat2['nom'] . '</td>';
                            echo '<td>'. $row['commentaire'] . '</td>';
                            echo '<td>';
                            echo '<button class="bouttons" id="boutton_supp" onclick=supp_commentaire('. $row['id'].','.$resultat2['id'].')>Suprimmer</button>';
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
                        <h3>Il n\'y toujours pas de commentaire</h3>
                    </div>
                ';
        }
    }

?>