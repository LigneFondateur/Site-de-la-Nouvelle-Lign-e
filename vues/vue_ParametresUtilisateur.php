<?php
require_once '../classesPHP/classe_GestionUtilisateur.php';

// Vérifier la connexion de l'utilisateur et démarrer la session si nécessaire
GestionUtilisateur::verifierConnexion();
if(empty($_SESSION['utilisateur'])){
  header('Location: ../index.php');
  return;
}
// Vérifier si le jeton CSRF est présent dans la session
if (!isset($_SESSION['csrf_token'])) {
  header('Location: ../index.php');
  return;
}


// Récupérer l'identifiant de l'utilisateur depuis la session
$sessionIdUtilisateur = $_SESSION['utilisateur']->id;
// Créer une instance de la classe de gestion des utilisateurs
$gestionUtilisateur = new GestionUtilisateur();
require_once '../modeles/modele_GestionUtilisateur.php';



// Récupérer le jeton CSRF de la session
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paramètres Utilisateur</title>
  <script src="../classesJS/classe_GestionModificationUtilisateur.js"></script>
</head>
<body>
<?php
    require_once '../ressources/ressource_Styles.php';
?>
<section class="contourCarte" id="sectionFormulaires">
  <section class="effetCarte"></section>
  <section class="carte">
  
    <!-- Formulaire pour le champ Pseudo -->
    <p>
      Pseudo : <?php echo $gestionUtilisateur->getPseudo($sessionIdUtilisateur); ?>
      <button id="btnModifierPseudo" onclick="GestionModificationUtilisateur.allerModifierChamp('Pseudo')" class="btn_Gestion">Modifier</button>
    </p>
    <!-- Formulaire pour le champ Email -->
    <p>
      Email : <?php echo $gestionUtilisateur->getEmail($sessionIdUtilisateur); ?>
      <button id="btnModifierEmail" onclick="GestionModificationUtilisateur.allerModifierChamp('Email')" class="btn_Gestion">Modifier</button>
    </p>
    <!-- Formulaire pour le champ Mot de passe -->
    <p>
      <button class="btn_Gestion" id="btnModifierMotDePasse" onclick="GestionModificationUtilisateur.allerModifierChamp('MotDePasse')">Changer de mot de passe</button>
    </p>
    <?php
      // Vérifier si la demande a été traitée
      if ($gestionUtilisateur->verifierDemandeTraite($sessionIdUtilisateur)) {
          // Si la demande a été traitée, récupérer les équipes et les rôles associés à cet utilisateur
          $resultats = $gestionUtilisateur->getEquipesRole($sessionIdUtilisateur);

          // Vérifier si des équipes et des rôles ont été récupérés
          if (!empty($resultats['equipesRoles'])) {
            // Parcourir les équipes et les rôles avec une boucle foreach
            foreach ($resultats['equipesRoles'] as $index => $equipeRole) {
                echo '<p>';
                echo "Vous êtes " . $equipeRole["role"] . " de l'équipe ". $equipeRole["equipe"];
                echo '<button class="btn_Quitter"  id="btnQuitterEquipe'.$resultats['idEquipes'][$index].'" onclick="GestionModificationUtilisateur.allerQuitterEquipe('.$resultats['idEquipes'][$index].', \''.$equipeRole["equipe"].'\')">Quitter</button>';
                echo '</p>';
            }        
          } else {
            // Si aucune équipe et aucun rôle n'ont été récupérés, afficher un message
            echo "<p>Vous n'êtes plus dans l'équipe.</p>";
        }
    } else {
        // Si la demande n'a pas été traitée, afficher un message indiquant que le mot de passe n'a pas encore été modifié
        echo "<p>Votre mot de passe n'a pas encore été modifié.</p>";
    }
  
    ?>


    <!-- Formulaire pour le champ YouTube -->
    <?php 
    if ($gestionUtilisateur->getYoutube($sessionIdUtilisateur)) {
        echo '<p>';
        echo 'Lien YouTube : ' . $gestionUtilisateur->getYoutube($sessionIdUtilisateur);
        echo '<button id="btnModifierYouTube" onclick="GestionModificationUtilisateur.allerModifierChamp(\'YouTube\')" class="btn_Gestion">Modifier</button>';
        echo '</p>';
    } else {
        echo '<button class="btn_Ajouter" id="btnAjouterYouTube" name="youtube" onclick="GestionModificationUtilisateur.allerModifierChamp(\'YouTube\')">Ajouter un lien YouTube</button>';
        echo'<br>';
    }
    ?>
    <!-- Formulaire pour le champ Twitch -->
    <?php 
    if ($gestionUtilisateur->getTwitch($sessionIdUtilisateur)) {
        echo '<p>';
        echo 'Lien Twitch : ' . $gestionUtilisateur->getTwitch($sessionIdUtilisateur);
        echo '<button id="btnModifierTwitch" name="twitch" onclick="GestionModificationUtilisateur.allerModifierChamp(\'Twitch\')" class="btn_Gestion">Modifier</button>';
        echo '</p>';
    } else {
        echo '<button class="btn_Ajouter" id="btnAjouterTwitch" name="discord" onclick="GestionModificationUtilisateur.allerModifierChamp(\'Twitch\')">Ajouter un lien Twitch</button>';
        echo'<br>';
    }
    ?>
    <!-- Formulaire pour le champ Discord -->
    <?php 
    if ($gestionUtilisateur->getDiscord($sessionIdUtilisateur)) {
        echo '<p>';
        echo 'Lien Discord : ' . $gestionUtilisateur->getDiscord($sessionIdUtilisateur);
        echo '<button id="btnModifierDiscord" onclick="GestionModificationUtilisateur.allerModifierChamp(\'Discord\')" class="btn_Gestion">Modifier</button>';
        echo '</p>';
    } else {
        echo '<button class="btn_Ajouter" id="btnAjouterDiscord" onclick="GestionModificationUtilisateur.allerModifierChamp(\'Discord\')">Ajouter un lien Discord</button>';
        echo'<br>';
    }
    ?>
    <form method="post">
        <button class="btn_Retirer" type="submit" name="deconnexion">Se déconnecter</button>
    </form>

    <form method="GET" action="../routeurs/routeur.php">
      <button type="submit" name="onglet" value="accueil" class="btn_Retour">Retour</button>
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
    </form>


  </section>
