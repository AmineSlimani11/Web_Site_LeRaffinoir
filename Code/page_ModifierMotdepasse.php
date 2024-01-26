<?php
include('config.php');

// Vérifie si la variable de session 'idUtilisateur' est définie
if (isset($_SESSION['idUtilisateur'])) {
    $idUtilisateur = $_SESSION['idUtilisateur'];
    $Nom = $_SESSION['nom'];
    $Prenom = $_SESSION['prenom'];
    $Email = $_SESSION['email'];
    $Telephone = $_SESSION['telephone'];
} else {
    // Redirige l'utilisateur vers une page d'erreur ou de connexion si 'idUtilisateur' n'est pas défini
    header("Location: page_Connectez.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="styles_ModifierMotdepasse.css">
    <link rel="stylesheet" type="text/css" href="footer.css">

    <title>Modifier le mots de passe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<header>
            <a href="page_Accueil.php" class="logo"> Le RAFFINOIR</a>
            <div class="menuToggle"></div>
            <ul class="navbar">
                <li><a href="page_Accueil.php">Accueil</a></li>
                <li><a href="page_Accueil.php#apropos">À propos</a></li>
                <li><a href="page_Accueil.php#temoignage">Temoignage</a></li>
                <li><a href="page_Menu.php">Menu</a></li>
                <li><a href="page_Contact.php">Contact</a></li>
                <?php if ($_SESSION['idUtilisateur']): ?>
                        <?php if ($_SESSION['isAdmin'] == 1): ?>
                            <li><a href="page_Administrateur.php" class="bouton-pour-inscripconnex profile-button">Admin <i class="fas fa-caret-down"></i></a></li>
                        <?php else: ?>
                            <li>
                                <a href="#" class="bouton-pour-inscripconnex profile-button">Profil <i class="fas fa-caret-down"></i></a>
                                <ul class="dropdown">
                                    <li ><a href="page_MesReservations.php" class="reservations-item"><i class="fas fa-angle-right"></i> Mes réservations</a></li>
                                    <li ><a href="Page_Profile.php" class="modifier-info-item"><i class="fas fa-angle-right"></i> Mes informations</a></li>
                                    <li ><a href="Deconnexion.php" class="deconnexion-item"><i class="fas fa-sign-out"></i> Se déconnecter</a></li>
                                </ul>

                            </li>
                        <?php endif; ?>   
                <?php else: ?>
                    <li><a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </header>

    <main>
        <section class="info">
            <h1>Modifier le mot de passe</h1>
            <div class="content">
                <div class="left-content">
                    <form action="Modification_motdepasse.php" method="post">
                        <label for="ancienMotDePasse">Ancien mot de passe :</label>
                        <input type="password" id="ancienMotDePasse" name="ancienMotDePasse" required>

                        <label for="nouveauMotDePasse">Nouveau mot de passe :</label>
                        <input type="password" id="nouveauMotDePasse" name="nouveauMotDePasse" required>

                        <label for="confirmerNouveauMotDePasse">Confirmer le nouveau mot de passe :</label>
                        <input type="password" id="confirmerNouveauMotDePasse" name="confirmerNouveauMotDePasse" required>
                        <input type="hidden" name="csrf_token_modifier_mdp" value="<?php echo $_SESSION['csrf_token_modifier_mdp']; ?>">
                        <input type="submit" value="Enregistrer le nouveau mot de passe">
                    </form>
                </div>
            </div>

        </section>
    </main>

    <?php include 'footer.php'; ?>


</body>

</html>