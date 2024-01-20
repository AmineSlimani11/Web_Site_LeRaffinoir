<?php
include('config.php');

if (!isset($_SESSION['csrf_token_modifier_infos'])) {
    // Génération du token CSRF
    $csrf_token = bin2hex(random_bytes(32));
    // Stockage du token CSRF dans la session
    $_SESSION['csrf_token_modifier_infos'] = $csrf_token;
}
if (!isset($_SESSION['csrf_token_modifier_mdp'])) {
    // Génération du token CSRF
    $csrf_token = bin2hex(random_bytes(32));
    // Stockage du token CSRF dans la session
    $_SESSION['csrf_token_modifier_mdp'] = $csrf_token;
}

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
    <link rel="stylesheet" type="text/css" href="styles_ModifierInfos.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Modifier mes informations</title>
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
                            <li> <a href="page_Administrateur.php" class="bouton-pour-inscripconnex profile-button">Admin <i class="fas fa-caret-down"></i></a></li>
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
                    <a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a>
                <?php endif; ?>
            </ul>
        </header>

    <main>
        <section class="info">
            <h1>Modifier mes informations</h1>
            <div class="content">
                <div class="left-content">
                    <form action="Modification_infos.php" method="post">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" value="<?= $Nom ?>" required>

                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" value="<?= $Prenom ?>" required>

                        <label for="email">E-mail :</label>
                        <input type="email" id="email" name="email" value="<?= $Email ?>" required>

                        <label for="telephone">Téléphone :</label>
                        <input type="tel" id="telephone" name="telephone" value="<?= $Telephone ?>" required>
                        <input type="hidden" name="csrf_token_modifier_infos" value="<?php echo $_SESSION['csrf_token_modifier_infos']; ?>">
                        <div class="buttons">
                            <input type="submit" value="Enregistrer les modifications" >
                            <input type="button" value="Modifier le mot de passe" onclick="location.href = 'page_ModifierMotdepasse.php'">
                        </div>

                    </form>
                </div>

                
            </div>

        </section>
    </main>


    <?php include 'footer.php'; ?>


</body>

</html>
