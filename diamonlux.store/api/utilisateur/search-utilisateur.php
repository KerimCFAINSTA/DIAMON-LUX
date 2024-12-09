<?php
session_start();
if(isset($_GET['name'])) {
    $name = $_GET['name'];

    include('../../includes/bdd.php');

    $req = $bdd->prepare("SELECT droits FROM users WHERE email=:email"); 
    $req->execute([
        'email' => $_SESSION['email']
    ]); 
    $resultat = $req->fetch(PDO::FETCH_ASSOC);

    $reponse = $bdd->prepare("SELECT id, nom, droits, email, statut FROM users WHERE nom LIKE ?");
    $reponse->execute(array("%$name%"));
    $donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

    if(empty($donnees)){
        echo '
            <div class="msg_error">
                <h3>L\'utilisateur que vous recherchez n\'existe pas</h3>
            </div>
        ';
    }

    if($resultat ['droits']=="SuperAdmin"){
        foreach ($donnees as $key => $user) {
            echo '<tr>';
            echo '<td>'. $user['nom'] . '</td>';
            echo '<td>'. $user['email'] . '</td>';
            echo '<td>' . $user['droits'] . '</td>';
            echo '<td>' . $user['statut'] . '</td>';
            echo '<td>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_utilisateur('. $user['id'] .')>Consulter</button>';
            echo '<button class="bouttons" id="boutton_supp" onclick=supp_utilisateur('. $user['id'] .')>Suprimmer</button>';
            if($user['statut']=="actif"){
                echo '<button class="bouttons" id="boutton_ban" onclick=ban_utilisateur('. $user['id'] .')>Bannir</button>';
            }else{
                echo '<button class="bouttons" id="boutton_ban" onclick=activer_utilisateur('. $user['id'] .')>Unban</button>';
            }
            if($user['droits']!="SuperAdmin"){
                if($user['droits']=="admin"){
                    echo '<button class="bouttons" id="boutton_upadmin" onclick=retireradmin_utilisateur('. $user['id'] .')>Retirer Admin</button>';
                }else{
                    echo '<button class="bouttons" id="boutton_upadmin" onclick=uppadmin_utilisateur('. $user['id'] .')>Mettre Admin</button>';
                }
            }
            echo '</td>';
            echo '</tr>';
        } 
    }else{
        foreach ($donnees as $key => $user) {
            echo '<tr>';
            echo '<td>'. $user['nom'] . '</td>';
            echo '<td>'. $user['email'] . '</td>';
            echo '<td>' . $user['droits'] . '</td>';
            echo '<td>' . $user['statut'] . '</td>';
            echo '<td>';
            echo '<button class="bouttons" id="boutton_voir" onclick=voir_utilisateur('. $user['id'] .')>Consulter</button>';
            echo '<button class="bouttons" id="boutton_supp" onclick=supp_utilisateur('. $user['id'] .')>Suprimmer</button>';
            if($user['statut']=="actif"){
                echo '<button class="bouttons" id="boutton_ban" onclick=ban_utilisateur('. $user['id'] .')>Bannir</button>';
            }else{
                echo '<button class="bouttons" id="boutton_ban" onclick=activer_utilisateur('. $user['id'] .')>Unban</button>';
            }
            echo '</td>';
            echo '</tr>';
        } 
    
    }
}
?> 