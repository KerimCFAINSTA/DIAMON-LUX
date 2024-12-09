<?php
    session_start();

    if(isset($_GET['name'])) {
        $name = $_GET['name'];

        include("../../includes/bdd.php");

        $reponse = $bdd->prepare("SELECT id, nom, marque, Date_sortie FROM nouveaute WHERE nom LIKE ? ORDER BY nom ASC");
        $reponse->execute(array("%$name%"));
        $results = $reponse->fetchAll(PDO::FETCH_ASSOC);

        if(empty($results)){
            echo '
                <div class="msg_error">
                    <h3>La nouveaute que vous recherchez n\'existe pas</h3>
                </div>
            ';
        }                    
        foreach ($results as $key => $user) {
            echo '<tr>';
            echo '<td>'. $user['nom'] . '</td>';
            echo '<td>'. $user['marque'] . '</td>';
    
            $date_sortie= date("d/m/Y", strtotime($user['Date_sortie']));
            echo '<td>' . $date_sortie . '</td>';
            echo '<td>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_nouveaute('. $user['id'] .')>Consulter</button>';
            echo '<button class="bouttons" id="boutton_voir" onclick=modif_nouveaute('. $user['id'] .')>Modifier</button>';
            echo '<button class="bouttons" id="boutton_supp" onclick=supp_nouveaute('. $user['id'] .')>Suprimmer</button>';
            echo '</td>';
            echo '</tr>';
        }
        echo '         
                        </tbody>
                    </table>
                </div>
            </div>
        ';
    }
?>
                
    