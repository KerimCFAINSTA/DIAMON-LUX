<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$email = new PHPMailer();
$email-> SMTPDebug = 2; 
$email->IsSMTP();
$email->Host = 'smtp.office365.com';
$email->Port = '587';
$email->SMTPAuth = 1;
$email->CharSet = 'UTF-8';
if($email->SMTPAuth){
   $email->SMTPSecure = 'tls';
   $email->Username   =  'diamonlux@outlook.fr';
   $email->Password   = 'azerty11';
}
$email->From = trim('diamonlux@outlook.fr');
$email->AddAddress(trim($_POST["email"]));
$email->setFrom('diamonlux@outlook.fr', 'DiamonLux.Store');
$email->Subject = 'votre adresse email est validé ';
$email->Body = 'Merci de confirmer votre adresse e-mail en cliquant sur ce lien : ' ;

if (!$email->send()) {
      echo "$email->ErrorInfo;";
} else{
      echo '<p class="alert alert-danger" role="alert">Un mail vous a été envoyé. ';
}

?>