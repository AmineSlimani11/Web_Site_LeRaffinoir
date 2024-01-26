<?php
include('config.php');

// Génère un nouveau jeton CSRF si la session n'en a pas déjà un
if (!isset($_SESSION['csrf_token'])) {
    // Génération du token CSRF
    $csrf_token = bin2hex(random_bytes(32));
    // Stockage du token CSRF dans la session
    $_SESSION['csrf_token'] = $csrf_token;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="styles_Connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Connectez-vous</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            <?php if (isset($_SESSION['idUtilisateur'])): ?>
                <li><a href="page_Contact.php">Contact</a></li>
                <li><a href="page_Profile.php" class="bouton-pour-inscripconnex">Profile</a></li>
            <?php else: ?>
                <li><a href="page_Connectez.php" >Contact</a></li>
                <li><a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a></li>
            <?php endif; ?>
        </ul>
   </header>

    <main>
        <div class="container">
            <h1>Connexion</h1>
            <p class="mt-2">Connectez-vous à votre espace personnel</p>
            <form action="Connectez.php" method="post" class="mt-4">
                <div class="input-box">
                    <input type="email" class="form-control form-control-lg" name="_email" id="email" placeholder="E-mail" value="">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" class="form-control form-control-lg" name="_password" id="password" placeholder="Mot de passe " value="">
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <!-- Securté -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    
                <button type="submit" class="btn">Connexion</button>
            </form>
    
            <!-- Ajout du texte et des boutons pour la création de compte -->
            <div class="new-account-section">
                <p class="mt-2">Vous n'êtes pas inscrit?</p>
                <a href="page_Inscription.php" class="bouton-pour-inscrip">S'inscrire</a>
            </div>
        </div>
    </main>
    
    


    <footer>
            <div class="social-media">
                <h3>Retrouvez-nous sur</h3>
                <a href="https://www.facebook.com/votrerestaurant" target="_blank"><img src="images/icone-facebook-ronde.png" alt="Facebook"></a>
                <a href="https://www.instagram.com/votrerestaurant" target="_blank"><img src="images/Instagram_icon.png" alt="Instagram"></a>
                <a href="https://www.Pinterest.com/votrerestaurant" target="_blank"><img src="images/pinteresttt.png" alt="Pinterest"></a>
                <p>&copy; 2023 Le RAFFINOIR. Tous droits réservés.</p>
            </div>
            <div class="horaire">
                <h3>Nos Horaires</h3>
                <p>Lundi au Dimanche</p>
                <p>10h - 23h</p>
           </div>

            <div class="contact-info">
                <h3>Contactez-nous</h3>
                <p>leraffinoir62100@gmail.com</p>
                <p>Téléphone : +01 234 567 890</p>
            </div>
            <div class="adresse">
                <h3>Adresse</h3>
                <p><a href="https://maps.app.goo.gl/b6JZEzvPRLHpEnCZ7">3 Bd de la Résistance, 62100 Calais</a></p>
            </div>
    </footer>

</body>

</html>
