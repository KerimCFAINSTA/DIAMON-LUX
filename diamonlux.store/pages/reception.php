<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  margin: 0;
  padding: 0;
}

a {
  text-decoration: none;
  color: #333333;
}

a:hover {
  text-decoration: underline;
}

h3 {
  margin-bottom: 20px;
  text-align: center;
}

.bloc {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #ffffff;
  border: 1px solid #ccc;
}

.titre {
  display: inline-block;
  font-size: 18px;
  font-weight: bold;
  padding: 5px 10px;
  background-color: #333333;
  color: #ffffff;
  text-align: center;
  margin-bottom: 20px;
}

.empty-message {
  text-align: center;
  margin-bottom: 20px;
  color: #666666;
}

.sender {
  font-weight: bold;
}

.separator {
  margin-top: 10px;
  margin-bottom: 20px;
  border-top: 1px solid #ccc;
}

</style>

<?php
session_start();
  $bdd = new PDO('mysql:host=localhost;dbname=diamonlux', 'root', '');

if(isset($_SESSION['email']) AND !empty($_SESSION['email'])) {
    $msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ?');
    $msg->execute(array($_SESSION['email']));
    $msg_nbr = $msg->rowCount(); 
?>
<!DOCTYPE html>

<html>
<head>
<?php include("../includes/header.php"); ?>
    <title>Boite de reception</title>
    <meta charset="utf-8" />
</head>
<body>
<a href="envoi.php">Nouveau message</a><br /><br /><br />
   <h3>Votre boite de reception:</h3>
<?php 
if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
while($m = $msg->fetch()) { 
    $p_exp = $bdd->prepare('SELECT nom FROM users WHERE email = ?');
    $p_exp->execute(array($m['id_expediteur']));
    $p_exp = $p_exp->fetch();
    $p_exp = $p_exp['nom'];
    ?>
    <b><?= $p_exp ?></b> vous a envoye: <br />
    <?= nl2br($m['message']) ?><br />
   -------------------------------------<br/>
    <?php } ?>
</body>
</html>
<?php } ?>