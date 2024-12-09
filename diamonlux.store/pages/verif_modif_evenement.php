<?php

    if(!empty($_GET['id'])){

        $id = $_GET['id'];

        include("../includes/bdd.php");

        if(!empty($_POST['nom'])){
            $q = 'UPDATE evenement SET nom = :nom WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'nom' => $_POST['nom'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['lieu'])){
            $q = 'UPDATE evenement SET Ville = :ville WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'ville' => $_POST['lieu'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['adresse'])){
            $q = 'UPDATE evenement SET adresse = :adresse WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'adresse' => $_POST['adresse'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['date_debut'])){

            $date_actuelle = new DateTime();
            $test_date_debut = new DateTime($_POST['date_debut']);

            if($test_date_debut > $date_actuelle){
                $q = 'UPDATE evenement SET date_debut = :date_debut WHERE id=:id'; 
                $req = $bdd-> prepare($q); 
                $req->execute([
                    'date_debut' => $_POST['date_debut'], 
                    'id' => $id
                ]); 
            }

        }

        if(!empty($_POST['date_fin'])){
            $q = 'UPDATE evenement SET date_fin = :date_fin WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'date_fin' => $_POST['date_fin'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['heure_debut'])){
            $q = 'UPDATE evenement SET heure_debut = :heure_debut WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'heure_debut' => $_POST['heure_debut'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['heure_fin'])){
            $q = 'UPDATE evenement SET heure_fin = :heure_fin WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'heure_fin' => $_POST['heure_fin'], 
                'id' => $id
            ]);

        }

        if(!empty($_POST['nb_place'])){
            if($_POST['nb_place']>0){
                $q = 'UPDATE evenement SET nb_place = :nb_place WHERE id=:id'; 
                $req = $bdd-> prepare($q); 
                $req->execute([
                    'nb_place' => $_POST['nb_place'], 
                    'id' => $id
                ]);
            }

        }

        if(!empty($_POST['prix'])){
            if($_POST['prix']>=0){
                $q = 'UPDATE evenement SET prix = :prix WHERE id=:id'; 
                $req = $bdd-> prepare($q); 
                $req->execute([
                    'prix' => $_POST['prix'], 
                    'id' => $id
                ]);
            }

        }

        if(!empty($_POST['description'])){
            $q = 'UPDATE evenement SET description = :description WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'description' => $_POST['description'], 
                'id' => $id
            ]);

        }

        if (!empty($_FILES['image']) && $_FILES['image']['error'] != 4) {
            // Vérifier que le fichier est du bon type
            $acceptable = ['image/jpeg', 'image/gif', 'image/png'];
            // Si le type de fichier n'est pas dans le tableau $acceptable : redirection vers le formulaire avec une erreur.
            if (!in_array($_FILES['image']['type'], $acceptable)) {
                header('location: admin.php?message=Type d\'image incorrect.&type=danger');
                exit;
            }
            
            // Vérifier que le fichier n'est pas trop lourd
            $maxSize = 5 * 1024 * 1024; // 5Mo
            
            // Si la taille du fichier est supérieure au max autorisé : redirection vers le formulaire
            if ($_FILES['image']['size'] > $maxSize) {
                header('location: admin.php?message=L\'image ne doit pas dépasser 5Mo&type=danger');
                exit;
            }
            
            // Si le dossier "uploads" n'existe pas, le créer
            $path = 'uploads';
            if (!file_exists($path)) {
                mkdir($path, 0777); // chmod 777
            }
        
            // Enregistrer le fichier sur le serveur
            $filename = $_FILES['image']['name'];
            $array = explode('.', $filename); // découper le nom selon les points
            $extension = end($array); // récupérer le dernier élément du tableau
            $filename = 'image-' . time() . '.' . $extension;
            $destination = $path . '/' . $filename;
            
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        
            // Mettre à jour le nom de l'image dans la base de données
            $q = 'UPDATE evenement SET image = :image WHERE id = :id';
            $req = $bdd->prepare($q); 
            $reponse = $req->execute([
                'image' => $filename,
                'id' => $id
            ]);
        }

        $msg = 'Evenement modifié avec succès !!';
        header('location: admin.php?message=' . $msg);
        exit;

    }

?>