<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
}

form {
  width: 400px;
  margin: 0 auto;
}

label {
  display: block;
  margin-bottom: 10px;
}

select,
textarea {
  width: 100%;
  padding: 5px;
  margin-bottom: 10px;
}

input[type="submit"] {
  padding: 10px 20px;
  background-color: #333333;
  color: #ffffff;
  border: none;
  cursor: pointer;
}

span {
  color: red;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
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

b {
  font-weight: bold;
}

br {
  margin-bottom: 10px;
}

hr {
  border: none;
  border-top: 1px solid #ccc;
  margin: 20px 0;
}

.message {
  padding: 10px;
  background-color: #ffffff;
  border: 1px solid #ccc;
  margin-bottom: 20px;
  text-align: center;
}

.titre {
  display: inline-block;
  font-size: 40px;
  font-weight: bold;
  padding: 5px 10px;
  background-color: #333333;
  color: #ffffff;
  width: auto;
}



</style>

  <?php

session_start();
  
  $bdd = new PDO('mysql:host=localhost;dbname=diamonlux', 'root', '');

if(isset($_SESSION['email']) AND !empty($_SESSION['email'])) {
if(isset($_POST['envoi_message'])) {
    if(isset($_POST['destinataire'],$_POST['message']) AND !empty($_POST['destinataire']) AND !empty($_POST['message'])) {
        $destinataire = htmlspecialchars($_POST['destinataire']);
         $message = htmlspecialchars($_POST['message']);

         $id_destinataire = $bdd->prepare('SELECT email FROM users WHERE nom = ?');
          $id_destinataire->execute(array($destinataire));
          $dest_exist = $id_destinataire->rowCount();
          if($dest_exist == 1) {
            $id_destinataire = $id_destinataire->fetch();
            $id_destinataire = $id_destinataire['email'];
  
            $ins = $bdd->prepare('INSERT INTO messages(id_expediteur,id_destinataire,message) VALUES (?,?,?)');
            $ins->execute(array($_SESSION['email'],$id_destinataire,$message));
            $error = "Votre message a bien �t� envoy� !";
  
          }else {
            $error = "Cet utilisateur n'existe pas...";
          }

         
    }else{
        $error = "Veuillez compl�ter tout les champs";
    }
}

$destinataires = $bdd->query('SELECT nom FROM users ORDER BY nom');

?>

<!DOCTYPE html>
   <html>
   <head>
   <?php include("../includes/header.php"); ?>
      <title>Envoi de message</title>
      <meta charset="utf-8" />
   </head>
   <body>
      <form method="POST">
         <label>Destinataire:</label>
         <select name="destinataire">
         <?php while($d = $destinataires->fetch()) { ?>
        <option><?= $d['nom'] ?></option>
        <?php } ?>
            
        </select>
        <br /><br />
         <textarea placeholder="Votre message" name="message"></textarea>
         <br /><br />
         <input type="submit" value="Envoyer" name="envoi_message" />
        <br /><br />
        <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } ?>
      </form>
      <br />
   
      <a href="reception.php" class=titre>Boite de reception</a>
</body>
</html>
<?php
}
?>


          
