<?php

    if(!empty($_GET['id'])){

        $id = $_GET['id'];

        include("../includes/bdd.php");

        

        if(!empty($_POST['nom'])){
            $q = 'UPDATE nouveaute SET nom = :nom WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'nom' => $_POST['nom'], 
                'id' => $id
            ]); 

        }

        if(!empty($_POST['type'])){
            $q = 'UPDATE article SET type = :type WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'type' => $_POST['type'], 
                'id' => $id
            ]);
            
        }

        if(!empty($_POST['marque'])){
            $q = 'UPDATE nouveaute SET marque = :marque WHERE id=:id'; 
            $req = $bdd-> prepare($q); 
            $req->execute([
                'marque' => $_POST['marque'], 
                'id' => $id
            ]);
            
        }

        if(!empty($_POST['prix'])){
            if($_POST['prix']>0){
                $q = 'UPDATE nouveaute SET prix = :prix WHERE id=:id'; 
                $req = $bdd-> prepare($q); 
                $req->execute([
                    'prix' => $_POST['prix'], 
                    'id' => $id
                ]);
            }
            
        }

        if(!empty($_POST['date'])){
            $date_actuelle = new DateTime();
            $test_date = new DateTime($_POST['date']);

            if($test_date > $date_actuelle){
                $q = 'UPDATE nouveaute SET Date_sortie = :Date_sortie WHERE id=:id'; 
                $req = $bdd-> prepare($q); 
                $req->execute([
                    'Date_sortie' => $_POST['date'], 
                    'id' => $id
                ]);
            }

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
            $q = 'UPDATE nouveaute SET image = :image WHERE id = :id';
            $req = $bdd->prepare($q); 
            $reponse = $req->execute([
                'image' => $filename,
                'id' => $id
            ]);
        }

        $msg = 'Article modifié avec succès !!';
        header('location: admin.php?message=' . $msg);
        exit;

    }

?>