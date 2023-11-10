<?php
// Inclure le fichier de configuration de la base de données
include 'config_api.php';

// Vérifier si l'ID utilisateur et la date sont fournis dans la requête
if (isset($_GET['id_user']) && isset($_GET['date'])) {
    // Récupérer les données de la requête
    $id_user = $_GET['id_user'];
    $date = $_GET['date'];

    try {
        // Établir la connexion à la base de données
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour récupérer les plats consommés par l'utilisateur à la date spécifiée
        $query = "SELECT plat.NUTRIMENTS, manger_plat.QUANTITE
            FROM manger_plat
            INNER JOIN plat ON manger_plat.ID_PLAT = plat.ID_PLAT
            WHERE manger_plat.ID_USER = :id_user AND DATE(manger_plat.DATE) = :date";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $total_calories = 0;

        // Parcourir les résultats de la requête
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convertir le JSON des nutriments en tableau associatif
            $nutriments = json_decode($row['NUTRIMENTS'], true);

            // Vérifier si la clé "energy-kcal_100g" existe dans les nutriments
            if (isset($nutriments['energy-kcal_100g'])) {
                // Calculer les calories totales pour ce plat
                $plat_calories = $nutriments['energy-kcal_100g'] * $row['QUANTITE'] / 100;
                $total_calories += $plat_calories;
            }
        }

        // Retourner la somme totale des calories (en tant que nombre)
        echo $total_calories;
    } catch (PDOException $e) {
        // Retourner une erreur en cas d'échec de la connexion à la base de données
        http_response_code(500);
        echo 'Erreur de connexion à la base de données.';
    }
} else {
    // Retourner une erreur si l'ID utilisateur ou la date ne sont pas spécifiés
    http_response_code(400);
    echo 'L\'ID utilisateur et la date sont obligatoires.';
}
?>
