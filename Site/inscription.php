<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>

<body>
    <h1>Inscription</h1>
    <form action="traitement_inscription.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

        <label for="date_naissance">Date de Naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br>

        <label for="niveau_sportif">Niveau Sportif:</label>
        <select id="niveau_sportif" name="niveau_sportif">
            <option value="faible">Peu Sportif</option>
            <option value="moyen">Moyennement Sportif</option>
            <option value="eleve">Très Sportif</option>
        </select><br>

        <input type="submit" value="Inscription">
    </form>
</body>

</html>