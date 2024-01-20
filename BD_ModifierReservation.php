<?php
include('config.php');

if (!isset($_POST['csrf_token_modifier_reservation']) || $_POST['csrf_token_modifier_reservation'] !== $_SESSION['csrf_token_modifier_reservation']) {
    var_dump($_SESSION['csrf_token_modifier_reservation']);
    var_dump($_POST['csrf_token_modifier_reservation']);
    // Jeton CSRF invalide, gestion de l'erreur
    echo "Erreur de sécurité. Veuillez réessayer.";
    //exit();
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: page_Connectez.php");
    exit();
}
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la base de données
    require 'BD_Connection.php';

    // Récupère les nouvelles valeurs du formulaire et nettoie les données
    $newDate = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
    $newDate = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
    $newHeure = mysqli_real_escape_string($conn, $_POST['heure'] ?? '');
    $newNombrePersonnes = mysqli_real_escape_string($conn, $_POST['personnes'] ?? '');
    $newCommentaires = mysqli_real_escape_string($conn, $_POST['commentaires'] ?? '');

    // Met à jour les valeurs dans la session
    $_SESSION['date'] = $newDate;
    $_SESSION['heure'] = $newHeure;
    $_SESSION['personnes'] = $newNombrePersonnes;
    $_SESSION['commentaires'] = $newCommentaires;

    $idReservation = $_SESSION['idReservation'];
    $idUtilisateur = $_SESSION['idUtilisateur'];
    // Prépare et exécute la requête SQL pour mettre à jour la réservation
    $requete = "UPDATE `reservation` SET `Date_Reservation`='$newDate', `Heure_Reservation`='$newHeure', `Nombre_Personnes`='$newNombrePersonnes', `Commentaires`='$newCommentaires' WHERE `idUtilisateur`='$idUtilisateur' AND `idReservation`='$idReservation'";
    $email = $_SESSION['email'];

    $result = mysqli_query($conn, $requete);

    // Exécute la requête
    if ($result) {
        include('mailsend.php');
    $mail->Subject = 'Modification de votre reservation';
    $mail->Body    = 'Nous avons le plaisir de vous informer que la modification de votre réservation a été prise en compte avec succès.  <br> <br> Voici les détails : <br> <br>' .
                    '• Date : ' . $newDate . '<br>' .
                    '• Heure : ' . $newHeure . '<br>' .
                    '• Nombre de personnes : ' . $newNombrePersonnes . '<br>' .
                    '• Commentaire : ' . $newCommentaires . '<br>' .
                    '<br> Nous vous remercions pour votre confiance et serions enchantés de vous accueillir prochainement dans notre établissement .  <br><br><br> Cordialement, <br> Le RAFFINOIR Équipe ' ; 

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
        echo "La réservation a été modifiée avec succès.";
    header("Location: page_MesReservations.php");
        exit();
    } else {
        echo "Échec de la modification de la réservation: " . mysqli_error($conn);
    }

    // Ferme la connexion à la base de données
    $conn->close();
} else {
    // Si la méthode de requête n'est pas POST, redirige l'utilisateur vers la page de modification des réservations
    header("Location: page_ModifierReservations.php");
    exit();
}
?>
