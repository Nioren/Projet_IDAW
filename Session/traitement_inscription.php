<?php
include 'config.php';
include 'session.php';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $age = $_POST['age'];
    $sport = $_POST['sport'];

    $query = "SELECT * FROM utilisateur WHERE nom_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        header("Location: http://localhost/Projet_IDAW/Site/inscription.php?error=username_taken");
        exit();
    }
    $query = "INSERT INTO utilisateur (nom_utilisateur, mot_de_passe, age, sport) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $mot_de_passe, $age, $sport]);

    header("Location: http://localhost/Projet_IDAW/Site/inscription.php?success=1");
} else {
    header("Location: http://localhost/Projet_IDAW/Site/inscription.php");
}
?>
