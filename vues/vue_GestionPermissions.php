<?php
    require_once '../classesPHP/classe_GestionUtilisateur.php';
    require_once '../classesPHP/classe_GestionEquipe.php';
    require_once '../classesPHP/classe_GestionRole.php';

    $gestionUtilisateur = new GestionUtilisateur();

    $gestionUtilisateur->verifierConnexion();

    $gestionEquipe = new GestionEquipe();
    $gestionRole = new GestionRole();


    $roles = $gestionRole->getTousNom();

    // Vérifier si l'onglet est "gestionPermissions" et si les identifiants de l'équipe et de l'utilisateur sont présents dans l'URL
    if ($_GET['onglet'] === 'gestionPermissions' && isset($_GET['idEquipe']) && isset($_GET['idUtilisateur'])) {
        // Récupérer l'identifiant de l'équipe et de l'utilisateur depuis l'URL
        $idEquipe = $_GET['idEquipe'];
        $idUtilisateur = $_GET['idUtilisateur'];
        
        // Maintenant, vous pouvez utiliser $idEquipe et $idUtilisateur pour récupérer les détails de l'équipe et de l'utilisateur
        // à partir de la base de données, en utilisant une requête SQL ou une méthode de la classe appropriée.
    }
?>



    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Permissions</title>
</head>
<body>
<?php
    require_once '../ressources/ressource_Styles.php';
?>

<!-- <?php
if($gestionUtilisateur->estGestionnaire($idUtilisateur)){
    echo '<section class="contourCarte">';
    echo '<section class="effetCarte"></section>';
    echo '<section class="carte">';
    echo "<p>L'accès n'est pas autorisé</p>";
    echo "<p>Veuillez qutter cette page</p>";
    echo '<form method="GET" action="../routeurs/routeur.php">';
    echo '<input type="hidden" name="onglet" value="affichageEquipe">';
    echo '<input type="hidden" name="idEquipe" value="' . $idEquipe . '">';
    echo '<button type="submit" class="btn_Quitter" id="btnRetourEquipe">Quitter la page</button>';
    echo '</form>';
    echo '</section>';
    echo '</section>';
    // return;
}
?> -->
    <section class="contourCarte">
        <section class="effetCarte"></section>
        <section class="carte">



        <form method="POST">
        <h1>Gestion des permissions de <?php echo $gestionUtilisateur->getPseudo($idUtilisateur); ?></h1>

            <p id="roleLabel">Rôle pour l'équipe <?php echo $gestionEquipe->getNom($idEquipe); ?></p>
                <section class="listeCarrouselAvecNav">
                    <section class="listeCarrousel">
                        <button type="button" class="roleButton" onclick="majRoles('precedent')">&#129190;</button>
                        <p id="nomRoleSelection" class="nomRoleSelection"><?php echo $roles[0]->nom; ?></p>
                        <button type="button" class="roleButton" onclick="majRoles('suivant')">&#129191;</button>
                    </section>
                    <div class="roleButtons"></div>
                </section>

            <p>Email:<input class="placeTexte" type="text" placeholder="Email" name="email" autocomplete="off" required></p>    
            <p>Mot de passe:<input class="placeTexte" type="text" placeholder="Mot de passe" name="motDePasse" autocomplete="new-password" required></p>
        <button type="submit" name="modifierRole" class="btn_Gestion">Modifier rôle</button>
        
        <button class="btn_Retirer" name="retirerEquipe" type="submit">Retirer de l'équipe <?php echo $gestionEquipe->getNom($idEquipe); ?></button>
    </form>

    <form method="GET" action="../routeurs/routeur.php">
        <input type="hidden" name="onglet" value="affichageEquipe">
        <input type="hidden" name="idEquipe" value="<?php echo $idEquipe; ?>">
        <button class="btn_Retour"  type="submit" id="btnRetourEquipe">Retour</button>
    </form>
        
        
    </section>
    </section>
    <script>
    class CarousselRoles {
        constructor(roles) {
            this.roles = roles; // Stocke les rôles disponibles
            this.currentRoleIndex = 0; // Initialise l'index du rôle actuel à 0 par défaut
        }

        MajIndex(direction) {
            // Vérifier la direction et mettre à jour l'index en conséquence
            if (direction === 'precedent') {
                this.currentRoleIndex = (this.currentRoleIndex - 1 + this.roles.length) % this.roles.length;
            } else if (direction === 'suivant') {
                this.currentRoleIndex = (this.currentRoleIndex + 1) % this.roles.length;
            }

            // Mettre à jour l'affichage des boutons de rôle avec le nouveau nom du rôle sélectionné
            this.MajlisteCarrouselNavs();

            // Mettre à jour le nom du rôle sélectionné affiché
            const roleNameElement = document.getElementById('nomRoleSelection');
            if (roleNameElement) {
                roleNameElement.textContent = this.roles[this.currentRoleIndex].nom;
            }
        }
        ChangerIndex(newIndex) {
            // Mettre à jour l'index avec la nouvelle valeur
            this.currentRoleIndex = newIndex;

            // Mettre à jour l'affichage pour refléter le nouvel index
            this.MajlisteCarrouselNavs();
        }


        MajlisteCarrouselNavs() {
            // Récupérer le conteneur pour les boutons de rôle
            const roleButtonsContainer = document.querySelector('.roleButtons');

            // Effacer tous les boutons présents dans le conteneur
            roleButtonsContainer.innerHTML = '';

            // Générer les boutons de rôle
            this.roles.forEach((role, index) => {
                var roleButton = document.createElement('button');
                roleButton.type = "button"; // Définir le type du bouton sur "button"
                roleButton.classList.add('listeCarrouselNav');
                // Écouter l'événement de clic et changer l'index du rôle
                roleButton.addEventListener('click', () => {
                    this.ChangerIndex(index);
                });
                roleButton.addEventListener('click', () => {
                    this.MajIndex(index - this.currentRoleIndex);
                    this.MajlisteCarrouselNavs(); // Mettre à jour l'affichage après le changement de rôle
                    
                });
                
                // Mettre en surbrillance le bouton d'index par défaut
                if (index === this.currentRoleIndex) {
                    roleButton.classList.add('selected');
                }

                roleButtonsContainer.appendChild(roleButton);
            });
        }
    }


</script>

<script>
    // Instancier la classe CarousselRoles avec les rôles
    const roles = <?php echo json_encode($roles); ?>;
    const carousselRoles = new CarousselRoles(roles);
    carousselRoles.MajlisteCarrouselNavs(); // Générer les boutons de rôle lors du chargement de la page
    // Fonction pour mettre à jour l'index du carrousel des rôles
    function majRoles(direction) {
        carousselRoles.MajIndex(direction);
    }
</script>

</body>
</html>
