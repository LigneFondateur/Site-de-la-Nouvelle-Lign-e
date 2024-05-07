<?php
require_once('../classesPHP/classe_ConnexionBdd.php');



// Établir la connexion à la base de données
try {
    $connexionBdd = new ConnexionBdd();

    // Exemple de récupération des utilisateurs depuis la base de données
    $utilisateurs = $connexionBdd->prepare("SELECT * FROM Utilisateur", [], false);

    // Exemple de récupération des équipes depuis la base de données
    $equipes = $connexionBdd->prepare("SELECT * FROM Equipe", [], false);

    // Exemple de récupération des rôles depuis la base de données
    $roles = $connexionBdd->prepare("SELECT * FROM Role", [], false);
} catch (PDOException $e) {
    // Gérer les erreurs de connexion ou d'exécution de requête
    echo "Erreur lors de la connexion à la base de données: " . $e->getMessage();
    exit; // Arrêter l'exécution du script en cas d'erreur
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titrePage; ?></title>
</head>
<body>
<?php
    require_once '../ressources/ressource_Styles.php';
?>
  <section class="contourCarte">
    <section class="effetCarte"></section>
        <section class="carte">
            <div class="progressionCreationCandidature"> 
                <div class="progressionCreationCandidatureActive">
                    <div class="progressionCreationCandidatureBar"></div>
                    <p id="etape1">Pseudo d'équipe</p>
                    <p id="etape2">Rôle par Equipes</p>
                    <p id="etape3">Ambitions</p>
                    <p id="etape4">Envoi de la demande d'adhésion</p>
                </div>
            </div>
            <form method="POST" action="../modeles/modele_CreationCandidature.php" id="multiFormCandidature">

            <!-- pseudoEquipe -->
            <section class="pseudoEquipe">
                <h3>Reflétez votre identité avec un pseudo</h3>
                <p>Entrez votre pseudo d'équipier :<input class="placeTexte" type="text" name="pseudo" placeholder="Pseudo" id="pseudo" required></p>
            </section>

            <!-- equipesRole -->
            <section class="equipesRole" style="display: none;">
                <section style="display: flex;" class="affichageChoixEquipesRole">
                    <p>Équipe</p>
                    <br>
                    <section class="listeCarrouselAvecNav">
                        <section class="listeCarrousel">
                            <button type="button" class="equipeButton" onclick="majEquipes(-1)">&#129190;</button>
                            <p id="equipeSelection" class="nomEquipeSelection"><?php echo $equipes[0]->nom; ?></p>
                            <button type="button" class="equipeButton" onclick="majEquipes(1)">&#129191;</button>
                        </section>
                        <div class="equipeButtons"></div>
                    </section>
                    <p id="roleLabel">Rôle pour l'équipe <?php echo $equipes[0]->nom; ?></p>
                    <section class="listeCarrouselAvecNav">
                        <section class="listeCarrousel">
                            <button type="button" class="roleButton" onclick="majRoles(-1)">&#129190;</button>
                            <p class="nomRoleSelection"><?php echo $roles[0]->nom; ?></p>
                            <button type="button" class="roleButton" onclick="majRoles(1)">&#129191;</button>
                        </section>
                        <div class="roleButtons"></div>
                    </section>
                <button id="btnAjouter" class="btn_Ajouter" type="button">Ajouter</button>
                <hr>
                </section>
            </section>


        <!-- Ambitions -->
        <section class="alignement_Centre ambitions" id="sectionAmbitions" style="display: none;">
            <h3>Faites la différence avec les autres candidats</h3>
            <textarea id="ambitions" name="ambitions" class="placeTexteGrande" placeholder="Pourquoi voulez-vous rejoindre notre équipe ?" required></textarea>
        </section>


        <!-- envoiDemandeAdhesion -->
        <section class="envoiDemandeAdhesion" style="display: none;">
            <h3>Envoyer la demande d'adhesion</h3>
                <p>Pour votre notification de validation de la création votre compte :<input class="placeTexte" type="text" id="email" name="email" placeholder="email" required></p>   
            </div>
                <p>Confirmez votre e-mail :<input class="placeTexte" type="text" id="emailConfirmation" name="emailConfirmation" placeholder="Confirmez votre e-mail" required></p>
            </div>
        </section>


    
        <section class="piedCarteCreationCandidature" id="piedCarteCreationCandidature">

                <button type="button" class="btn_Quitter" id="btnQuitter">Quitter</button>
                <script>
                    document.getElementById("btnQuitter").addEventListener("click", function() {
                        // Code à exécuter lorsque le bouton est cliqué
                        window.location.href = "../routeurs/routeur.php?onglet=accueil";
                    });
                </script>
                <a id="btnRetour" class="btn_MultiRetour">Retour</a>
                <button id="btnContinuer" class="btn_Continuer" type="button">Continuer</button>
                    <button type="submit" name="btnEnvoyer" id="btnEnvoyer" class="btn_Envoyer">Envoyer</button>
            </section>
            </form>


            <section class="recuperationDemandeAdhesion" style="display: none;">
            <div id="message"></div>



                <section class="piedCarteCreationCandidature">
                    <form method="GET" action="../routeurs/routeur.php">
                        <button type="submit" name="onglet" value="accueil" id="btnQuitter" class="btn_Quitter">Quitter</button>
                    </form>
                </section>
            </section>


        </section>
    </section>

    
    <script src="../scripts/script_EnvoiCandidature.js"></script>              
    <?php require_once("../encodages/encodage_CreationCandidature.php"); ?>
    <script src="../classesJS/classe_SelectionEquipeRoleCreationCandidature.js"></script>
    <script src="../scripts/script_SelectionEquipeRoleCreationCandidature.js"></script>
    <script src="../classesJS/classe_CreationCandidature.js"></script>
    <script src="../classesJS/classe_ProgressionCreationCandidature.js"></script>
    <script src="../scripts/script_CreationCandidature.js"></script>

</body>
</html>


