<?php
// Fonction pour établir la connexion à la base de données
function connectToDatabase() {
    $conn = new mysqli("localhost", "root", "", "BD_Restaurant");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données: " . $conn->connect_error);
    }

    return $conn;
}

// Appel de la fonction pour établir la connexion
$conn = connectToDatabase();
?>

