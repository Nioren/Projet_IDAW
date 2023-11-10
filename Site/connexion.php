<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="connexion-container">
        <h1>Connexion</h1>
        <form action="http://localhost/Projet_IDAW/Session/traitement_connexion.php" method="post">
            <label for="nom_utilisateur">Login:</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <input type="submit" value="Connexion">
        </form>
        <p>Pas de compte? <a href="http://localhost/Projet_IDAW/Site/inscription.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>

</html>
