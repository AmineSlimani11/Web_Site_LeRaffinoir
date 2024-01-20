<?php
include('config.php');

// Génère un nouveau jeton CSRF si la session n'en a pas déjà un
if (!isset($_SESSION['csrf_token_inscription'])) {
    $_SESSION['csrf_token_inscription'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Inscription.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Inscription</title>
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
                <li><a href="page_Contact.php">Contact</a></li>
                <a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a>
            </ul>
        </header>

        <main>
            <div class="container">
                <h1>Inscription</h1>
                <p class="mt-2">Créer un compte</p>
                <form action="Inscription.php" method="post" class="mt-4">
                    <div class="input-box">
                        <input type="nom" class="form-control form-control-lg" name="_nom" id="nom" placeholder="Nom" value="">
                    </div>
                    <div class="input-box">
                        <input type="prenom" class="form-control form-control-lg" name="_prenom" id="prenom" placeholder="Prénom" value="">
                    </div>
                    <div class="input-box">
                        <input type="email" class="form-control form-control-lg" name="_email" id="email" placeholder="E-mail" value="">
                    </div>
                    <div class="input-box">
                        <input type="password" class="form-control form-control-lg" name="_password" id="password" placeholder="Mot de passe" value="">
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="form-control form-control-lg" name="_password_verif" id="password_verif" placeholder="Confirmez le mot de passe" value="">
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="input-box">
                        <input type="telephone" class="form-control form-control-lg" name="_telephone" id="telephone" placeholder="Téléphone" value="">
                    </div>

                    <input type="hidden" name="csrf_token_inscription" value="<?php echo $_SESSION['csrf_token_inscription']; ?>">

                    <button type="submit" class="btn">S'inscrire</button>
                </form>
            </div>
        </main>
        


        <?php include 'footer.php'; ?>

    </body>
</html>