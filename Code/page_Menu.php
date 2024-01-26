<?php include('config.php'); ?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Menu.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Réservation</title>
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

        <section class="menu-P_P">
            <div class="menu-item">
                <img src="images/menu-P_Principale.jpg" alt="P_P" class="firstimg">
            </div>
        </section>
    
        <section class="menu-Dej">
            <div class="menu-item">
                <img src="images/menu-Dej.jpg" alt="Dej">
            </div>
        </section>

        <section class="menu-Salades">
            <div class="menu-item">
                <img src="images/menu-Salades.jpg" alt="Salades">
            </div>
        </section>

        <section class="menu-Plat">
            <div class="menu-item">
                <img src="images/menu-Plats.jpg" alt="Plat">
            </div>
        </section>

        <section class="menu-Desserts">
            <div class="menu-item">
                <img src="images/menu-Desserts.jpg" alt="Desserts">
            </div>
        </section>

        <section class="menu-B_Chaudes">
            <div class="menu-item">
                <img src="images/menu-B_Chaudes.jpg" alt="B_Chaudes">
            </div>
        </section>

        <section class="menu-B_Fraiches">
            <div class="menu-item">
                <img src="images/menu-B_Fraiches.jpg" alt="B_Fraiches">
            </div>
        </section>

        <div class="tele-menu">
            <a href="images/menu.pdf" download="Menu_Restaurant.pdf">Télécharger le menu au format PDF</a>
        </div>

        
        <?php include 'footer.php'; ?>
        


    </body>
</html>