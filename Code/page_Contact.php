<?php include('config.php'); 

if (!isset($_SESSION['csrf_token_contact'])) {
    $_SESSION['csrf_token_contact'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Contact.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Contact</title>
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
                    <?php if ($_SESSION['isAdmin'] == 1): ?>
                        <li>
                            <a href="page_dashboard.php" class="bouton-pour-inscripconnex">Admin <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown">
                                <li ><a href="Deconnexion.php" class="deconnexion-item"><i class="fas fa-sign-out"></i> Se déconnecter</a></li>
                            </ul>
                        </li>
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
                    <li><a href="page_Connectez.php" >Contact</a></li>
                    <li><a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a></li>
                <?php endif; ?>
            </ul>
    </header>

        <main>
            <aside>
                
                <p><span>N</span>ous sommes impatients de vous accueillir dans notre restaurant et de répondre 
                    à toutes vos demandes. Si vous avez des questions ou des besoins particuliers, n'hésitez pas 
                    à nous contacter. Notre équipe dévouée est à votre disposition pour vous assister. Vous pouvez 
                    nous joindre par téléphone ou par e-mail, et nous serons heureux de discuter de la meilleure 
                    façon de rendre votre expérience avec nous inoubliable. Votre satisfaction est notre priorité, 
                    et nous sommes là pour répondre à tous vos besoins.</p>
                <h3>leraffinoir62100@gmail.com</h3>

            </aside>

            <form method="post" action="BD_Contact.php">
                <label for="nom">Nom :</label>
                <input type="text" placeholder="Votre nom" id="nom" name="nom" required>
    
                <label for="email">E-mail :</label>
                <input type="email" placeholder="Votre mail" id="email" name="email" required>
    
                <label for="telephone">Téléphone :</label>
                <input type="tel" placeholder="Votre numéro" id="telephone" name="telephone" required>
    
                <label for="message">Message :</label>
                <textarea placeholder="Votre message ..." id="message" name="message" rows="4"></textarea>

                <input type="hidden" name="csrf_token_contact" value="<?php echo $_SESSION['csrf_token_contact']; ?>">
    
                <input type="Submit" value="Envoyer le message">
            </form>
        </main>


        <?php include 'footer.php'; ?>

    </body>
</html>