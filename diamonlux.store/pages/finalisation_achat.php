<?php
    if(isset($_GET['id'])){

        include("../includes/bdd.php");

        session_start();
        $req = $bdd->prepare("SELECT id FROM users WHERE email=:email"); 
        $req->execute([
            'email' => $_SESSION["email"]
        ]); 
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        
        $idE=$_GET['id'];
        $idU=$resultat['id'];
       

        if(!empty( $_POST["nom1"]) && !empty( $_POST["prenom1"])){
            $nom1 = $_POST["nom1"];
            $prenom1 = $_POST["prenom1"];

            $q = 'INSERT INTO participants (id_utilisateur, id_evenement, nom, prenom) VALUES (:idU, :idE, :nom, :prenom)';
            $req = $bdd-> prepare($q); 
            $req->execute([
                "idU" => $idU,
                "idE" => $idE,
                "nom" => $nom1,
                "prenom" => $prenom1
            ]); 

            $q2 = 'UPDATE evenement SET nb_place=nb_place-1 WHERE id=:idE';
            $req2 = $bdd-> prepare($q2); 
            $req2->execute([
                "idE" => $idE
            ]); 
                
        }

        if(!empty( $_POST["nom2"]) && !empty( $_POST["prenom2"])){
            $nom2 = $_POST["nom2"];
            $prenom2 = $_POST["prenom2"];

            $q = 'INSERT INTO participants (id_utilisateur, id_evenement, nom, prenom) VALUES (:idU, :idE, :nom, :prenom)';
            $req = $bdd-> prepare($q); 
            $req->execute([
                "idU" => $idU,
                "idE" => $idE,
                "nom" => $nom2,
                "prenom" => $prenom2
            ]); 
            
            $q2 = 'UPDATE evenement SET nb_place=nb_place-1 WHERE id=:idE';
            $req2 = $bdd-> prepare($q2); 
            $req2->execute([
                "idE" => $idE
            ]); 

            
        }

        if(!empty( $_POST["nom3"]) && !empty( $_POST["prenom3"])){
            $nom3 = $_POST["nom3"];
            $prenom3 = $_POST["prenom3"];

            $q = 'INSERT INTO participants (id_utilisateur, id_evenement, nom, prenom) VALUES (:idU, :idE, :nom, :prenom)';
            $req = $bdd-> prepare($q); 
            $req->execute([
                "idU" => $idU,
                "idE" => $idE,
                "nom" => $nom3,
                "prenom" => $prenom3
            ]); 
            
            $q2 = 'UPDATE evenement SET nb_place=nb_place-1 WHERE id=:idE';
            $req2 = $bdd-> prepare($q2); 
            $req2->execute([
                "idE" => $idE
            ]); 
            
            
        }

        if(!empty( $_POST["nom4"]) && !empty( $_POST["prenom4"])){
            $nom4 = $_POST["nom4"];
            $prenom4 = $_POST["prenom4"];

            $q = 'INSERT INTO participants (id_utilisateur, id_evenement, nom, prenom) VALUES (:idU, :idE, :nom, :prenom)';
            $req = $bdd-> prepare($q); 
            $req->execute([
                "idU" => $idU,
                "idE" => $idE,
                "nom" => $nom4,
                "prenom" => $prenom4
            ]); 
            
            $q2 = 'UPDATE evenement SET nb_place=nb_place-1 WHERE id=:idE';
            $req2 = $bdd-> prepare($q2); 
            $req2->execute([
                "idE" => $idE
            ]); 
            
            
        }

        header("location:Evenement.php?Vous avez rejoins l\'evenement avec success");

        exit;
    }

?>