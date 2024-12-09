<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/inscription.css">
    <title>Inscription</title>

</head>
	<body>

		<?php include('../includes/header.php'); ?>

		<main>
			<div class="container">
				<form action="verification_inscription.php" method="post" enctype="multipart/form-data">
                    <h2 style="text-align: left;">Je crée un compte</h2>
                    <input type="text" name="nom" placeholder="Nom" style="width: 100%;" class="inputCss">
					<input type="text" name="prenom" placeholder="Prenom" style="width: 100%;" class="inputCss">

					<input type="text" name="ville" placeholder="Ville" style="width: 100%;" class="inputCss">
					<input type="text" name="adresse" placeholder="Adresse" style="width: 100%;" class="inputCss">
                    <input type="text" name="code_postal" placeholder="Code Postal" style="width: 100%; margin-top: 2%;" class="inputCss">

                    <input type="mail" name="email" placeholder="E-mail" style="width: 100%; margin-top: 2%;" class="inputCss">
					<input type="text" name="num_phone" placeholder="Numero de telephone" style="width: 100%; margin-top: 2%;" class="inputCss">
                    	
                    <input type="password" name="password1" placeholder="Mot de passe" style="width: 100%; margin-top: 2%;" class="inputCss">
					<input type="password" name="password2" placeholder="Confirmer le mot de passe" style="width: 100%; margin-top: 2%;" class="inputCss">

                    <div style="display:flex;  margin-top: 2%;">
                        <span style="font-weight: bold; align-self: flex-start;">Image de profil:</span>
                    <input name="image" type="file" id="image">
                    </div>
                    
                    <input type="submit" style="width: 100%; margin-top: 2%; background-color: #4CAF50; color: white; border:none;" value="Inscription" class="inputCss">
                </form>
			</div>
		</main>

	</body>
</html>