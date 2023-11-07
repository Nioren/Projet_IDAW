<?php

/* 
    FICHIER A EXECUTER AFIN D'OBTENIR LA BASE SIMPLIFIEE DE OPENFOODFACTS
*/

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "off";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Nom de la base de données
$database = "openfoodfactsbdd";

// Supprimer la base de données si elle existe déjà
$sql = "DROP DATABASE IF EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Base de données '$database' supprimée avec succès.<br>";
} else {
    echo "Erreur lors de la suppression de la base de données : " . $conn->error . "<br>";
}

// Créer la base de données
$sql = "CREATE DATABASE $database";
if ($conn->query($sql) === TRUE) {
    echo "Base de données '$database' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la base de données : " . $conn->error . "<br>";
}

// Utiliser la base de données
$conn->select_db($database);

// Créer la table openfoodfacts
$table_name = "openfoodfacts";
$sql = "CREATE TABLE $table_name (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255),
    nutriments JSON,
    url_image VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'openfoodfacts' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table : " . $conn->error . "<br>";
}

// URL de l'API OpenFoodFacts pour la récupération de produits
$url = "https://world.openfoodfacts.org/cgi/search.pl?search_terms=&page_size=100&json=1";

$ch = curl_init($url);

// Configuration de la requête cURL pour désactiver la vérification SSL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Exécution de la requête cURL
$response = curl_exec($ch);

// Vérification des erreurs de cURL
if (curl_errno($ch)) {
    echo "Erreur cURL : " . curl_error($ch);
} else {
    // Décodez la réponse JSON en un tableau PHP
    $data = json_decode($response, true);

    if (isset($data['products']) && is_array($data['products'])) {
        // Boucle à travers les produits et insérez-les dans la base de données
        foreach ($data['products'] as $product) {
            $product_name = $conn->real_escape_string($product['product_name']);
            $nutriments = json_encode($product['nutriments']);
            $url_image = $product['image_front_url'];

            // Insérez les données dans la table
            $sql = "INSERT INTO openfoodfacts (product_name, nutriments, url_image) VALUES ('$product_name', '$nutriments', '$url_image')";

            if ($conn->query($sql) !== TRUE) {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
            }
        }
    } else {
        echo "Aucune donnée de produit n'a été récupérée depuis l'API OpenFoodFacts.";
    }
}

// Fermez la connexion à la base de données
$conn->close();

// Fermez la session cURL
curl_close($ch);
?>
