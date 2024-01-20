<?php
include('config.php');

// Vérifie si la variable de session 'nom' est définie
if (isset($_SESSION['idUtilisateur'])) {
    $idUtilisateur = $_SESSION['idUtilisateur'];
    $Nom = $_SESSION['nom'];
    $Prenom = $_SESSION['prenom'];
    $Email = $_SESSION['email'];
    $Telephone = $_SESSION['telephone'];
} else {
    // Redirige l'utilisateur vers une page d'erreur ou de connexion si 'nom' n'est pas défini
    echo "Échec de la Nom.";
    exit();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Profile.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Profile</title>

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
                    <li>
                        <a href="#" class="bouton-pour-inscripconnex profile-button">Profil <i class="fas fa-caret-down"></i></a>
                        <ul class="dropdown">
                            <li ><a href="page_MesReservations.php" class="reservations-item"><i class="fas fa-angle-right"></i> Mes réservations</a></li>
                            <li ><a href="Page_Profile.php" class="modifier-info-item"><i class="fas fa-angle-right"></i> Mes informations</a></li>
                            <li ><a href="Deconnexion.php" class="deconnexion-item"><i class="fas fa-sign-out"></i> Se déconnecter</a></li>
                        </ul>

                    </li>
                <?php else: ?>
                    <a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a>
                <?php endif; ?>
            </ul>
        </header>
        <main>
                <section class="info">
                    <h1>Mes informations</h1>
                    <div class="content">
                        <div class="left-content">
                            <img src="images/unknown.jpg" alt="profile" class="profile">
                            <label><?= $Prenom.' '.$Nom ?></label>
                        </div>

                        <div class="right-image">
                            
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" value="<?= $Nom ?>" readonly>
                        
                            <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" value="<?= $Prenom ?>" readonly>
                        
                            <label for="email">E-mail :</label>
                            <input type="email" id="email" value="<?= $Email ?>" readonly>
                        
                            <label for="telephone">Téléphone :</label>
                            <input type="tel" id="telephone" value="<?= $Telephone ?>" readonly>
                           
                            <button class="Modify" onclick="location.href = 'page_ModifierInfos.php'">Modifier</button>
                        </div>
                    </div>

                </section>
            </main>


            <?php include 'footer.php'; ?>

    </body>
</html>