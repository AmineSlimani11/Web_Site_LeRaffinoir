<?php
include('config.php');

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['csrf_token_modifier_infos']) || $_POST['csrf_token_modifier_infos'] !== $_SESSION['csrf_token_modifier_infos']) {
        var_dump($_SESSION['csrf_token_modifier_infos']);
        var_dump($_POST['csrf_token_modifier_infos']);
        // Jeton CSRF invalide, gestion de l'erreur
        echo "Erreur de sécurité. Veuillez réessayer.";
        exit();
    }

    
    // Récupère les nouvelles valeurs du formulaire
    $newNom = $_POST['nom'];
    $newPrenom = $_POST['prenom'];
    $newEmail = $_POST['email'];
    $newTelephone = $_POST['telephone'];

    

    // Met à jour les valeurs dans la session
    $_SESSION['nom'] = $newNom;
    $_SESSION['prenom'] = $newPrenom;
    $_SESSION['email'] = $newEmail;
    $_SESSION['telephone'] = $newTelephone;

    // Met à jour les valeurs dans la base de données
    require 'BD_Connection.php'; // inclure le fichier de connexion à la base de données

    // Utilisation de la fonction mysqli_real_escape_string pour éviter les injections SQL
    $newNom = mysqli_real_escape_string($conn, $newNom);
    $newPrenom = mysqli_real_escape_string($conn, $newPrenom);
    $newEmail = mysqli_real_escape_string($conn, $newEmail);
    $newTelephone = mysqli_real_escape_string($conn, $newTelephone);

    $idUtilisateur = $_SESSION['idUtilisateur'];

    // Prépare et exécute la requête SQL pour mettre à jour les informations de l'utilisateur
    $requete = "UPDATE `Utilisateur` SET `Nom`='$newNom', `Prenom`='$newPrenom', `Email`='$newEmail', `Telephone`='$newTelephone' WHERE `idUtilisateur`='$idUtilisateur'";

    $result = mysqli_query($conn, $requete);

    // Vérifie si la requête a réussi
    if ($result) {
        // Redirige l'utilisateur vers la page de profil après la modification
        header("Location: Page_Profile.php");
        exit();
    } else {
        // Gestion de l'erreur
        echo "Erreur lors de la mise à jour des informations dans la base de données.";
    }

    // Ferme la connexion à la base de données
    $conn->close();
} else {
    // Si la méthode de requête n'est pas POST, redirige l'utilisateur vers la page de modification des informations
    header("Location: page_ModifierInfos.php");
    exit();
}
?>
