<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Vérifie si la variable POST 'idReservation' est définie
if (isset($_POST['idReservation'])) {
    $idReservation = $_POST['idReservation'];

    // Connectez-vous à la base de données
    require 'BD_Connection.php';

    // Récupère l'adresse e-mail du client à partir de la variable de session
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        // Gestion de l'erreur si l'adresse e-mail du client n'est pas disponible
        echo 'Erreur: Impossible de récupérer l\'adresse e-mail du client.';
        exit();
    }

    // Récupère l'idUtilisateur à partir de la variable de session
    if (isset($_SESSION['idUtilisateur'])) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
    } else {
        // Gestion de l'erreur si l'idUtilisateur n'est pas disponible
        echo 'Erreur: Impossible de récupérer l\'identifiant de l\'utilisateur.';
        exit();
    }

    // Préparez et exécutez la requête SQL pour supprimer la réservation
    $requete = "DELETE FROM reservation WHERE idReservation = ? AND idUtilisateur = ?";
    $stmt = $conn->prepare($requete);

    if ($stmt) {
        // Lie les valeurs et exécute la requête
        $stmt->bind_param("ii", $idReservation, $idUtilisateur);
        $stmt->execute();

        include('mailsend.php');

        $mail->Subject = 'Annulation de votre reservation';
        $mail->Body = 'Cher(e) client(e) <br> <br> <br> Nous tenons à vous informer que votre réservation a été annulée. Notre équipe se tient à votre disposition pour toutes demandes.<br> <br> Nous espérons avoir le plaisir de vous servir bientôt. <br><br><br> Cordialement, <br> Le RAFFINOIR Équipe ';

        try {
            $mail->send();
            echo 'Notification de l\'annulation envoyée au client.';
        } catch (Exception $e) {
            echo 'Erreur lors de l\'envoi de la notification : ' . $mail->ErrorInfo;
        }

        // Vérifie si la suppression a réussi
        if ($stmt->affected_rows > 0) {
            echo "La réservation a été annulée avec succès.";
            header("Location: page_MesReservations.php");
        } else {
            echo "Erreur lors de l'annulation de la réservation. Assurez-vous que vous avez le droit d'annuler cette réservation.";
        }

        // Ferme la déclaration
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête.";
    }

    // Ferme la connexion à la base de données
    $conn->close();
} else {
    echo "ID de réservation non spécifié.";
}
?>