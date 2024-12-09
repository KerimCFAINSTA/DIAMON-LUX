<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <title>DiamonLux accueil</title>
</head>

<body>
  <style>
    body {
      background-color: #F6F7FA;
      margin: 0 0;
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
  </style>
  <header>
    <?php session_start() ?>
    <nav class="nav_header">
      <a href="index.php"><img class="img_logo" src="images/logo.png"></a>
      <ul>
        <li><button id="darkModeToggle"><img class="img_lien" src="../images/darkk.png"></button></li>
        <li><a href="pages/article.php"><img class="img_lien" src="images/article.png"></a></li>
        <li><a href="pages/nouveaute.php"><img class="img_lien" src="images/nouveaute.png"></a></li>
        <li><a href="pages/Evenement.php"><img class="img_lien" src="images/evenement.png"></a></li>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        if (isset($_SESSION['email'])) { // utilisateur connecté

          echo '<li ><a  href="pages/panier.php"><img class="img_lien" src="images/pix3.png"></a></li>';
          echo '<li ><a  href="pages/envoi.php"><img class="img_lien" src="images/pix1.png"></a></li>';

          include("includes/bdd.php");
          $req = $bdd->prepare("SELECT nom, image FROM users WHERE email=:email");
          $req->execute([
            'email' => $_SESSION['email']
          ]);
          $resultat = $req->fetch(PDO::FETCH_ASSOC);

          if ($resultat && $resultat['nom'] == "Sananes") {
            echo '<li ><a  href="pages/profil.php"><img class="img_lien" src="images/c.png"></a></li>';
          } else if ($resultat && $resultat['nom'] == "Delon") {
            echo '<li ><a  href="pages/profil.php"><img class="img_lien" src="images/sql.png"></a></li>';
          } else {
            if ($resultat) {
              $imagePath = 'pages/uploads/' . $resultat['image'];
              echo '<li ><a  href="pages/profil.php"><img class="img_lien" src="' . $imagePath . '"></a></li>';
            }
          }
        } else {
          echo '<li ><a href="pages/connexion.php"><img class="img_lien" src="images/pix4.png"></a></li>';
        }
        ?>
      </ul>
    </nav>
  </header>
  <main>
    <div class="a_propo">
      <h1 class="apropo_h1">Bienvenue sur DIAMONLUX</h1>
      <p>Site de vente et d'evenementiel dans l'univers de la mode</p>
      <div class="nav_apropo">
        <a href="pages/article.php">Article</a>
        <a href="pages/nouveaute.php">Nouveaute</a>
        <a href="pages/Evenement.php">Evenement</a>
      </div>
    </div>

    <div class="exemple">
      <?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);

      include("includes/bdd.php");

      $reponse = $bdd->query("SELECT MAX(id) FROM evenement");
      $choix_nb = $reponse->fetch(PDO::FETCH_NUM);
      $choix_nb = $choix_nb[0];

      $max_boucle = 0;
      do {
        $nombre_aleatoire = rand(1, $choix_nb);

        $reponse2 = $bdd->query("SELECT nom, date_debut, description, Ville, image FROM evenement WHERE id = $nombre_aleatoire");
        $donnees = $reponse2->fetch(PDO::FETCH_ASSOC);

        $max_boucle++;
      } while (empty($donnees) && $max_boucle <= 50);


      $reponse = $bdd->query("SELECT MAX(id) FROM nouveaute");
      $choix_nb2 = $reponse->fetch(PDO::FETCH_NUM);
      $choix_nb2 = $choix_nb2[0];

      $max_boucle = 0;
      do {
        $nombre_aleatoire2 = rand(1, $choix_nb2);

        $reponse2 = $bdd->query("SELECT nom, Marque, Type, Prix, image FROM nouveaute WHERE id = $nombre_aleatoire2");
        $donnees2 = $reponse2->fetch(PDO::FETCH_ASSOC);

        $max_boucle++;
      } while (empty($donnees2) && $max_boucle <= 50);

      ?>

      <div class="ex_nouveaute">
        <h2 class="h2_ex">Nouveaute</h2>
        <?php

        if (!empty($donnees2)) {
          $imagePath = 'pages/uploads/' . $donnees2['image'];
          echo '
                          <div class="ex_image">
                              <img class="ex_img" src="' . $imagePath . '">
                          </div>
                          
                          <div class="ex_info">
                              <h3>' . $donnees2['nom'] . '</h3>
                              <div class="info_p">
                                  <p>' . $donnees2['Type'] . '</p>
                                  <p>' . $donnees2['Prix'] . '€</p>
                              </div>
                          </div>
                      ';
        }
        ?>

      </div>

      <div class="ex_evenement">
        <h2 class="h2_ex">Evenement</h2>
        <?php

        if (!empty($donnees)) {
          if (!empty($donnees['image'])) {
            $imagePath = 'pages/uploads/' . $donnees['image'];
            echo '
                            <div class="ex_image">
                                <img class="ex_img" src="' . $imagePath . '">
                            </div>
                            <div class="ex_info">
                                <h3>' . $donnees['nom'] . '</h3>
                                <div class="info_p">
                                    <p>A ' . $donnees['Ville'] . '</p>
                                </div>
                            </div>
                        ';
          } else {
            echo '
                            <div class="ex_info">
                                <h3>' . $donnees['nom'] . '</h3>
                                <div class="info_p">
                                    <p>A ' . $donnees['Ville'] . '</p>
                                </div>
                            </div>
                        ';
          }
        }
        ?>
      </div>

    </div>
  </main>
  <style>
    footer {
      background-color: #AAA;
      color: black;
      padding: 20px;
      text-align: center;
    }

    footer a {
      color: black;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>


  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2023 diamonlux.store . Tous droits reserves.</p>
        </div>
        <div class="col-md-6">
          <nav>
            <a href="apropo.html">A propo de nous</a></li>
          </nav>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>