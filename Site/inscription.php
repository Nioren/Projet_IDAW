<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="inscription-style.css">
</head>

<body>
    <div class="inscription-container mt-5">
        <h1>Inscription</h1>
        <form action="http://localhost/Projet_IDAW/Session/traitement_inscription.php" method="post">
            <label for="nom_utilisateur" class="inscription-container-label">Login:</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" class="inscription-container-input" required><br>
            <?php
        if (isset($_GET['error']) && $_GET['error'] === 'username_taken') {
            echo '<div class="alert alert-danger inscription-error" role="alert">Ce nom d\'utilisateur est déjà utilisé. Veuillez en choisir un autre.</div>';
        } elseif (isset($_GET['success'])) {
            echo '<div class="alert alert-success" role="alert">Inscription réussie !</div>';
        }
        ?><br></br>
            <label for="mot_de_passe" class="inscription-container-label">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" class="inscription-container-input" required><br>

            <label for="age" class="inscription-container-label">Age:</label>
            <input type="number" id="age" name="age" class="inscription-container-input" required><br>

            <label for="sport" class="inscription-container-label">Niveau Sportif:</label>
            <select id="sport" name="sport" class="inscription-container-input">
                <option value="faible">Peu Sportif</option>
                <option value="moyen">Moyennement Sportif</option>
                <option value="eleve">Très Sportif</option>
            </select><br>

            <input type="submit" value="Inscription" class="inscription-container-submit">
        </form>
    </div>
</body>

</html>
