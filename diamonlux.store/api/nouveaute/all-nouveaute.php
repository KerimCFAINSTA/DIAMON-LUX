<?php

include("../../includes/bdd.php");

$q = 'SELECT id, nom, marque, Date_sortie FROM nouveaute ORDER BY nom ASC';
$req = $bdd->query($q);
$results = $req->fetchAll(PDO::FETCH_ASSOC);
                    
        
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
                


?>