<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>
    <h1>Connexion</h1>
    <form action="http://localhost/Projet_IDAW/Session/traitement_connexion.php" method="post">
        <label for="nom_utilisateur">Login:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

        <input type="submit" value="Connexion">
    </form>
</body>

</html>