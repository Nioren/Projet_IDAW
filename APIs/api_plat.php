<?php
// Connexion à la base de données
include 'config_api.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Endpoint pour récupérer la liste des plats depuis la table PLAT
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT ID_PLAT, NOM_PLAT, IMAGE FROM PLAT";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}

// Fermer la connexion à la base de données
$conn->close();
?>
