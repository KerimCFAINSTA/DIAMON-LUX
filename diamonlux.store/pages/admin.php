
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Page Administration</title>

</head>
<body>
<?php include("../includes/header.php") ?>
<main>
    <?php 
        if( !empty($_SESSION['email'])){
            include("../includes/bdd.php");
                
            $req = $bdd->prepare("SELECT droits FROM users WHERE email=:email"); 
            $req->execute([
                'email' => $_SESSION['email']
            ]); 
            $resultat = $req->fetch(PDO::FETCH_ASSOC);

            if($resultat['droits'] == "utilisateur"){
                header('location: index.php');
                exit;
            }
        }else{
            header('location: index.php');
            exit;
        }
    ?>
    <h1 class="h1_admin">Page d'administration</h1>
     <h3> <a href="../newsLetter/mail.php">PHP Mailer</a></h3>
    <div class="menu">
       
        <h3 class="h1_admin" class="adminMenu" id="AdministrationMenbre" onclick="Administration('Membres')">Voir les membres</h3>
        <h3 class="h1_admin" class="adminMenu" id="AdministrationAjout" onclick="Administration('Ajout')"  >Ajout d'elements</h3>
        <h3 class="h1_admin" class="adminMenu" id="AdministrationAjout" onclick="Administration('Evenement')"  >Voir evenement</h3>
        <h3 class="h1_admin" class="adminMenu" id="AdministrationAjout" onclick="Administration('Article')"  >Voir article</h3>
        <h3 class="h1_admin" class="adminMenu" id="AdministrationAjout" onclick="Administration('Nouveaute')">Voir nouveaute </h3>
    </div>
    <div id="administration">

    
    
    </div>
    <script src="../Java-Script/admin.js"></script>
</main>
<?php include("../includes/footer.php") ?>
</body>
</html>