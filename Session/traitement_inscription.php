<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nom_utilisateur'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $age = $_POST['age'];
    $sport = $_POST['sport'];

    $query = "INSERT INTO utilisateur (nom_utilisateur, mot_de_passe, age, sport) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $mot_de_passe, $age, $sport]);

    header("Location: http://localhost/Projet_IDAW/Site/inscription.php?success=1");
} else {
    header("Location: http://localhost/Projet_IDAW/Site/inscription.php");
}
?>