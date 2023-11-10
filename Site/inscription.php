<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>

<body>
    <div class="container mt-5">
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'username_taken') {
            echo '<div class="alert alert-danger" role="alert">Ce nom d\'utilisateur est déjà utilisé. Veuillez en choisir un autre.</div>';
        }
        elseif (isset($_GET['success'])) {
            echo '<div class="alert alert-success" role="alert">Inscription réussie !</div>';
        }
        ?>
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