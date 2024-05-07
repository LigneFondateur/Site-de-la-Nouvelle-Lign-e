<?php
require_once '../classesPHP/classe_ConnexionBdd.php';
require_once '../classesPHP/classe_GestionUtilisateur.php';
$gestionUtilisateur = new GestionUtilisateur();

// Récupérer l'identifiant de l'utilisateur depuis l'URL
$idUtilisateur = isset($_GET['idUtilisateur']) ? $_GET['idUtilisateur'] : null;

// Si l'identifiant de l'utilisateur est disponible
if ($idUtilisateur) {
    // Créer une instance de la classe de connexion à la base de données
    $db = new ConnexionBdd();

    // Si la connexion à la base de données est établie
    if ($db) {
        // Récupérer les informations de l'utilisateur depuis la base de données
        $utilisateur = $db->prepare("SELECT * FROM Utilisateur WHERE id = ?", [$idUtilisateur], true);
        if ($utilisateur) {
            // Récupérer les rôles de l'utilisateur pour chaque équipe
            $utilisateurEquipes = $db->prepare("SELECT e.nom AS equipe_nom, r.nom AS role_nom FROM Equipe e JOIN Contenir c ON e.id = c.idEquipe JOIN Role r ON c.idRole = r.id WHERE c.idUtilisateur = ?", [$idUtilisateur]);

            // Vérifier si l'utilisateur est administrateur
            $estAdministrateur = $utilisateur->estGestionnaire;

            // Vérifier si les propriétés existent avant de les afficher
            $description = isset($utilisateur->description) ? $utilisateur->description : 'Non spécifiée';

            // Afficher les informations de l'utilisateur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte Utilisateur</title>
</head>
<body>
<?php
    require_once '../ressources/ressource_Styles.php';
?>
<link rel="stylesheet" href="../styles/style_CarteUtilisateur.css"><section class="contourCarte">
  <section class="effetCarte"></section>
  <section class="carte">
    <section class="enteteProfile">
      <img src="<?php echo isset($utilisateur->image) ? $utilisateur->image : '#'; ?>" class="imgProfile">
    </section>
    <section class="sousEnteteProfile">
      <h1><?php echo isset($utilisateur->pseudo) ? $utilisateur->pseudo : 'Non spécifié'; ?></h1>
      <button id="btnAfficherContenuCarteUtilisateur">&#129047;</button>
    </section>
    <section class="fixeCarteUtilisateur">
    <?php
    // Afficher le rôle de l'utilisateur pour chaque équipe
    foreach ($utilisateurEquipes as $equipe) {
        $equipe_nom = str_replace('É', 'é', $equipe->equipe_nom);
        $role = ucfirst($equipe->role_nom);
        if ($estAdministrateur && $role === 'Administrateur') {
            echo "<p>" . $role . " et Membre de l'" . $equipe_nom . "</p>";
        } else {
            echo "<p>" . $role . " de l'" . $equipe_nom . "</p>";
        }
    }
    ?>
      <p>Description : <?php echo $description; ?></p>
      <?php
      if($gestionUtilisateur->getYouTube($utilisateur->id) !== null){
          $lien = $gestionUtilisateur->getYouTube($utilisateur->id);
          echo '<a href="' . $lien . '">Youtube</a>';
      }
      if($gestionUtilisateur->getTwitch($utilisateur->id) !== null){
          $lien = $gestionUtilisateur->getTwitch($utilisateur->id);
          echo '<a href="' . $lien . '">Twitch</a>';
      }
      if($gestionUtilisateur->getDiscord($utilisateur->id) !== null){
          echo '<p>'.$gestionUtilisateur->getDiscord($utilisateur->id).'</p>';
      }
      ?>



      <button id="btnCacherContenuCarteUtilisateur" style="display: none;">&#129045;</button>
    </section>
    <?php
    if (isset($_GET['idEquipe'])) {
        $idEquipe = $_GET['idEquipe'];
        echo '<form method="GET" action="../routeurs/routeur.php">';
        echo '  <input type="hidden" name="onglet" value="affichageEquipe">';
        echo '  <input type="hidden" name="idEquipe" value="' . $idEquipe . '">';
        echo '  <button type="submit" id="btnRetourEquipe">Retour</button>';
        echo '</form>';
    }
    ?>
  </section>
</section>

<script>
const btnAfficher = document.getElementById('btnAfficherContenuCarteUtilisateur');
const btnCacher = document.getElementById('btnCacherContenuCarteUtilisateur');
const contenuCarte = document.querySelector('.fixeCarteUtilisateur');

btnAfficher.addEventListener('click', () => {
  afficherContenu();
});

btnCacher.addEventListener('click', () => {
  cacherContenu();
});

function afficherContenu(){
  contenuCarte.style.opacity = '1'; // Afficher le contenu en ajustant l'opacité
  btnAfficher.style.opacity = '0'; // Masquer le bouton Afficher
  btnCacher.style.opacity = '1'; // Afficher le bouton Cacher
  btnAfficher.style.display = 'none'; // Masquer le bouton Afficher
  btnCacher.style.display = 'block'; // Afficher le bouton Cacher
  contenuCarte.style.height = 'fit-content'; // Ajuster la hauteur du contenu
  contenuCarte.style.marginTop = '25px';
  contenuCarte.style.paddingBottom = '15px';
}



function cacherContenu(){
  contenuCarte.style.opacity = '0'; // Masquer le contenu en ajustant l'opacité
  btnAfficher.style.opacity = '1'; // Afficher le bouton Afficher
  btnCacher.style.opacity = '0'; // Masquer le bouton Cacher
  btnAfficher.style.display = 'block'; // Afficher le bouton Afficher
  btnCacher.style.display = 'none'; // Masquer le bouton Cacher
  contenuCarte.style.height = '0'; // Réinitialiser la hauteur du contenu
  contenuCarte.style.marginTop = '-15px';
  contenuCarte.style.paddingBottom = '0px';
}
cacherContenu();


</script>

</body>
</html>

<?php
        } else {
            echo '<p>Utilisateur non trouvé.</p>';
        }
    } else {
        echo '<p>Erreur de connexion à la base de données.</p>';
    }
} else {
    echo '<p>Aucun utilisateur sélectionné.</p>';
}
?>
