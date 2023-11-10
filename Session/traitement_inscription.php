<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $motDePasse = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $dateNaissance = $_POST['date_naissance'];
    $niveauSportif = $_POST['niveau_sportif'];

    $query = "INSERT INTO utilisateurs (login, mot_de_passe, date_naissance, niveau_sportif) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$login, $motDePasse, $dateNaissance, $niveauSportif]);

    header("Location: http://localhost/Projet_IDAW/Site/connexion.php");
    exit();
}
?>