<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['csrf_token_reservation'])) {
    $_SESSION['csrf_token_reservation'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles_Reservation.css">
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
                        <a href="page_Administrateur.php" class="bouton-pour-inscripconnex">Admin</a>
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
                    <a href="page_Connectez.php" >Contact</a>
                    <a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a>
                <?php endif; ?>
            </ul>
    </header>

        <div class="body">

            <aside>
                <h1><span>R</span>éservation</h1>
                <p>Votre réservation dans notre restaurant est la première étape pour vivre une expérience gastronomique 
                exceptionnelle. Notre équipe est prête à vous accueillir avec chaleur et à vous offrir un service de première 
                classe. Pour réserver une table, veuillez utiliser notre système de réservation en ligne, qui vous permet de 
                choisir votre date, votre heure et le nombre de convives. Si vous avez des demandes spéciales ou des besoins 
                alimentaires particuliers, n'hésitez pas à les mentionner lors de la réservation. Nous faisons tout notre 
                possible pour personnaliser votre expérience. Nous sommes impatients de vous accueillir et de vous faire 
                découvrir l'harmonie parfaite entre saveurs exquises et ambiance raffinée.</p>
            </aside>


            <main>
                <form method="post" action="BD_Reservation.php">
                    <label for="nom">Nom :</label>
                    <input type="text" placeholder="Votre nom" id="nom" name="nom" required>
        
                    <label for="email">E-mail :</label>
                    <input type="email" placeholder="Votre mail" id="email" name="email" required>
        
                    <label for="telephone">Téléphone :</label>
                    <input type="tel" placeholder="Votre numéro" id="telephone" name="telephone" required>
        
                    <label for="date">Date de réservation :</label>
                    <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
        
                    <label for="heure">Heure de réservation :</label>
                    <select id="heure" name="heure" class="reservation-heure" required>
                        <?php
                        // Définissez les heures d'ouverture et de fermeture du restaurant
                        $heureOuverture = 10;
                        $heureFermeture = 22;

                        // Générez les options pour le menu déroulant avec une boucle
                        for ($heure = $heureOuverture; $heure <= $heureFermeture; $heure++) {
                            for ($minute = 0; $minute < 60; $minute += 15) {
                                $heureFormat = str_pad($heure, 2, '0', STR_PAD_LEFT);
                                $minuteFormat = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                $heureAffichage = "$heureFormat:$minuteFormat";
                                
                                // Ne pas afficher les heures après 22h00
                                if ($heure < $heureFermeture || ($heure == $heureFermeture && $minute == 0)) {
                                    echo "<option value=\"$heureAffichage\">$heureAffichage</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    
                    <label for="personnes">Nombre de personnes :</label>
                    <input type="number" placeholder="0" id="personnes" name="personnes" required>
        
                    <label for="commentaires">Commentaires :</label>
                    <textarea placeholder="maximum 2000 caractères ..." id="commentaires" name="commentaires" rows="4"></textarea>
                    
                    <input type="hidden" name="csrf_token_reservation" value="<?php echo $_SESSION['csrf_token_reservation']; ?>">

                    <input type="submit" value="Réserver">
                </form>
            </main>
            
        </div>


        <?php include 'footer.php'; ?>


    </body>
</html>