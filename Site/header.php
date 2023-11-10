<!DOCTYPE html>
<html lang="en">

<?php
// Inclure vos fichiers et fonctions nécessaires
include 'config.php';
include 'session.php';

// Vérifier si la session est déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bandeau</title>
</head>

<body>

    <header>
        <div class="container">
            <div class="logo">Votre Logo</div>

            <div class="nav">
                <a href="liste_plat.php">Liste des Plats</a>
                <a href="profil.php">Profil</a>
            </div>

            <div class="user-info">
                <?php
                // Vérifie si l'utilisateur est connecté
                if (isUserLoggedIn()) {
                    echo "Bonjour, " . getLoggedInUsername();
                } else {
                    echo '<a href="connexion.php">Connexion</a>';
                    echo '<a href="inscription.php">Inscription</a>';
                }
                ?>
            </div>
        </div>
    </header>

</body>

</html>
