<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <title>Ma page PHP</title>
    <style>
        body {
            background-color: #F6F7FA;
            margin: 0 0;
            font-family: Arial, sans-serif;

        }

        header {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
        }

        .nav_header {
            background-color: #AAA;
            color: white;
            padding: 15px 30px;
            margin: 0 0;
            display: flex;
            border: none;
        }

        .nav_header ul {
            display: flex;
            justify-content: right;
            list-style: none;
            margin: 0;
            padding: 0;
            margin-left: auto;
        }

        .nav_header li {
            margin: 0 10px;
            padding: 0.5em;
        }

        .nav_header a {
            text-decoration: none;
            color: black;
        }

        .nav_header a:hover {
            text-decoration: underline;
        }

        .nav_header a.active {
            font-weight: bold;
        }

        .nav_header .img_logo {
            display: flex;
            height: 40px;
            margin-right: 10px;
            justify-content: flex-start;
        }

        .nav_header .img_lien {
            height: 40px;
        }

        body.dark-mode {
            background-color: #333;
            color: #fff;
        }

        body.dark-mode .nav_header {
            background-color: #444;
        }

        body.dark-mode .nav_header a {
            color: #fff;
        }
    </style>
</head>

<body>
    <header>
        <nav class="nav_header">
            <a href="../index.php"><img class="img_logo" src="../images/logo.png"></a>
            <ul>
                <li><button id="darkModeToggle"><img class="img_lien" src="../images/darkk.png"></button></li>
                <li><a href="article.php"><img class="img_lien" src="../images/article.png"></a></li>
                <li><a href="nouveaute.php"><img class="img_lien" src="../images/nouveaute.png"></a></li>
                <li><a href="Evenement.php"><img class="img_lien" src="../images/evenement.png"></a></li>

                <?php
                if (isset($_SESSION['email'])) { // utilisateur connecté

                    echo '<li ><a  href="panier.php"><img class="img_lien" src="../images/pix3.png"></a></li>';
                    echo '<li ><a  href="envoi.php"><img class="img_lien" src="../images/pix1.png"></a></li>';

                    include("../includes/bdd.php");
                    $req = $bdd->prepare("SELECT nom, image FROM users WHERE email=:email");
                    $req->execute([
                        'email' => $_SESSION['email']
                    ]);
                    $resultat = $req->fetch(PDO::FETCH_ASSOC);

                    if ($resultat) {
                        if ($resultat['nom'] == "Sananes") {
                            echo '<li ><a  href="profil.php"><img class="img_lien" src="../images/c.png"></a></li>';
                        } else if ($resultat['nom'] == "Delon") {
                            echo '<li ><a  href="profil.php"><img class="img_lien" src="../images/sql.png"></a></li>';
                        } else {
                            $imagePath = 'uploads/' . $resultat['image'];
                            echo '<li ><a  href="profil.php"><img class="img_lien" src="' . $imagePath . '"></a></li>';
                        }
                    } else {
                        echo '<li ><a href="connexion.php"><img class="img_lien" src="../images/pix4.png"></a></li>';
                    }
                } else {
                    echo '<li ><a href="connexion.php"><img class="img_lien" src="../images/pix4.png"></a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <script>
        var darkMode = false;

        document.getElementById('darkModeToggle').addEventListener('click', function() {
            darkMode = !darkMode;

            if (darkMode) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });
    </script>
</body>

</html>