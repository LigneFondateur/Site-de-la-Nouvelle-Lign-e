<?php
require_once('../classesPHP/classe_GestionAdhesion.php');

$adhesion = new GestionAdhesion();
$demandesValidees = $adhesion->getDemandesValidees();
$demandesRefusees = $adhesion->getDemandesRefusees();
$demandesEnAttente = $adhesion->getDemandesEnAttente();
$toutesDemandes = $adhesion->getToutesDemandes();
if(!empty($_SESSION['utilisateur'])){
    $idUtilisateur = $_SESSION['utilisateur']->id;
}else{
    $idUtilisateur = [];
}
?>

<div class="sousEntete";>

    <h1>Candidatures actuelles</h1>
    <?php
    // Affichage du nombre de demandes d'adhésion validées
    if (is_array($demandesValidees)) {
        echo "<p>Nombre de demandes d'adhésion validées : " . count($demandesValidees) . "</p>";
    } else {
        echo "<p>Nombre de demandes d'adhésion validées : 0</p>";
    }
    // Affichage du nombre de demandes d'adhésion refusées
    if (is_array($demandesRefusees)) {
        echo "<p>Nombre de demandes d'adhésion refusées : " . count($demandesRefusees) . "</p>";
    } else {
        echo "<p>Nombre de demandes d'adhésion refusées : 0</p>";
    }

    // Affichage du nombre actuels de demandes d'adhésion
    if (is_array($toutesDemandes)) {
        echo "<p>Nombre de demandes d'adhésion totales : " . count($toutesDemandes) . "</p>";
    } else {
        echo "<p>Nombre de demandes d'adhésion totales : 0</p>";
    }
    ?>
