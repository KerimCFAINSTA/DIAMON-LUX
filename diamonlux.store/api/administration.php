<?php

    session_start();
    include("../includes/bdd.php");    

    if(isset($_GET['affichage'])) {
        $affichage = $_GET['affichage'];
        
        echo '<h1>'.$affichage.'</h1>';

        //
        // Affiche les formulaires
        //
        if($affichage == 'Ajout'){
            echo '
            <div id="page_admin_ajout" >
                <div class="ajout">
                    <h2 class="h2_admin" id="evenement_js">Ajouter des evenements</h2>
                    <div class="form_evenement">
                        <form action="verif_evenement.php" method="post" enctype="multipart/form-data">
                            <div class="input1">
                                <input class="input_admin" type="text" name="nom" placeholder="Nom" required>
                                <input class="input_admin" type="text" name="lieu" placeholder="Lieu" required>
                                <input class="input_admin" type="text" name="adresse" placeholder="Adresse" required>
                            </div>

                            <div class="input2">
                                <input class="input_admin" type="date" name="date_debut" placeholder="Date Debut" required>
                                <input class="input_admin" type="date" name="date_fin" placeholder="Date Fin" required>
                            </div>

                            <div class="input2">
                                <input class="input_admin" type="time" name="heure_debut" required>
                                <input class="input_admin" type="time" name="heure_fin" required>
                            </div>

                            <div class="input2">
                                <input class="input_admin" type="number" name="nb_places" placeholder="Nombres de place" required>
                                <input class="input_admin" type="number" name="prix" placeholder="Prix" required>
                            </div>

                            <input class="input_com" type="text" name="description" placeholder="Description" required>
                            
                            <div class="submit">
                                <input class="input_admin" type="file" name="image" accept="image/jpeg, image/png, image/gif">
                                <input class="submit" type="submit" value="Ajouter">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ajout">
                    <h2 class="h2_admin" id="nouveautee_js">Ajouter des nouveautes</h2>
                    <div class="form_nouveautee">
                        <form action="verif_nouveaute.php" method="post" enctype="multipart/form-data">
                            <div class="input1">
                                <input class="input_admin" type="text" name="nom" placeholder="Nom" required>
                                <input class="input_admin" type="text" name="type" placeholder="type" required>
                                <input class="input_admin" type="text" name="Marque" placeholder="Marque" required>
                            </div>
                            <div class="iput2">
                                <input class="input_admin" type="date" name="date" placeholder="Date de sortie" required>
                                <input class="input_admin" type="number" name="prix" placeholder="prix" required>
                            </div>
                            <div class="submit">
                                <input class="input_admin" type="file" name="image" accept="image/jpeg, image/png, image/gif" required>
                                <input class="submit" type="submit" value="Ajouter">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ajout">
                    <h2 class="h2_admin" id="article_js">Ajouter des articles</h2>
                    <div class="form_article">
                        <form action="verif_article.php" method="post" enctype="multipart/form-data">
                            <div class="input1">
                                <input class="input_admin" type="text" name="nom" placeholder="Nom"required>
                                <input class="input_admin" type="text" name="type" placeholder="Type"required>
                            </div>
                            <div class="iput2">
                                <input class="input_admin" type="text" name="marque" placeholder="Marque"required>
                                <input class="input_admin" type="number" name="prix" placeholder="Prix"required>
                                <input class="input_admin" type="number" name="nb_article" placeholder="Nombre d\'article" required>
                            </div>
                            <div class="submit">
                                <input class="input_admin" type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
                                <input class="submit" type="submit" value="Ajouter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ';

        //
        // Affiche la gestion des utilisateurs
        //
        }else if($affichage == 'Membres'){

            $req = $bdd->prepare("SELECT droits FROM users WHERE email=:email"); 
            $req->execute([
                'email' => $_SESSION['email']
            ]); 
            $resultat = $req->fetch(PDO::FETCH_ASSOC);

            echo'
                <div id="page_admin_membres">
                    <div class="filtre">
                        <div  class="barre_de_recherche">
                            <input type="text" id="search-utilisatuer-input" oninput="searchUtilisateur()" placeholder="Nom de l\'utilisateur ">
                            <button class="bouttons" id="refresh" onclick="all_Utilisateur()"><img id="img_refresh" src="../images/refresh.png"></button>
                        </div>
                    </div>
                    <div class="container">
            ';
            
            
            $q = 'SELECT id, nom, email, droits, statut FROM users';
            $req = $bdd->query($q);
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
                        
            echo'
                <div id="afficher_profil">

                </div>

                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Droits</th>
                            <th>Statut</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tab_users">
            ';
                                
                    if($resultat ['droits']=="SuperAdmin"){
                        foreach ($results as $key => $user) {
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
                        foreach ($results as $key => $user) {
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
                 echo'               
                                </tbody>
                            </table>
                        </div>
                    </div>
                ';

        //    
        // Affiche la gestion des evenements 
        //
        }else if($affichage == 'Evenement'){
            echo'
                <div id="page_admin_membres">
                    <div class="filtre">
                        <div  class="barre_de_recherche">
                            <input type="text" id="search-utilisatuer-input" oninput="searchEvenement()" placeholder="Nom de l\'evenement ">
                            <button class="bouttons" id="refresh" onclick="all_evenement()"><img id="img_refresh" src="../images/refresh.png"></button>
                        </div>
                    </div>
                    <div class="container">
            ';
            
            
            $q = 'SELECT id, nom, ville, date_debut, heure_debut , adresse FROM evenement ORDER BY nom ASC';
            $req = $bdd->query($q);
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
                        
            echo'  
                <div id="msg_conf">
                </div>
                <div id="afficher_evenement">

                </div>

                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Date de debut - Heure de debut</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tab_evenement">
            ';
                                
                    
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

        //
        // Affiche la gestion des articles 
        //
        }else if($affichage == 'Article'){
            echo'
                <div id="page_admin_membres">
                    <div class="filtre">
                        <div  class="barre_de_recherche">
                            <input type="text" id="search-utilisatuer-input" oninput="searchArticle_admin()" placeholder="Nom de l\'article ">
                            <button class="bouttons" id="refresh" onclick="all_article_admin()"><img id="img_refresh" src="../images/refresh.png"></button>
                        </div>
                    </div>
                    <div class="container">
            ';
            
            
            $q = 'SELECT id, nom, type, marque, prix , proprio, secteur, image FROM article ORDER BY nom ASC';
            $req = $bdd->query($q);
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
                        
            echo'
                <div id="afficher_article">

                </div>

                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Marque</th>
                            <th>Type</th>
                            <th>Vendu par</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tab_article">
            ';
                                
                    
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
                        $req2 = $bdd->prepare("SELECT id, nom, prenom FROM users WHERE id=:id"); 
                        $req2->execute([
                            'id' => $user["proprio"]
                        ]); 
                        $resultat = $req2->fetch(PDO::FETCH_ASSOC);
                        
                        echo' <td>'. $resultat["nom"].' '.$resultat["prenom"] .'</td> ';
                        echo '<td>';
                        echo '<button class="bouttons" id="boutton_voir" onclick=voir_article('. $user['id'] .')>Consulter</button>';
                        echo '<button class="bouttons" id="boutton_voir" onclick=voir_commentaire('. $resultat['id'] .','. $user['proprio'] .')>Commentaires</button>';
                        echo '<button class="bouttons" id="boutton_supp" onclick=supp_article('. $user['id'] .')>Suprimmer</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                }
                echo '         
                                </tbody>
                            </table>
                        </div>
                    </div>
                ';
        //
        // Pour afficher les nouveaute
        //
        }else if($affichage == 'Nouveaute'){
            echo'
                <div id="page_admin_membres">
                    <div class="filtre">
                        <div  class="barre_de_recherche">
                            <input type="text" id="search-utilisatuer-input" oninput="search_nouveaute()" placeholder="Nom de la nouveaute ">
                            <button class="bouttons" id="refresh" onclick="all_nouveaute()"><img id="img_refresh" src="../images/refresh.png"></button>
                        </div>
                    </div>
                    <div class="container">
            ';
            
            
            $q = 'SELECT id, nom, marque, Date_sortie FROM nouveaute ORDER BY nom ASC';
            $req = $bdd->query($q);
            $results = $req->fetchAll(PDO::FETCH_ASSOC);
                        
            echo'
                <div id="afficher_nouveaute">

                </div>

                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Marque</th>
                            <th>Date de sortie</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tab_nouveaute">
            ';
                                
                    
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




    }




?>