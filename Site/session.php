<?php
if (session_status() == PHP_SESSION_NONE) {
    // Démarrer la session uniquement si elle n'est pas déjà démarrée
    session_start();
}

include 'config.php';

function isUserLoggedIn() {
    return isset($_SESSION['id_user']);
}

function loginUser($id_user, $username) {
    $_SESSION['id_user'] = $id_user;
    $_SESSION['nom_utilisateur'] = $username;
}

function logoutUser() {
    unset($_SESSION['id_user']);
    unset($_SESSION['nom_utilisateur']);
}

function getLoggedInUserId() {
    return isUserLoggedIn() ? $_SESSION['id_user'] : null;
}

function getLoggedInUsername() {
    return isUserLoggedIn() ? $_SESSION['nom_utilisateur'] : null;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}