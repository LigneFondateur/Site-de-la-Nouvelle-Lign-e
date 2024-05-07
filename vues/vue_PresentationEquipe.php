
    <div class="defilementFixe">
        <!-- Contenu 1: Titre du site -->
        <div class="fixe accueilTitre" id="contenu1">
            <img src="../images/icones/Icone Nouvelle Lignée.png" class="accueilTitreIcone">
            <div class="div_Titre">
                <h1>Nouvelle Lignée</h1>
                <h2>L'émergence en continu</h2>
            </div>
            <section class="div_SoutiensActuels">
                <h2>Soutiens actuels de l'équipe</h2>
                <!-- <p><span id="subscribersCount">chargement...</span></p> -->
                <p><span>la clé est gardée privé</span></p>
                <!-- Bouton "Soutenir l'équipe" avec le nouveau style -->
                <a href="https://www.youtube.com/channel/UCiTfoVv5D0jtfyztkR2T27A/?sub_confirmation=1" class="btn_SoutienEquipe">Soutenir l'équipe</a>
            </section>
        </div>

        <!-- Contenu 2: Vidéo -->
        <div class="fixe accueilPresentation" style="display: none;" id="contenu2">
            <h2>Présentation</h2>

            <p style="padding-left: 15px; padding-right: 15px;">
                La Nouvelle Lignée est une équipe unique dans le paysage du gaming francophone. Née d'une passion ardente pour les jeux vidéo, elle est à la recherche de joueurs passionnés par la création de contenu ou que ce soit par la progression continue.
                En rejoignant la Nouvelle Lignée, vous pourrez vous entraîner et être coaché par les coachs actuellement disponibles et même participer à des tournois à couper le souffle !
                Vous pourrez également entrer dans une dimension où le jeu n'a plus de frontières, où tout devient possible et où chaque seconde sera plus intense que la précédente !
            </p>  
                <section class="conteneurVideo">
                    <iframe src="https://www.youtube.com/embed/MuQ4Gjg_HHg" title="[AFFICHE DE RECRUTEMENT] DE LA NOUVELLE LIGNÉE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </section>
        </div>

        <!-- Contenu 3: Formulaire de demande d'adhésion -->
        <div class="fixe accueilDemande" style="display: none;" id="contenu3">

            <?php
            if(empty($_SESSION['utilisateur'])){
                echo'<h2>Faites vos demandes dès maintenant !</h2>';
                echo'<br>';
                
                //Multi formulaire pour demander l'adhésion
                echo'<form method="GET" action="../routeurs/routeur.php" class="contourBtn_CreationCandidature">';
                echo'   <button type="submit" name="onglet" value="creationCandidature" class="btn_CreationCandidature">Demander adhésion</button>';
                echo'</form>';
            }else{
                echo"<h2>Merci d'avoir demander à faire partie de l'équipe</h2>";
            }
            ?>

    <footer class="footer">
        <div class="footer-links">
            <p><a href="?onglet=supportAssistance">Support et Assistance</a></p>
            <p><a href="?onglet=politiqueConfidentialite">Politique de confidentialité</a></p>
            <p><a href="?onglet=aPropos">À propos</a></p>
            <p><a href="?onglet=mentionsLegales">Mentions légales</a></p>
            <p><a href="https://www.youtube.com/channel/UCiTfoVv5D0jtfyztkR2T27A/?sub_confirmation=1">Réseaux sociaux</a></p>
        </div>
        <p class="footer-copyright">&copy; 2024 La Nouvelle Lignée. Tous droits réservés.</p>
    </footer>
    </div>

    </div>
<!-- Script JavaScript pour récupérer et afficher le nombre d'abonnés -->
<script>
  function obtenirNombreAbonnes() {
    var idChaine = "UCiTfoVv5D0jtfyztkR2T27A";
    var cleApi = "Désactivé";
    var lienApi = "https://www.googleapis.com/youtube/v3/channels?part=statistics&id=" + idChaine + "&key=" + cleApi;

    fetch(lienApi)
      .then(response => response.json())
      .then(data => {
        var nombreAbonnes = data.items[0].statistics.subscriberCount;
        document.getElementById("subscribersCount").textContent = nombreAbonnes + " abonnés";
      })
      .catch(error => {
        console.log("Une erreur s'est produite lors de la récupération du nombre d'abonnés :", error);
        document.getElementById("subscribersCount").textContent = "Impossible de récupérer le nombre d'abonnés.";
      });
  }

  // Appel de la fonction pour afficher le nombre d'abonnés au chargement de la page
 //window.onload = obtenirNombreAbonnes;
</script>
<script src="../scripts/script_Defilement.js"></script>



