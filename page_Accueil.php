<?php include('config.php'); ?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Accueil.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Le RAFFINOIR</title>
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
                <li><a href="Bd_Contact.php?redirect=page_Contact.php">Contact</a></li>
                <li><a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a></li>
                <?php endif; ?>

                
            </ul>
    </header>



        <?php if ($_SESSION['idUtilisateur']): ?>
            <section id="présentation">
        <a href="page_Reservation.php" class="bouton2">RESERVATION</a>
        </section>
        <?php else: ?>
            <section id="présentation">
                <a href="BD_Reservation.php?redirect=page_Reservation.php" class="bouton2">RESERVATION</a>
            </section>
        <?php endif; ?>


        
      
        <section id="apropos">
            
                <div class="left-content">
                    <h2>À propos</h2>
                    <p>Le RAFFINOIR, un établissement où l'art culinaire est sublimé par l'élégance et un service exceptionnel. Au cœur de notre restaurant, notre équipe de chefs talentueux s'engage avec passion à vous offrir des expériences gustatives inoubliables. Chacun de nos plats est une œuvre d'art culinaire, méticuleusement préparée avec des ingrédients de la plus haute qualité pour créer des saveurs uniques qui réjouiront vos sens. Que vous soyez un fin gourmet en quête de découvertes ou un adepte de la cuisine raffinée, notre menu diversifié a été soigneusement conçu pour satisfaire toutes les préférences. Chaque bouchée est une invitation à un voyage sensoriel où l'excellence culinaire se marie à une ambiance raffinée.</p>
                </div>
                <div class="right-image">
                    <img src="images/PC174359 2.jpg" alt="rest" >
                </div>
            
        </section>
        
        <section class = "temoignage" id="temoignage">
            <h2><span>N</span>otre restaurant à travers les yeux de nos clients </h2>
             <div class="contenu">
                <div class="cadre">
                    <div class="photo1">
                        <img src="images/homme.jpg" >
                    </div>
                    <div class="avis">
                        <p>"Nous avons célébré notre anniversaire de mariage ici, et le restaurant a dépassé toutes nos attentes. Le personnel attentionné a rendu notre soirée spéciale, et la nourriture était exquise."</p>
                        <h3>Julien Dupont</h3>
                    </div>
                </div>
                <div class="cadre">
                    <div class="photo1">
                        <img src="images/femme-affaires-confiante-elegante-souriant_176420-19466.jpg" >
                    </div>
                    <div class="avis">
                        <p>"Nous avons visité le restaurant pour un déjeuner d'affaires, et nous n'aurions pas pu faire un meilleur choix. La cuisine était délicieuse, et le service a été rapide, ce qui était parfait pour notre réunion."</p>
                        <h3>Luna Buisson</h3>
                    </div>
                </div>
                <div class="cadre">
                    <div class="photo1">
                        <img src="images/femmeage.JPG" >
                    </div>
                    <div class="avis">
                        <p>"Le service était impeccable, le chef a créé une expérience gustative inoubliable pour nous. Nous recommandons vivement ce restaurant à tous les amateurs de bonne cuisine."</p>
                        <h3>Valerie Alicante</h3>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </body>
</html>