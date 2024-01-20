<?php
session_start();

// Génération du token CSRF
$csrf_token = bin2hex(random_bytes(32));


// Stockage du token CSRF dans la session
$_SESSION['csrf_token_modifier_reservation'] = $csrf_token;

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
require 'BD_Connection.php';
$idReservation = $_POST['idReservation'] ?? '';
$_SESSION['idReservation'] = $idReservation;

$requeteDetails = "SELECT * FROM reservation WHERE idReservation = ?";
    $stmtDetails = $conn->prepare($requeteDetails);
    $stmtDetails->bind_param("i", $idReservation);
    $stmtDetails->execute();
    $resultDetails = $stmtDetails->get_result();

    // Vérifie si la requête a réussi
    if ($resultDetails) {
        if ($resultDetails->num_rows > 0) {
            // Récupérez les détails de la réservation
            $rowDetails = $resultDetails->fetch_assoc();

            // Assignez les valeurs aux variables
            $date = $rowDetails['Date_Reservation'];
            $heure = $rowDetails['Heure_Reservation'];
            $personnes = $rowDetails['Nombre_Personnes'];
            $commentaires = $rowDetails['Commentaires'];
        } else {
            echo "Aucun détail de réservation trouvé.";
        }
    } else {
        echo "Erreur lors de la récupération des détails de réservation.";
    }

    // Ferme le statement
    $stmtDetails->close();

    // Ferme la connexion à la base de données
    $conn->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="styles_ModRes.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Modifier Réservation</title>
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
        <h1>Modifier la réservation</h1>
        <div class="content">
            <div class="left-content">
                <form method="post" action="BD_ModifierReservation.php">
                
                    <label for='date'>Date de réservation :</label>
                    <input type="date" id="date" name="date" value="<?= $date ?>" required min="<?php echo date('Y-m-d'); ?>">
                    
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
                                    if($heureAffichage == $rowDetails['Heure_Reservation']){
                                        echo "<option value=\"$heureAffichage\" selected>$heureAffichage</option>";
                                    }else{
                                        echo "<option value=\"$heureAffichage\">$heureAffichage</option>";
                                    }
                                }
                            }
                        }
                        ?>
                    </select>

                    <label for='personnes'>Nombre de personnes :</label>
                    <input type='number' id='personnes' name='personnes' value="<?= $personnes ?>" required>

                    <label for="commentaires">Commentaire :</label>
                    <textarea placeholder="Maximum 2000 caractères ..." id="commentaires" name="commentaires" rows="4"><?= $commentaires ?></textarea>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Sélectionnez l'élément d'entrée pour l'heure de réservation
                            var heureInput = document.querySelector('.reservation-heure');

                            // Ajoutez un gestionnaire d'événements pour le changement de valeur
                            heureInput.addEventListener('input', function () {
                                // Obtenez la valeur actuelle de l'heure
                                var heure = heureInput.value;

                                // Définissez les heures d'ouverture du restaurant
                                var heureOuverture = "10:00";
                                var heureFermeture = "23:00";

                                // Vérifiez si l'heure de réservation est en dehors des heures d'ouverture
                                if (heure < heureOuverture || heure > heureFermeture) {
                                    alert("Le restaurant est ouvert de 10h à 23h. Veuillez choisir une heure pendant ces heures d'ouverture.");
                                    // Réinitialisez la valeur de l'heure
                                    heureInput.value = "";
                                }
                            });
                        });
                    </script>
                    <input type="submit" value="Modifier la réservation">
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>


</body>

</html>
