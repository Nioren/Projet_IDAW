<?php
include 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $query = "SELECT * FROM utilisateur WHERE nom_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            loginUser($row['id_user'], $username);
            header("Location: http://localhost/Projet_IDAW/Site/profil.php");
        } else {
            header("Location: http://localhost/Projet_IDAW/Site/connexion.php?error=1");
        }
    } else {
        header("Location: http://localhost/Projet_IDAW/Site/connexion.php?error=1");
    }
} else {
    header("Location: http://localhost/Projet_IDAW/Site/connexion.php");
}

?>