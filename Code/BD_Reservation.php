<?php
include('config.php');

error_log(print_r($_POST, true));

if (!isset($_POST['csrf_token_reservation']) || $_POST['csrf_token_reservation'] !== $_SESSION['csrf_token_reservation']) {
    var_dump($_SESSION['csrf_token_reservation']);
    var_dump($_POST['csrf_token_reservation']);
    // Jeton CSRF invalide, gestion de l'erreur
    echo "Erreur de sécurité. Veuillez réessayer.";
   // exit();
}


// s'assurer que l'utilisateur est connecté 
if (!isset($_SESSION['idUtilisateur'])) {
    echo "Utilisateur non connecté.";
    $_SESSION['redirect_url'] = $_GET['redirect'];
    header("location: page_Connectez.php");
    exit();
}

// Récupérez l'idUtilisateur de la session
$idUtilisateur = $_SESSION['idUtilisateur'];

// Autres données du formulaire
$nom = $_POST['nom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$date = $_POST['date'];
$heure = $_POST['heure'];
$personnes = $_POST['personnes'];
$commentaires = $_POST['commentaires'];

print_r($_POST);

require "Bd_Connection.php";
 

//échapper les données pour éviter les injections SQL
$idUtilisateur = mysqli_real_escape_string($conn, $idUtilisateur);
$date = mysqli_real_escape_string($conn, $date);
$heure = mysqli_real_escape_string($conn, $heure);
$personnes = mysqli_real_escape_string($conn, $personnes);
$commentaires = mysqli_real_escape_string($conn, $commentaires);


$requete = "INSERT INTO `reservation` (`idutilisateur`, `Date_Reservation`, `Heure_Reservation`, `Nombre_Personnes`, `Commentaires`) VALUES ('$idUtilisateur', '$date', '$heure', '$personnes', '$commentaires')";

$result = mysqli_query($conn, $requete); 

if ($result) {
    echo "<h1>Réservation effectuée avec succès!</h1>";
    include('mailsend.php');

    $mail->Subject = 'Confirmation de votre reservation';
    $mail->Body    = 'Nous vous remercions d\'avoir choisi notre établissement. <br> <br> Voici les détails de votre réservation : <br> <br>' .
                    '• Date : ' . $date . '<br>' .
                    '• Heure : ' . $heure . '<br>' .
                    '• Nombre de personnes : ' . $personnes . '<br>' .
                    '• Commentaire : ' . $commentaires . '<br>' .
                    '<br> Nous vous remercions pour votre confiance et serions enchantés de vous accueillir prochainement dans notre établissement . <br><br><br> Cordialement, <br> Le RAFFINOIR Équipe ';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
    header("location: page_MesReservations.php");
} else {
    echo "<h1>Erreur lors de la réservation.</h1>";
    header("location: page_Reservation.php");
}
?>
