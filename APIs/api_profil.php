<?php
// Connexion à la base de données
include 'config_api.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// ID utilisateur fixe (remplacez par votre système de gestion de session)
$id_utilisateur = 0;

// Endpoint pour récupérer la liste des repas de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dateCondition = isset($_GET['date']) ? " AND M.DATE = '" . $conn->real_escape_string($_GET['date']) . "'" : "";

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
    $data = json_decode(file_get_contents("php://input"));
    $id_plat = $conn->real_escape_string($data->ID_PLAT);
    $quantite = $conn->real_escape_string($data->QUANTITE);

    // Obtenir la date d'aujourd'hui au format YYYY-MM-DD
    $date = date("Y-m-d");

    $sql = "INSERT INTO MANGER_PLAT (ID_USER, ID_PLAT, QUANTITE, DATE) VALUES ($id_utilisateur, $id_plat, $quantite, '$date')";
    if ($conn->query($sql) === TRUE) {
        echo "Le repas a été ajouté avec succès.";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Endpoint pour mettre à jour un repas
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $id_repas = $conn->real_escape_string($data->ID_REPAS);
    $quantite = $conn->real_escape_string($data->QUANTITE);
    $date = $conn->real_escape_string($data->DATE);

    $sql = "UPDATE MANGER_PLAT SET QUANTITE = $quantite, DATE = '$date' WHERE ID_REPAS = $id_repas AND ID_USER = $id_utilisateur";
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
        $sql = "DELETE FROM MANGER_PLAT WHERE ID_REPAS = $id_repas AND ID_USER = $id_utilisateur";
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
?>
