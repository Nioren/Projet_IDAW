<!DOCTYPE html>
<html lang="en">
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
                // Vérifie si une session est en cours
                session_start();
                if (isset($_SESSION['username'])) {
                    echo "Bonjour, " . $_SESSION['username'];
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
