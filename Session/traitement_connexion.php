<?php
include 'config.php';
include 'session.php';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Sélectionner les champs 'id_user' et 'mot_de_passe'
$query = "SELECT id_user, mot_de_passe FROM utilisateur WHERE nom_utilisateur = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);

// Récupérer la première ligne du résultat
$row = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($row);  // Ajoutez cette ligne pour afficher le contenu de $row

if ($row) {
    // Comparer les mots de passe en texte brut
    if ($mot_de_passe == $row['mot_de_passe']) {
        // Authentification réussie
        loginUser($row['id_user'], $username);
        header("Location: http://localhost/Projet_IDAW/Site/profil.php");
        exit(); // Assurez-vous de terminer l'exécution après la redirection
    } else {
        echo "Mot de passe incorrect";
    }
} else {
    echo "Nom d'utilisateur non trouvé";
}

} else {
    echo "Mauvaise méthode de requête";
}
