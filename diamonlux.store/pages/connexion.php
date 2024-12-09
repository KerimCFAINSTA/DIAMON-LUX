
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/connexion.css">
    <title>Connexion</title>

</head>
<body>
<?php //include("../includes/header.php") ?>
<main>
    <div class="section1">
        <h2 class="h2_connexion" id="txt">Connexion</h2>
        <div class="formCo">
            <form id="connexion" method="post" action="verification.php" enctype="multipart/form-data" onsubmit="return result();">
                    <h3 class="mail" id="txt">Adresse-mail:</h3>
                    <input type="email" id="mail-input" class="input-co" name="email" required>

                    <h3 class="mdp" id="txt">Mot de passe:</h3>
                    <input type="password" id="mdp-input" class="input-co" name="password" required>
                    <br>

                    <h3 class="testBot" id="txt" onclick="verif()">Etes vous un robot ?</h1>

                    
                    <div class="captcha" id="captchacont">
                        <table class="table_connexion">
                                <tr>
                                    <div class="img">
                                        <td><img class="img_connexion" id=image0 src="" alt="cpatcha img" onclick="selection(0)"></td>
                                        <td><img class="img_connexion" id=image1 src="" alt="cpatcha img" onclick="selection(1)"></td>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="img">
                                        <td><img class="img_connexion" id=image2 src="" alt="cpatcha img" onclick="selection(2)"></td>
                                        <td><img class="img_connexion" id=image3 src="" alt="cpatcha img" onclick="selection(3)"></td>
                                    </div>
                                </tr>
                        </table>
                        <br> 
                    </div>

                    <button id="button" type="submit" name="submit1" id="btn">Se Connecter</button>   
            </form>
            <div class="inscription">
                <p id="no-account">Pas de comptee ?</p>
                <a href="inscription.php" id="inscription-link">S'inscrire</a>
            </div>

        </div>
    </div>

    <script src="../captcha/captcha.js"></script>
</main>

</body>

</html>



