<?php
include('config.php');

// Détruit toutes les données de la session
$_SESSION = array();
session_destroy();

// Redirige vers la page de connexion
header('Location: page_Accueil.php');
exit(); 
?>
