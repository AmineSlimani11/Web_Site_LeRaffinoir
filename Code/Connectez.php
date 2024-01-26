<?php
include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    var_dump($_SESSION['csrf_token']);
    var_dump($_POST['csrf_token']);
    // Jeton CSRF invalide, gestion de l'erreur
    echo "Erreur de sécurité. Veuillez réessayer.";
    exit();
}

// Récupère les valeurs des champs du formulaire
$email = $_POST['_email'] ?? '';
$password = $_POST['_password'] ?? '';

if (empty($email) || empty($password)) {
    echo "Veuillez fournir une adresse e-mail et un mot de passe.";
    exit();
}


require_once('BD_Connection.php');
$conn = connectToDatabase(); 

// Utilisation de requêtes préparées avec des paramètres liés
$stmt = $conn->prepare("SELECT * FROM Utilisateur WHERE Email = ?");
$stmt->bind_param("s", $email);

// Vérifier si la préparation de la requête a réussi
if ($stmt === false) {
    die("Échec de la préparation de la requête: " . $conn->error);
}

$stmt->execute();

// Vérifier si l'exécution de la requête a réussi
if ($stmt->execute() === false) {
    die("Échec de l'exécution de la requête: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Utilisateur trouvé, récupère le mot de passe hashé
    $row = $result->fetch_assoc();
    $hashed_password = $row['Password'];
    $idUtilisateur = $row['idUtilisateur'];
    $isAdmin = $row['isAdmin'];

    // Vérifie si le mot de passe correspond
    if (password_verify($password, $hashed_password)) {
        echo "Connexion réussie !";
        // Démarrer la session et stocker les informations de l'utilisateur si nécessaire
        
        $_SESSION['idUtilisateur'] = $idUtilisateur;
        $_SESSION['isAdmin'] = $isAdmin;
        $_SESSION['nom'] = $row['Nom'];
        $_SESSION['prenom'] = $row['Prenom'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['telephone'] = $row['Telephone'];
        $_SESSION['hashed_password'] = $row['Password'];

        // Nouvelle vérification pour isAdmin
        if ($isAdmin == 1) {
            // Si l'utilisateur est un administrateur, redirige vers la page_dashboard.php
            header("Location: page_dashboard.php");
            exit();
        }
        
        // Après une connexion réussie
        // Vérifie s'il y a une URL de redirection dans la session
        if (isset($_SESSION['redirect_url'])) {
            // Récupère l'URL de redirection
            $redirect_url = $_SESSION['redirect_url'];

            // Redirige l'utilisateur vers l'URL de redirection
            header("Location: $redirect_url");
            exit();
        } else {
            // Redirige l'utilisateur vers la page du profil par défaut
            header("Location: page_Accueil.php");
            exit();
        }

    } else {
        echo "Échec de la connexion, vérifiez votre mot de passe.";
    }
} else {
    echo "Aucun utilisateur trouvé avec cette adresse e-mail.";
}

// Ferme la connexion à la base de données
$stmt->close();
$conn->close();
?>
