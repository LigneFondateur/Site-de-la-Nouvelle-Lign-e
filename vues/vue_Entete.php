<?php
require_once("../routeurs/routeur.php");


require_once("../classesPHP/classe_ConnexionBdd.php");

require_once("../classesPHP/classe_GestionUtilisateur.php");

$gestionUtilisateur = new GestionUtilisateur();

$gestionUtilisateur->verifierConnexion();

// Obtient le token CSRF de la session
$tokenCSRF = $_SESSION['csrf_token'] ?? '';

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

<form class="entete_Formulaire" method="GET" action="../routeurs/routeur.php">
    <header class="entete">
        <button class="entete_Selection" type="submit" name="onglet" value="accueil">Accueil</button>
        <button class="entete_Selection" type="submit" name="onglet" value="candidatures">Candidatures</button>
        <button class="entete_Selection" type="submit" name="onglet" value="selectionEquipe">Équipe</button>
        <?php 
        if(!empty($_SESSION['utilisateur'])) {
            // Ajoute le bouton pour les paramètres utilisateur avec le token CSRF inclus dans l'URL
            echo '<button class="entete_Selection" type="submit" name="onglet" value="parametresUtilisateur">';

            // Ajoute le pseudo de l'utilisateur
            echo $_SESSION['utilisateur']->pseudo;

            // Ajoute le token CSRF en tant que champ caché dans le formulaire
            echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($tokenCSRF) . '">';

            echo '</button>';
        } else {
            echo '<button class="entete_Selection" type="submit" name="onglet" value="connexionUtilisateur">Se connecter</button>';
        }
        ?>    
    </header>
</form>