</section>
<!-- Formulaire pour le champ Pseudo -->
<section class="contourCarte" id="formPseudo" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p >Nouveau Pseudo :<input class="placeTexte" type="text" id="pseudo" name="pseudo" value="<?php echo $gestionUtilisateur->getPseudo($sessionIdUtilisateur); ?>" required></p>
      <p>Mot de passe :<input class="placeTexte" type="password"  name="motDePasse" required></p>

      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierPseudo">Confirmer</button>
      </div>
    </form>
  </section>
</section>

<!-- Formulaire pour le champ Email -->
<section class="contourCarte" id="formEmail" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p>Nouveau Email :<input class="placeTexte" type="email" id="email" name="email" required></p>
      <p>Confirmation du nouveau email :<input class="placeTexte" type="email" id="emailConfirmation" name="emailConfirmation" required></p>
      <p>Mot de passe :<input type="password" class="placeTexte" name="motDePasse" required></p>

      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierEmail">Confirmer</button>
      </div>
    </form>
  </section>
</section>

<!-- Formulaire pour le champ Mot de passe -->
<section class="contourCarte" id="formMotDePasse" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <!-- Champ pour le mot de passe actuel -->
      <p>Mot de passe actuel :<input type="password" class="placeTexte" id="motDePasseActuel" name="motDePasseActuel" required></p>
      <p>Nouveau mot de passe :<input type="password" class="placeTexte" name="motDePasse" required></p>
      <p>Confirmer le nouveau mot de passe :<input type="password" class="placeTexte" id="motDePasseConfirmation" name="motDePasseConfirmation" required></p>
      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierMotDePasse">Confirmer</button>
      </div>
    </form>
  </section>
</section>

<!-- Formulaire pour le champ Equipes role -->
<section class="contourCarte" id="formQuitterEquipe" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p>Êtes-vous sûr de vouloir quitter l'équipe <span id="nomEquipeSpan"></span> de la Nouvelle Lignée ?</p>
      <p>Mot de passe :<input type="password" class="placeTexte" name="motDePasse" required><button type="submit" class="btn_Confirmation" name="quitterEquipe" id="btnConfirmer" value="idEquipe">Confirmer</button></p>
      <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp('quitterEquipe')">Annuler</button>
    </form>
  </section>
</section>

<!-- Formulaire pour le champ YouTube -->
<section class="contourCarte" id="formYouTube" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p>Nouveau Lien YouTube :<input type="text" id="youtube" class="placeTexte" name="youtube" value="<?php echo $gestionUtilisateur->getYoutube($sessionIdUtilisateur); ?>" required></p>
      <p>Mot de passe :<input type="password" class="placeTexte" name="motDePasse" required></p>

      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierYoutube">Confirmer</button>
      </div>    
    </form>
  </section>
</section>

<!-- Formulaire pour le champ Twitch -->
<section class="contourCarte" id="formTwitch" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p>Nouveau Lien Twitch :<input type="text" id="twitch" class="placeTexte" name="twitch" value="<?php echo $gestionUtilisateur->getTwitch($sessionIdUtilisateur); ?>" required></p>
      <p>Mot de passe :<input type="password" class="placeTexte" name="motDePasse" required></p>

      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierTwitch">Confirmer</button>
      </div>
    </form>
  </section>
</section>

<!-- Formulaire pour le champ Discord -->
<section class="contourCarte" id="formDiscord" style="display: none;">
  <section class="effetCarte"></section>
  <section class="carte">
    <form method="POST">
      <!-- Champ caché pour le jeton CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo urlencode($_SESSION['csrf_token']); ?>">
      <p>Nouveau Lien Discord :<input type="text" id="discord" class="placeTexte" name="discord" value="<?php echo $gestionUtilisateur->getDiscord($sessionIdUtilisateur); ?>" required></p>
      <p>Mot de passe :<input type="password" class="placeTexte" name="motDePasse" required></p>

      <div>
        <button class="btn_Annuler" type="button" onclick="GestionModificationUtilisateur.annulerModifierChamp()">Annuler</button>
        <button type="submit" class="btn_Confirmation" name="modifierDiscord">Confirmer</button>
      </div>
    </form>
  </section>
</section>

</body>
</html>