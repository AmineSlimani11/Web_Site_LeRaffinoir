<?php
session_start();

// Vérifie si la variable de session 'idUtilisateur' est définie
if (isset($_SESSION['idUtilisateur'])) {
    $idUtilisateur = $_SESSION['idUtilisateur'];
    $Nom = $_SESSION['nom'];
    $Prenom = $_SESSION['prenom'];
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
    <link rel="stylesheet" type="text/css" href="styles_MesReservations.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Mes Réservations</title>
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
        <h1>Mes Réservations</h1>
        <div class="content">
            <?php
                // Connectez-vous à la base de données
                require 'BD_Connection.php';

                // Préparez et exécutez la requête SQL pour récupérer les réservations de l'utilisateur
                $requete = "SELECT * FROM reservation WHERE idUtilisateur = $idUtilisateur ORDER BY Date_Reservation desc";
                $result = mysqli_query($conn, $requete);

                // Vérifie si la requête a réussi
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        // Affiche le tableau des réservations
                        echo "
                            <table cellpadding='0' cellspacing='0' border='0'>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Nombre de Personnes</th>
                                        <th>Commentaire</th>
                                        <th>Action</th>
                                        <th>Annuler</th> <!-- Nouvelle colonne pour annuler -->
                                    </tr>
                                </thead>
                                <tbody>
                        ";

                        // Parcourt les résultats de la requête
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Calcule la date de modification autorisée (10 heures avant la réservation)
                            $reservationDateTime = strtotime($row['Date_Reservation'] . ' ' . $row['Heure_Reservation']);
                            $modificationAllowedTime = $reservationDateTime - 10 * 3600; // 10 heures en secondes

                            // Vérifie si la date actuelle est avant la date de modification autorisée
                            if (time() <= $modificationAllowedTime) {
                                // Autoriser la modification
                                $actionButton = "
                                    <form method='post' action='page_ModifierReservation.php'>
                                        <input type='hidden' name='idReservation' value='" . $row['idReservation'] . "'>
                                        <input type='submit' value='Modifier' class='button-3'>
                                    </form>
                                ";
                                // Ajouter le bouton "Annuler"
                                $cancelButton = "
                                    <form method='post' action='AnnulerReservation.php'>
                                        <input type='hidden' name='idReservation' value='" . $row['idReservation'] . "'>
                                        <input type='submit' value='Annuler' class='button-3'>
                                    </form>
                                ";
                            } else {
                                // Affiche un message indiquant que la réservation est terminée
                                if ($reservationDateTime > time()) {
                                    $actionButton = "<p>Impossible de modifier, moins de 10h pour votre réservation</p>";
                                    
                                    $cancelButton = "
                                    <form method='post' action='AnnulerReservation.php'>
                                        <input type='hidden' name='idReservation' value='" . $row['idReservation'] . "'>
                                        <input type='submit' value='Annuler' class='button-3'>
                                    </form>";
                                } else {
                                    $actionButton = "<p>Réservation terminée</p>";
                                    $cancelButton = "";
                                }
                                // Ne pas afficher le bouton "Annuler" après la date de la réservation
                                
                            }

                            echo "<tr>
                                    <td>{$row['Date_Reservation']}</td>
                                    <td>{$row['Heure_Reservation']}</td>
                                    <td>{$row['Nombre_Personnes']}</td>
                                    <td>{$row['Commentaires']}</td>
                                    <td>{$actionButton}</td>
                                    <td>{$cancelButton}</td>
                                </tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<p><i class='fa-solid fa-circle-info'></i> Aucune réservation.</p>";
                    }
                } else {
                    // Gestion de l'erreur, vous pouvez personnaliser selon vos besoins
                    echo "Erreur lors de la récupération des réservations.";
                }

                // Ferme la connexion à la base de données
                $conn->close();
            ?>
        </div>
    </section>
</main>



<?php include 'footer.php'; ?>

        

</body>

</html>
