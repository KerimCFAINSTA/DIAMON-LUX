
<?php
session_start(); // démarrer la session s'il n'est pas déjà démarré
session_unset(); // supprimer toutes les variables de session
session_destroy(); // détruire la session
header("Location: ../index.php"); // rediriger vers la page de connexion
exit(); // arrêter l'exécution du script
?>