<?php

/* 
    SCRIPT DE TRANSFERT DES PLATS DE LA PREMIÈRE BASE VERS LA DEUXIÈME BASE
*/

// Configuration de la première base de données (openfoodfacts)
$sourceServer = "localhost";
$sourceUsername = "root";
$sourcePassword = "";
$sourceDatabase = "openfoodfactsbdd";

// Configuration de la deuxième base de données (la vôtre)
$destinationServer = "localhost";
$destinationUsername = "root";
$destinationPassword = "";
$destinationDatabase = "bddidaw"; // Remplacez par le nom de votre base

// Connexion à la première base de données
$sourceConn = new mysqli($sourceServer, $sourceUsername, $sourcePassword, $sourceDatabase);

// Vérifier la connexion à la première base de données
if ($sourceConn->connect_error) {
    die("Erreur de connexion à la première base de données : " . $sourceConn->connect_error);
}

// Connexion à la deuxième base de données
$destinationConn = new mysqli($destinationServer, $destinationUsername, $destinationPassword, $destinationDatabase);

// Vérifier la connexion à la deuxième base de données
if ($destinationConn->connect_error) {
    die("Erreur de connexion à la deuxième base de données : " . $destinationConn->connect_error);
}

// Sélection de tous les enregistrements de la table "openfoodfacts"
$sourceSql = "SELECT * FROM openfoodfacts";

$result = $sourceConn->query($sourceSql);

if ($result) {
    // Boucle à travers les enregistrements de la première base et insérez-les dans la table "PLAT" de la deuxième base
    while ($row = $result->fetch_assoc()) {
        $id_plat = $row['id'];
        $nom_plat = $destinationConn->real_escape_string($row['product_name']);
        $nutriments = $destinationConn->real_escape_string($row['nutriments']);
        $image = $destinationConn->real_escape_string($row['url_image']);

        // Insérez les données dans la table "PLAT" de la deuxième base
        $destinationSql = "INSERT INTO PLAT (ID_PLAT, NOM_PLAT, NUTRIMENTS, IMAGE) 
                           VALUES ('$id_plat', '$nom_plat', '$nutriments', '$image')";

        if ($destinationConn->query($destinationSql) !== TRUE) {
            echo "Erreur lors de l'ajout de l'enregistrement dans la deuxième base : " . $destinationConn->error;
        }
    }

    echo "Transfert des données terminé avec succès.";
} else {
    echo "Erreur lors de la récupération des données de la première base : " . $sourceConn->error;
}

// Fermez les connexions aux bases de données
$sourceConn->close();
$destinationConn->close();
?>
