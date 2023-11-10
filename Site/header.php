<!DOCTYPE html>
<html lang="en">

<?php
// Inclure vos fichiers et fonctions nécessaires

// Vérifier si la session est déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous d'ajuster le chemin selon votre structure -->
    <title>Bandeau</title>
</head>

<body>

    <header>
        <div class="container">
            <div class="logo">NutriSite</div>

            <div class="nav">
                <a href="liste_plat.php">Liste des Plats</a>
                <a href="profil.php">Profil</a>
            </div>

            <div class="user-info">
                <?php
                // Vérifie si l'utilisateur est connecté
                if (isset($_SESSION['id_user'])) {
                    echo "Bonjour, " . $_SESSION['nom_utilisateur'];
                    echo '<button class="logout-btn" onclick="window.location.href=\'http://localhost/Projet_IDAW/Session/deconnexion.php\'">Déconnexion</button>';
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
