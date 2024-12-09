<?php

include("../../includes/bdd.php");

$q = 'SELECT id, nom, ville, date_debut, adresse, heure_debut FROM evenement ORDER BY nom ASC';
            $req = $bdd->query($q);
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
                                
                    
                foreach ($results as $key => $user) {
                    echo '<tr>';
                    echo '<td>'. $user['nom'] . '</td>';
                    echo '<td>'. $user['ville'] . '</td>';
                    echo '<td>' . $user['adresse'] . '</td>';

                    $heure_debut = substr($user['heure_debut'], 0, 5);
                    $date_debut = date("d/m/Y", strtotime($user['date_debut']));
                    echo '<td>' . $date_debut . ' - '. $heure_debut.'</td>';
                    echo '<td>';
                    echo '<button class="bouttons" id="boutton_voir" onclick=voir_evenement('. $user['id'] .')>Consulter</button>';
                    echo '<button class="bouttons" id="boutton_voir" onclick=voir_participant('. $user['id'] .')>Voir Participant</button>';
                    echo '<button class="bouttons" id="boutton_voir" onclick=modif_evenement('. $user['id'] .')>Modifier</button>';
                    echo '<button class="bouttons" id="boutton_supp" onclick=supp_evenement('. $user['id'] .')>Suprimmer</button>';
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