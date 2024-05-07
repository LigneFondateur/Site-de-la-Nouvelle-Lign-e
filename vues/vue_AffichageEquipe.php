<?php
// Inclure le fichier de connexion à la base de données
require_once('../classesPHP/classe_ConnexionBdd.php');
require_once '../classesPHP/classe_GestionUtilisateur.php';
require_once '../classesPHP/classe_GestionEquipe.php';

$gestionUtilisateur = new GestionUtilisateur();
$gestionEquipe = new GestionEquipe();


if(!empty($_SESSION['utilisateur'])){
    $sessionIdUtilisateur = $_SESSION['utilisateur']->id;
}

// Si l'onglet est "affichageEquipe", afficher les sections spécifiques
if ($_GET['onglet'] === 'affichageEquipe') {
    // Vérifier si l'identifiant de l'équipe est passé en tant que paramètre dans l'URL
    if (isset($_GET['idEquipe'])) {
        // Récupérer l'identifiant de l'équipe depuis l'URL
        $idEquipe = $_GET['idEquipe'];

        // Créer une instance de la classe de connexion à la base de données
        $db = new ConnexionBdd();

        // Exécuter la requête pour obtenir les détails de l'équipe spécifiée
        $equipe = $db->prepare("SELECT * FROM equipe WHERE id = ?", [$idEquipe], true);

        // Vérifier si l'équipe existe
        if ($equipe) {
            // Commencer la section de contour pour cette équipe
            echo '<section class="contourCarte">';
            echo '<section class="effetCarte"></section>';
            echo '<section class="carte">';
            echo "<h1>Équipe {$equipe->nom} de la Nouvelle Lignée</h1>";
            echo "<h1>{$gestionEquipe->getPlacesDisponnibles($equipe->id)}</h1>";


            echo '<input type="text" class="placeTexte_Recherche" placeholder="Rechercher un utilisateur">';

            // Récupérer les utilisateurs de cette équipe depuis la base de données
            $utilisateurs = $db->prepare("SELECT * FROM utilisateur WHERE id IN (SELECT idUtilisateur FROM contenir WHERE idEquipe = ?)", [$equipe->id]);


            // Boucle à travers les utilisateurs pour les afficher
            foreach ($utilisateurs as $utilisateur) {
                // Récupérer le rôle de l'utilisateur dans l'équipe
                $equipeRole = $db->prepare("SELECT 
                                                CASE 
                                                    WHEN utilisateur.estGestionnaire = 1 THEN 'Gestionnaire'
                                                    WHEN administrer.estHabiliteAdmin = 1 THEN 'Administrateur'
                                                    WHEN contenir.idRole IS NOT NULL THEN contenir.idRole
                                                END AS role
                                            FROM utilisateur
                                            LEFT JOIN contenir ON utilisateur.id = contenir.idUtilisateur
                                            LEFT JOIN administrer ON utilisateur.id = administrer.idUtilisateur AND contenir.idEquipe = administrer.idEquipe
                                            WHERE utilisateur.id = ? AND contenir.idEquipe = ?", 
                                            [$utilisateur->id, $idEquipe], true);


                echo '<div class="wrapper">';
                // Afficher le rôle de l'utilisateur dans l'équipe
                echo '<button class="btn_Selection" onclick="gestionEquipe.afficherCarteUtilisateur(' . $idEquipe . ', ' . $utilisateur->id . ')">';
                echo '<p class="pseudoUtilisateur">' . $utilisateur->pseudo . '</p>';
                echo '<p class="roleUtilisateur">' . ($equipeRole ? $equipeRole->role : '') . '</p>';
                echo '</button>';
                if(!empty($_SESSION['utilisateur']) && $gestionUtilisateur->estGestionnaire($sessionIdUtilisateur)){
                    //if(!$gestionUtilisateur->estGestionnaire($utilisateur->id)){
                        echo '<button class="btn_Gestion" onclick="gestionEquipe.allerGererUtilisateur(' . $idEquipe . ', ' . $utilisateur->id . ')">Gérer</button>';
                        //}
                echo '</div>';

                }
            }


            // Fermer les sections
            echo '</section>';
            echo '</section>';
            echo '</section>';
        } else {
            routeur('erreur');
        }
    } else {
        // Si aucun identifiant d'équipe n'est fourni, afficher un message d'erreur
        routeur('erreur');
    }
}
?>
<script src="../classesJS/classe_GestionEquipe.js"></script>
<script src="../scripts/script_GestionEquipe.js"></script>
</body>
</html>
