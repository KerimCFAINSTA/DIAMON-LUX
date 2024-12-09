<?php        
        
    if(isset($_GET['id'])) {
        $id_article = $_GET['id'];

        include("../../includes/bdd.php");

        $req = $bdd->prepare("SELECT id, id_utilisateur, commentaire FROM commentaire_article WHERE id_article=:id"); 
        $req->execute([
            'id' => $id_article
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
                    'id' => $row['id_utilisateur']
                ]);
                $resultat2 = $req2->fetch(PDO::FETCH_ASSOC);

                            echo '<tr>';
                            echo '<td>'. $resultat2['nom'] . '</td>';
                            echo '<td>'. $row['commentaire'] . '</td>';
                            echo '<td>';
                            echo '<button class="bouttons" id="boutton_supp" onclick=supp_commentaire('. $row['id'].',-1)>Suprimmer</button>';
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