<?php
session_start();

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
        <link rel="stylesheet" type="text/css" href="styles_dashboard.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Admin</title>

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
                        <a href="page_dashboard.php" class="bouton-pour-inscripconnex">Admin <i class="fas fa-caret-down"></i></a>
                        <ul class="dropdown">
                            <li ><a href="Deconnexion.php" class="deconnexion-item"><i class="fas fa-sign-out"></i> Se déconnecter</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="page_Connectez.php" class="bouton-pour-inscripconnex">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </header>


        <?php
            // Include la connexion à la base de données
            require 'BD_Connection.php';

            // Récupérer tous les utilisateurs
            $requeteUtilisateurs = "SELECT * FROM Utilisateur";
            $resultUtilisateurs = mysqli_query($conn, $requeteUtilisateurs);

            // Récupérer tous les réservations
            $requeteReservations = "SELECT reservation.*, Utilisateur.Nom, Utilisateur.Prenom, Utilisateur.Email, Utilisateur.Telephone
                        FROM reservation
                        INNER JOIN Utilisateur ON reservation.idUtilisateur = Utilisateur.idUtilisateur
                        ORDER BY Date_Reservation DESC";
            $resultReservations = mysqli_query($conn, $requeteReservations);


            // Récupérer tous les contacts
            $requeteContacts = "SELECT Contact.*, Utilisateur.Nom, Utilisateur.Prenom, Utilisateur.Email, Utilisateur.Telephone
                                FROM Contact
                                INNER JOIN Utilisateur ON Contact.idUtilisateur = Utilisateur.idUtilisateur
                                ORDER BY idContact DESC";
            $resultContacts = mysqli_query($conn, $requeteContacts);
            ?>

    <main>
    <section class="info">
        <h1>Clients</h1>
        <div class="content">
            <?php if (mysqli_num_rows($resultUtilisateurs) > 0) {?>
            <table cellpadding='0' cellspacing='0' border='0'>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = mysqli_fetch_assoc($resultUtilisateurs)) {
                            echo "<tr>
                                    <td>{$row['Nom']}</td>
                                    <td>{$row['Prenom']}</td>
                                    <td>{$row['Email']}</td>
                                    <td>{$row['Telephone']}</td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
            <?php
                } else {
                    echo "<p><i class='fa-solid fa-circle-info'></i> Aucun client.</p>";
                }
            ?>
        </div>
    </section>
        <section class="info">
            <h1>Réservations</h1>
            <div class="content">
                <?php if (mysqli_num_rows($resultReservations) > 0) {?>
                <table cellpadding='0' cellspacing='0' border='0'>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Nombre de Personnes</th>
                            <th>Commentaires</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    

                    <tbody>
                        <?php
                                while ($row = mysqli_fetch_assoc($resultReservations)) {
                                    // Calcule la date de modification autorisée (10 heures avant la réservation)
                                    $reservationDateTime = strtotime($row['Date_Reservation'] . ' ' . $row['Heure_Reservation']);
                                    $modificationAllowedTime = $reservationDateTime - 10 * 3600; // 10 heures en secondes

                                    // Vérifie si la date actuelle est avant la date de modification autorisée
                                    if (time() <= $modificationAllowedTime) {
                                        // Autoriser la modification
                                        $actionButton = "
                                            <form method='post' action='delete_reservation.php'>
                                                <input type='hidden' name='idReservation' value='{$row['idReservation']}'>
                                                <input type='submit' value='Supprimer' class='button-3'>
                                            </form>";
                                        
                                    } else {
                                        // Affiche un message indiquant que la réservation est terminée
                                        if ($reservationDateTime > time()) {
                                            $actionButton = "<p>Impossible de modifier</p>";
                                        } else {
                                            $actionButton = "<p>Réservation terminée</p>";
                                            
                                        }
                                        // Ne pas afficher le bouton "Annuler" après la date de la réservation
                                        
                                    }

                               
                                    echo "<tr>
                                            <td>{$row['Nom']}</td>
                                            <td>{$row['Prenom']}</td>
                                            <td>{$row['Email']}</td>
                                            <td>{$row['Telephone']}</td>
                                            <td>{$row['Date_Reservation']}</td>
                                            <td>{$row['Heure_Reservation']}</td>
                                            <td>{$row['Nombre_Personnes']}</td>
                                            <td>{$row['Commentaires']}</td>
                                            <td>{$actionButton}</td>
                                        </tr>";
                                }
                            
                        ?>
                    </tbody>
                </table>
                <?php
                    }else{
                        echo "<p><i class='fa-solid fa-circle-info'></i> Aucune réservation.</p>";
                    }
                ?>
            </div>
        </section>
        <section class="info">
            <h1>Messages</h1>
            <div class="content">
                <?php if (mysqli_num_rows($resultContacts) > 0) {?>
                <table cellpadding='0' cellspacing='0' border='0'>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_assoc($resultContacts)) {
                                echo "<tr>
                                        <td>{$row['Nom']}</td>
                                        <td>{$row['Prenom']}</td>
                                        <td>{$row['Email']}</td>
                                        <td>{$row['Telephone']}</td>
                                        <td>{$row['Message']}</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }else{
                        echo "<p><i class='fa-solid fa-circle-info'></i> Aucun message.</p>";
                    }
                ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    </body>
</html>

