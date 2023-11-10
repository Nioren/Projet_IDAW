<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>

<body>
    <h1>Inscription</h1>
    <form action="http://localhost/Projet_IDAW/Session/traitement_inscription.php" method="post">
        <label for="nom_utilisateur">Login:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

        <label for="age">Age:</label>
        <input type="int" id="age" name="age" required><br>

        <label for="sport">Niveau Sportif:</label>
        <select id="sport" name="sport">
            <option value="faible">Peu Sportif</option>
            <option value="moyen">Moyennement Sportif</option>
            <option value="eleve">Très Sportif</option>
        </select><br>

        <input type="submit" value="Inscription">
    </form>
</body>

</html>