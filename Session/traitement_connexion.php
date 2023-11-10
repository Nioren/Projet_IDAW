<?php
include 'config_api.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $motDePasse = $_POST['mot_de_passe'];

    $query = "SELECT * FROM utilisateurs WHERE login = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($motDePasse, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        header("Location: profil.php");
        exit();
    } else {
        header("Location: connexion.php?error=1");
        exit();
    }
}
?>