</div>
<section class="pageCandidatures">
    <?php
    foreach ($demandesValidees as $demandeValide) {
        // Récupération de l'ID de la demande
        $idDemande = $demandeValide->id; 

        echo '<section class="contourCarte" style="margin-inline :15px">';
        echo '<section class="effetCarte"></section>';
        echo '    <section class="carte">';

        // Afficher les informations de la demande d'adhésion validée
        echo '        <h2>Pseudo: ' . $demandeValide->pseudo . '</h2>';
        echo '        <p>Ambitions: ' . $demandeValide->ambitions . '</p>';

        // Appel de la méthode pour obtenir les équipes et leurs rôles associés
        $equipesRoles = $adhesion->getEquipesRole($idDemande);

        // Parcours des équipes et de leurs rôles associés
        foreach ($equipesRoles as $equipeRole) {
            echo '        <p>Voudrait rejoindre l\'équipe ' . $equipeRole['equipe'] . ' avec le rôle: ' . $equipeRole['role'] . '</p>';
        }

        if (!empty($demandeValide->interetsSelectionne)) {
            echo '        <p>Intérêts sélectionnés: ' . $demandeValide->interetsSelectionne . '</p>';
        }

        echo '        <p>Cette demande à à été validée</p>';

        // Date limite (3 mois après la date de validation ou de demande)
        $dateObtention = $demandeValide->dateObtention ? new DateTime($demandeValide->dateObtention) : new DateTime($demandeValide->dateDemande);
        $dateLimite = clone $dateObtention;
        $dateLimite->add(new DateInterval('P3M'));

        // Temps restant jusqu'à la date limite (3 mois)
        $maintenant = new DateTime();
        $interval = $maintenant->diff($dateLimite);
        $tempsRestant = $interval->format('%m mois, %d jours, %h heures, %i minutes et %s secondes');

        echo '        <p id="remainingTime' . $idDemande . '">Durée restante pour changer le mot de passe par défaut de la candidature: ' . $tempsRestant . '</p>';

        if($gestionUtilisateur->estGestionnaire($idUtilisateur)){
            echo '<form method="post">';
            echo '<button class="btn_Retirer" id="btnRefuserAdhesion' . $idDemande . '" name="btnRefuserAdhesion' . $idDemande . '">Refuser Adhésion</button>';
            echo '</form>';
        
            // Vérifier si le bouton a été soumis
            if (isset($_POST["btnRefuserAdhesion" . $idDemande])) {
                $adhesion->refuserDemande($idDemande, $motifRefus); // Refuse la demande d'adhésion
            }
        }



        echo '    </section>';
        echo '</section>';
        ?>
        <script>
            function updateRemainingTime<?php echo $idDemande; ?>() {
                var now = new Date();  // Date actuelle
                var limitDate = new Date("<?php echo $dateLimite->format('Y-m-d H:i:s');?>");  // Date limite
                var difference = limitDate - now;  // Calcul de la différence en millisecondes
                var months = Math.floor(difference / (1000 * 60 * 60 * 24 * 30));  // Calcul des mois restants
                var days = Math.floor(difference / (1000 * 60 * 60 * 24)) % 30;  // Calcul des jours restants
                var hours = Math.floor((difference / (1000 * 60 * 60)) % 24);  // Calcul des heures restantes
                var minutes = Math.floor((difference / (1000 * 60)) % 60);  // Calcul des minutes restantes
                var seconds = Math.floor((difference / 1000) % 60);  // Calcul des secondes restantes

                // Construire l'affichage du temps restant
                var remainingTime = "Durée restante pour changer le mot de passe par défaut de la candidature: ";
                if (months > 0) {
                    remainingTime += months + " mois, ";
                }
                if (days > 0) {
                    remainingTime += days + " jours, ";
                }
                if (hours > 0) {
                    remainingTime += hours + " heures, ";
                }
                if (minutes > 0) {
                    remainingTime += minutes + " minutes, ";
                }
                if (seconds > 0) {
                    remainingTime += seconds + " secondes ";
                }

                // Mettre à jour l'affichage du temps restant
                document.getElementById("remainingTime<?php echo $idDemande; ?>").innerHTML = remainingTime;
            }

            // Appeler la fonction une fois pour mettre à jour immédiatement
            updateRemainingTime<?php echo $idDemande; ?>();

            // Actualiser le temps restant toutes les secondes
            setInterval(updateRemainingTime<?php echo $idDemande; ?>, 1000);
        </script>
        <?php
    }
    ?>
    <?php
    foreach ($demandesRefusees as $demandeRefusee) {
        // Récupération de l'ID de la demande
        $idDemande = $demandeRefusee->id; 

        echo '<section class="contourCarte" style="margin-inline :15px">';
        echo '<section class="effetCarte"></section>';
        echo '    <section class="carte">';

        // Afficher les informations de la demande d'adhésion refusée
        echo '        <h2>Pseudo: ' . $demandeRefusee->pseudo . '</h2>';
        echo '        <p>Ambitions: ' . $demandeRefusee->ambitions . '</p>';

        // Appel de la méthode pour obtenir les équipes et leurs rôles associés
        $equipesRoles = $adhesion->getEquipesRole($idDemande);

        // Parcours des équipes et de leurs rôles associés
        foreach ($equipesRoles as $equipeRole) {
            echo '        <p>Voudrait rejoindre l\'équipe ' . $equipeRole['equipe'] . ' avec le rôle: ' . $equipeRole['role'] . '</p>';
        }

        if (!empty($demandeRefusee->interetsSelectionne)) {
            echo '        <p>Intérêts sélectionnés: ' . $demandeRefusee->interetsSelectionne . '</p>';
        }

        echo '        <p>Cette demande a été refusée</p>';

        // Date limite (3 mois après la date de refus)
        $dateObtention = new DateTime($demandeRefusee->dateObtention);
        $dateLimite = clone $dateObtention;
        $dateLimite->add(new DateInterval('P3M'));

        // Temps restant jusqu'à la date limite (3 mois)
        $maintenant = new DateTime();
        $interval = $maintenant->diff($dateLimite);
        $tempsRestant = $interval->format('%m mois, %d jours, %h heures, %i minutes et %s secondes');

        echo '        <p id="remainingTime' . $idDemande . '">Durée restante pour changer le mot de passe par défaut de la candidature: ' . $tempsRestant . '</p>';

        echo '    </section>';
        echo '</section>';
        ?>
        <script>
            function updateRemainingTime<?php echo $idDemande; ?>() {
                var now = new Date();  // Date actuelle
                var limitDate = new Date("<?php echo $dateLimite->format('Y-m-d H:i:s');?>");  // Date limite
                var difference = limitDate - now;  // Calcul de la différence en millisecondes
                var months = Math.floor(difference / (1000 * 60 * 60 * 24 * 30));  // Calcul des mois restants
                var days = Math.floor(difference / (1000 * 60 * 60 * 24)) % 30;  // Calcul des jours restants
                var hours = Math.floor((difference / (1000 * 60 * 60)) % 24);  // Calcul des heures restantes
                var minutes = Math.floor((difference / (1000 * 60)) % 60);  // Calcul des minutes restantes
                var seconds = Math.floor((difference / 1000) % 60);  // Calcul des secondes restantes

                // Construire l'affichage du temps restant
                var remainingTime = "Durée restante pour changer le mot de passe par défaut de la candidature: ";
                if (months > 0) {
                    remainingTime += months + " mois, ";
                }
                if (days > 0) {
                    remainingTime += days + " jours, ";
                }
                if (hours > 0) {
                    remainingTime += hours + " heures, ";
                }
                if (minutes > 0) {
                    remainingTime += minutes + " minutes, ";
                }
                if (seconds > 0) {
                    remainingTime += seconds + " secondes ";
                }

                // Mettre à jour l'affichage du temps restant
                document.getElementById("remainingTime<?php echo $idDemande; ?>").innerHTML = remainingTime;
            }

            // Appeler la fonction une fois pour mettre à jour immédiatement
            updateRemainingTime<?php echo $idDemande; ?>();

            // Actualiser le temps restant toutes les secondes
            setInterval(updateRemainingTime<?php echo $idDemande; ?>, 1000);
        </script>
        <?php
    }
    ?>


    <?php

    // Affichage des demandes d'adhésion en attente de validation
    foreach ($demandesEnAttente as $demandeEnAttente) {
        $idDemande = $demandeEnAttente->id; // Récupération de l'ID de la demande

        echo '<section class="contourCarte" style="margin-inline :15px">';
        echo '<section class="effetCarte"></section>';
        echo '<section class="carte">';

        // Afficher les informations de la demande d'adhésion en attente
        echo '<h2>Pseudo: ' . $demandeEnAttente->pseudo . '</h2>';
        echo '<p>Ambitions: ' . $demandeEnAttente->ambitions . '</p>';

        // Appel de la méthode pour obtenir les équipes et leurs rôles associés
        $equipesRoles = $adhesion->getEquipesRole($idDemande);

        // Parcours des équipes et de leurs rôles associés
        foreach ($equipesRoles as $equipeRole) {
            echo '        <p>Voudrait rejoindre l\'équipe ' . $equipeRole['equipe'] . ' avec le rôle: ' . $equipeRole['role'] . '</p>';
        }

        if (!empty($demandeEnAttente->interetsSelectionne)) {
            echo '        <p>Intérêts sélectionnés: ' . $demandeEnAttente->interetsSelectionne . '</p>';
        }



        if($gestionUtilisateur->estGestionnaire($idUtilisateur)){
            echo '<form method="post">';
            echo '<button class="btn_Confirmation" id="btnValiderAdhesion' . $idDemande . '" name="btnValiderAdhesion' . $idDemande . '">Valider Adhésion</button>';
            echo '<button class="btn_Retirer" id="btnRefuserAdhesion' . $idDemande . '" name="btnRefuserAdhesion' . $idDemande . '">Refuser Adhésion</button>';
            echo '</form>';

            // Vérifier si le bouton a été soumis
            if (isset($_POST["btnValiderAdhesion" . $idDemande])) {
                $motDePasseParDefaut = $adhesion->validerDemande($idDemande); // Valide la demande d'adhésion et récupère le mot de passe par défaut généré
                echo $motDePasseParDefaut; // Affiche le mot de passe par défaut
            }
            // Vérifier si le bouton a été soumis
            if (isset($_POST["btnRefuserAdhesion" . $idDemande])) {
                $motifRefus = ""; // Définir le motif de refus
                $adhesion->refuserDemande($idDemande, $motifRefus); // Refuse la demande d'adhésion
            }

        }



        echo '</section>';
        echo '</section>';
    }


    ?>
</section>
</section>
