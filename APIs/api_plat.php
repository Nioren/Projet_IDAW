<?php
// Connexion à la base de données
include 'config_api.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Endpoint pour récupérer la liste des plats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Filtrer les plats par le nom s'il y a une recherche, sinon récupérer tous les plats
    $searchCondition = isset($_GET['search']) ? " WHERE NOM_PLAT LIKE '%" . $_GET['search'] . "%'" : "";

    $sql = "SELECT * FROM PLAT" . $searchCondition;

    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

// Fermer la connexion à la base de données
$conn->close();
?>
