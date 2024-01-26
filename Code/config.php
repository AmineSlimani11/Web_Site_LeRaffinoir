<?php
// la durée de vie de session en secondes (notre exemple, 1 heure)
$session_lifetime = 3600;

// la durée de vie du cookie de session côté client
session_set_cookie_params($session_lifetime);

// Démarre la session
session_start();

// Vérifie si l'utilisateur a appuyé sur le bouton de déconnexion
if (isset($_POST['logout'])) {
    // Déconnecte l'utilisateur et détruit la session
    session_unset();
    session_destroy();
    // Redirige l'utilisateur vers la page de déconnexion
    header("Location: Deconnexion.php");
    exit();
}

// Vérifie si la variable de session 'LAST_ACTIVITY' existe
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_lifetime)) {
    // Si la session a expiré en raison d'une inactivité, déconnecte l'utilisateur et détruit la session
    session_unset();
    session_destroy();
    // Redirige l'utilisateur vers la page de déconnexion
    header("Location: Deconnexion.php");
    exit();
} else {
    // Met à jour le timestamp de dernière activité
    $_SESSION['LAST_ACTIVITY'] = time();
}

?>