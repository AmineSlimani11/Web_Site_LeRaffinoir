<?php
include('config.php'); 

// Check if the user is an admin
if (!isset($_SESSION['idUtilisateur']) || !$_SESSION['isAdmin']) {
    // Redirect unauthorized users
    header("Location: page_Accueil.php");
    exit();
}<?php
// Inclusion du fichier de configuration
include('config.php');

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['idUtilisateur']) || !$_SESSION['isAdmin']) {
    // Rediriger les utilisateurs non autorisés
    header("Location: page_Accueil.php");
    exit();
}

// Vérifier si le formulaire est soumis avec un ID de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idReservation"])) {
    // Inclusion du fichier de connexion à la base de données
    require 'BD_Connection.php';

    // Assainir et valider l'ID de réservation
    $idReservation = mysqli_real_escape_string($conn, $_POST["idReservation"]);

    // Obtenir les détails de la réservation pour la notification
    $reservationQuery = "SELECT * FROM reservation WHERE idReservation = $idReservation";
    $reservationResult = mysqli_query($conn, $reservationQuery);

    if ($reservationResult && $reservation = mysqli_fetch_assoc($reservationResult)) {
        // Récupérer l'adresse e-mail du client
        $userId = $reservation['idUtilisateur'];
        $getUserEmailQuery = "SELECT Email FROM Utilisateur WHERE idUtilisateur = $userId";
        $userEmailResult = mysqli_query($conn, $getUserEmailQuery);
        
        if ($userEmailResult && $user = mysqli_fetch_assoc($userEmailResult)) {
            $email = $user['Email'];
    
            // Effectuer la suppression de la réservation
            $deleteQuery = "DELETE FROM reservation WHERE idReservation = $idReservation";
            $result = mysqli_query($conn, $deleteQuery);

            // Vérifier si la suppression a réussi
            if ($result) {
                // Inclusion du fichier d'envoi de courrier
                include('mailsend.php');

                // Configuration du sujet et du corps du courrier
                $mail->Subject = 'Annulation de votre réservation';
                $mail->Body = 'Cher(e) client(e),<br><br>Nous tenons à vous informer que votre réservation a été annulée. Notre équipe reste à votre disposition pour toutes demandes.<br><br>Nous espérons avoir le plaisir de vous servir bientôt.<br><br>Cordialement,<br>Le RAFFINOIR Équipe';

                try {
                    // Envoi de la notification par courrier électronique
                    $mail->send();
                    echo 'Notification de l\'annulation envoyée au client.';
                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de la notification : ' . $mail->ErrorInfo;
                }

                // Redirection vers le tableau de bord
                header("Location: page_dashboard.php");
                exit();
            } else {
                // Gérer l'erreur de suppression, personnaliser au besoin
                echo "Erreur lors de la suppression de la réservation.";
            }
        } else {
            // Gérer l'erreur de récupération de l'adresse e-mail du client
            echo "Erreur lors de la récupération de l'adresse e-mail du client.";
        }
    } else {
        // Gérer l'erreur de récupération des détails de la réservation
        echo "Erreur lors de la récupération des détails de la réservation.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Si le formulaire n'est pas soumis avec un ID de réservation, redirection vers le tableau de bord
    header("Location: page_dashboard.php");
    exit();
}
?>


// Check if the form is submitted with a reservation ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idReservation"])) {
    // Include the database connection file
    require 'BD_Connection.php';

    // Sanitize and validate the reservation ID
    $idReservation = mysqli_real_escape_string($conn, $_POST["idReservation"]);

    // Get reservation details for notification
    $reservationQuery = "SELECT * FROM reservation WHERE idReservation = $idReservation";
    $reservationResult = mysqli_query($conn, $reservationQuery);


    if ($reservationResult && $reservation = mysqli_fetch_assoc($reservationResult)) {
         // Récupérer l'adresse e-mail du client
        $userId = $reservation['idUtilisateur'];
        $getUserEmailQuery = "SELECT Email FROM Utilisateur WHERE idUtilisateur = $userId";
        $userEmailResult = mysqli_query($conn, $getUserEmailQuery);
        if ($userEmailResult && $user = mysqli_fetch_assoc($userEmailResult)) {
            $email = $user['Email'];
    
            // Perform the reservation deletion
            $deleteQuery = "DELETE FROM reservation WHERE idReservation = $idReservation";
            $result = mysqli_query($conn, $deleteQuery);
            // Check if the deletion was successful
            if ($result) {
                include('mailsend.php');

                $mail->Subject = 'Annulation de votre reservation';
                $mail->Body = 'Cher(e) client(e) <br> <br> <br> Nous tenons à vous informer que votre réservation a été annulée. Notre équipe se tient à votre disposition pour toutes demandes.<br> <br> Nous espérons avoir le plaisir de vous servir bientôt. <br><br><br> Cordialement, <br> Le RAFFINOIR Équipe ' ;
                
                try {
                    $mail->send();
                    echo 'Notification de l\'annulation envoyée au client.';
                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de la notification : ' . $mail->ErrorInfo;
                }

        // Redirect back to the dashboard
        header("Location: page_dashboard.php");
        exit();
    } else {
        // Handle deletion error, customize as needed
        echo "Erreur lors de la suppression de la réservation.";
    }
} else {
    // Handle error fetching reservation details
    echo "Erreur lors de la récupération des détails de la réservation.";
}

    // Close the database connection
    $conn->close();
} else {
// If the form is not submitted with a reservation ID, redirect to the dashboard
header("Location: page_dashboard.php");
exit();
}
}
?>