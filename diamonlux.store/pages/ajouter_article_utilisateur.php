<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/ajouter_article_utilisateur.css">
    <title>Ajouter un Article</title>
</head>
<?php include("../includes/header.php") ?>
<body>
<main>
    <?php 
        if(empty($_SESSION['email'])){
            header('location: index.php');
            exit;
        }
    ?>
    <h1 class="h1">AJOUTER UN ARTICLE</h1>

    <div class="add_article">
        <form action="verif_article_utilisateur.php" method="post" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom" required>
            <div style="display: flex; align-items: center; gap: 5px;">
                <button type="button" class="select_button">Sélectionner</button>
                <input type="text" name="type" placeholder="Type" required>
            </div>
            <div style="display: flex; align-items: center; gap: 5px;">
                <button type="button" class="select_button">Sélectionner</button>
                <input type="text" name="marque" placeholder="Marque" required>
            </div>
            <input type="number" name="prix" placeholder="Prix" required>
            <input type="text" name="secteur" placeholder="Ville de vente" required>
            <input type="text" name="etat" placeholder="État" required>
            <input type="text" name="couleur" placeholder="Couleur" required>
            <div style="display:flex; gap:5px;">
                <label for="image" class="add_img">Image:</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" required>
            </div>
            <input class="submit" type="submit" value="Ajouter">
        </form>
    </div>
</main>
<?php include("../includes/footer.php") ?>
</body>
</html>