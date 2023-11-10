<?php
include 'session.php';

// Fermer la session
logoutUser();

// Rediriger vers la page de connexion ou une autre page de votre choix
header("Location: http://localhost/Projet_IDAW/Site/connexion.php");
exit();
?>
