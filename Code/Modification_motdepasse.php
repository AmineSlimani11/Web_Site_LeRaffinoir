<?php
include('config.php');

if (!isset($_POST['csrf_token_modifier_mdp']) || $_POST['csrf_token_modifier_mdp'] !== $_SESSION['csrf_token_modifier_mdp']) {
    var_dump($_SESSION['csrf_token_modifier_mdp']);
    var_dump($_POST['csrf_token_modifier_mdp']);
    // Jeton CSRF invalide, gestion de l'erreur
    echo "Erreur de sécurité. Veuillez réessayer.";
    exit();
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupère les valeurs du formulaire
    $ancienMotDePasse = $_POST['ancienMotDePasse'];
    $nouveauMotDePasse = $_POST['nouveauMotDePasse'];
    $confirmerNouveauMotDePasse = $_POST['confirmerNouveauMotDePasse'];



    // Vérifie si l'ancien mot de passe correspond à celui stocké en session
    if (password_verify($ancienMotDePasse, $_SESSION['hashed_password'])) {
        // Vérifie si le nouveau mot de passe et la confirmation sont identiques
        if ($nouveauMotDePasse === $confirmerNouveauMotDePasse) {
            // Met à jour le mot de passe dans la session
            $_SESSION['hashed_password'] = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

            // Met à jour le mot de passe dans la base de données
            require 'BD_Connection.php'; //inclure le fichier de connexion à la base de données

            $idUtilisateur = $_SESSION['idUtilisateur'];
            $hashedNewPassword = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

            // Prépare et exécute la requête SQL pour mettre à jour le mot de passe de l'utilisateur
            $requete = "UPDATE `Utilisateur` SET `Password`='$hashedNewPassword' WHERE `idUtilisateur`='$idUtilisateur'";

            $result = mysqli_query($conn, $requete);

            // Vérifie si la requête a réussi
            if ($result) {
                // Redirige l'utilisateur vers la page de profil après la modification
                header("Location: Page_Profile.php");
                exit();
            } else {
                // Gestion de l'erreur, vous pouvez personnaliser selon vos besoins
                echo "Erreur lors de la mise à jour du mot de passe dans la base de données.";
            }

            // Ferme la connexion à la base de données
            $conn->close();
        } else {
            echo "Le nouveau mot de passe et la confirmation ne correspondent pas.";
        }
    } else {
        echo "L'ancien mot de passe est incorrect.";
    }
} else {
    // Si la méthode de requête n'est pas POST, redirige l'utilisateur vers la page de modification du mot de passe
    header("Location: page_ModifierMotDePasse.php");
    exit();
}
?>
