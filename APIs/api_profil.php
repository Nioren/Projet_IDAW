<?php
// Connexion à la base de données
session_start();
include 'config_api.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Endpoint pour récupérer la liste des repas de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dateCondition = isset($_GET['date']) ? " AND M.DATE = '" . $conn->real_escape_string($_GET['date']) . "'" : "";
    $id_utilisateur = $_SESSION['id_user'];

    $sql = "SELECT M.ID_REPAS, P.NOM_PLAT, M.QUANTITE, M.DATE
            FROM MANGER_PLAT M
            JOIN PLAT P ON M.ID_PLAT = P.ID_PLAT
            WHERE M.ID_USER = $id_utilisateur" . $dateCondition;

    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

// Endpoint pour ajouter un repas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID de l'utilisateur à partir de la session
    $id_utilisateur = $_SESSION['id_user'];

    // Récupérer les autres données depuis la requête POST
    $id_plat = $conn->real_escape_string($_POST['ID_PLAT']);
    $quantite = $conn->real_escape_string($_POST['QUANTITE']);

    // Obtenir la date d'aujourd'hui au format YYYY-MM-DD
    $date = date("Y-m-d");

    // Utilisation de la requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO MANGER_PLAT (ID_USER, ID_PLAT, QUANTITE, DATE) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $id_utilisateur, $id_plat, $quantite, $date);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Le repas a été ajouté avec succès.";
    } else {
        // Afficher des informations de débogage en cas d'erreur
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Endpoint pour mettre à jour un repas
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $id_repas = $conn->real_escape_string($data->ID_REPAS);
    $quantite = $conn->real_escape_string($data->QUANTITE);
    $date = $conn->real_escape_string($data->DATE);

    $sql = "UPDATE MANGER_PLAT SET QUANTITE = $quantite, DATE = '$date' WHERE ID_REPAS = $id_repas";
    if ($conn->query($sql) === TRUE) {
        echo "Le repas a été mis à jour avec succès.";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Endpoint pour supprimer un repas
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id_repas = isset($_GET['ID_REPAS']) ? $conn->real_escape_string($_GET['ID_REPAS']) : null;

    if ($id_repas !== null) {
        $sql = "DELETE FROM MANGER_PLAT WHERE ID_REPAS = $id_repas";
        if ($conn->query($sql) === TRUE) {
            echo "Le repas a été supprimé avec succès.";
        } else {
            echo "Erreur : " . $conn->error;
        }
    } else {
        echo "ID_REPAS non spécifié.";
    }
}


// Fermer la connexion à la base de données
$conn->close();
