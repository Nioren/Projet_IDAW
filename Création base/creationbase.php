<?php

// Configuration de la base de données destination (votre base)
$destinationServer = "localhost";
$destinationUsername = "root";
$destinationPassword = "";

// Connexion à la base de données destination
$destinationConn = new mysqli($destinationServer, $destinationUsername, $destinationPassword);

// Vérifier la connexion à la base de données destination
if ($destinationConn->connect_error) {
    die("Erreur de connexion à la base de données destination : " . $destinationConn->connect_error);
}

// Création de la base de données bddidaw
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS bddidaw";
if ($destinationConn->query($sqlCreateDatabase) === TRUE) {
    echo "Base de données 'bddidaw' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la base de données : " . $destinationConn->error . "<br>";
}

// Utilisation de la base de données bddidaw
$destinationConn->select_db("bddidaw");

// Exécution du fichier SQL pour créer les tables
$sqlFilePath = "BDDIDAW.sql"; // Remplacez par le chemin réel de votre fichier SQL
$sqlContent = file_get_contents($sqlFilePath);

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
        // Boucle à travers les produits et insérez-les dans la table "PLAT"
        // Boucle à travers les produits et insérez-les dans la table "PLAT"
        foreach ($data['products'] as $product) {
            $nom_plat = $destinationConn->real_escape_string(utf8_encode($product['product_name']));
            $nutriments = $destinationConn->real_escape_string(json_encode($product['nutriments']));
            $image = $destinationConn->real_escape_string($product['image_front_url']);

            // Insérez les données dans la table "PLAT"
            $sqlInsertData = "INSERT INTO PLAT (NOM_PLAT, NUTRIMENTS, IMAGE) 
                       VALUES ('$nom_plat', '$nutriments', '$image')";

            if ($destinationConn->query($sqlInsertData) !== TRUE) {
            } else {
            }

            // Libérez les résultats non consommés
            $destinationConn->next_result();
        }




        echo "Transfert des données terminé avec succès.<br>";
    } else {
        echo "Aucune donnée de produit n'a été récupérée depuis l'API OpenFoodFacts.<br>";
    }
}

// Fermeture de la connexion à la base de données
$destinationConn->close();

// Fermeture de la session cURL
curl_close($ch);
