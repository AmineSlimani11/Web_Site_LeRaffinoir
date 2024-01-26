<?php
include('config.php');

if (!isset($_POST['csrf_token_contact']) || $_POST['csrf_token_contact'] !== $_SESSION['csrf_token_contact']) {
    var_dump($_SESSION['csrf_token_contact']);
    var_dump($_POST['csrf_token_contact']);
    // Jeton CSRF invalide, gestion de l'erreur
    echo "Erreur de sécurité. Veuillez réessayer.";
    //exit();
}

// Assurez-vous que l'utilisateur est connecté 
if (!isset($_SESSION['idUtilisateur'])) {
    echo "Utilisateur non connecté.";
    $_SESSION['redirect_url'] = $_GET['redirect'];
    header("location: page_Connectez.php");
    exit();
}

// Récupérez l'idUtilisateur de la session
$idUtilisateur = $_SESSION['idUtilisateur'];

// Autres données du formulaire
$Nom = $_POST['nom'];
$Email = $_POST['email'];
$Telephone = $_POST['telephone'];
$Message = $_POST['message'];

require 'BD_Connection.php'; 

// Assurez-vous d'échapper les données pour éviter les injections SQL
$idUtilisateur = mysqli_real_escape_string($conn, $idUtilisateur);
$Nom = mysqli_real_escape_string($conn, $Nom);
$Email = mysqli_real_escape_string($conn, $Email);
$Telephone = mysqli_real_escape_string($conn, $Telephone);
$Message = mysqli_real_escape_string($conn, $Message);

$requete = "INSERT INTO `Contact` (`idutilisateur`, `Message`) VALUES ('$idUtilisateur', '$Message')";

$result = mysqli_query($conn, $requete); 

if ($result) {
    echo "<h1>Message envoyé avec succès!</h1>";
    // Inclure la bibliothèque PHPMailer
    require 'PHPMailer/PHPMailerAutoload.php';

    // Obtenir l'adresse e-mail du propriétaire 
    $ownerEmail = 'leraffinoir62100@gmail.com';

    // Créer une instance de la classe PHPMailer
    $mail = new PHPMailer;

    // Configuration de la connexion SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leraffinoir62100@gmail.com'; // adresse e-mail Gmail
    $mail->Password = 'vhyjgamxczjudwdw'; // mot de passe Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Adresse e-mail du client
    $clientEmail = $_POST['email']; 

    // Configurer l'expéditeur du message en utilisant l'adresse e-mail du client
    $mail->setFrom($clientEmail, $Nom); 

    // Ajouter l'adresse e-mail du propriétaire comme destinataire
    $mail->addAddress($ownerEmail);

    $mail->isHTML(true);

    // Configurer le sujet et le corps du message
    $mail->Subject = 'Nouveau message de la part d\'un client';
    $mail->Body    = "Un client a laissé un message :<br><br>" .
                    "Nom : $Nom<br>"  .
                    "E-mail : $Email<br>" .
                    "Téléphone : $Telephone<br>" .
                    "Message : $Message";

    // Envoyer le message
    if (!$mail->send()) {
        echo 'Le message n\'a pas pu être envoyé.';
        echo 'Erreur du mailer : ' . $mail->ErrorInfo;
    } else {
        echo 'Le message a été envoyé';
        header("Location:page_Accueil.php");
    }


} else {
    echo "<h1>Erreur lors de l'envoi'.</h1>";
}
?>

