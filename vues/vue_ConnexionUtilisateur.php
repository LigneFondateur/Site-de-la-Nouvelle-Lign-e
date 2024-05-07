<?php
require_once('../modeles/modele_ConnexionUtilisateur.php');
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
    <form method="POST">
        <h1>Se connecter</h1>
            <p>Email:<input class="placeTexte" type="text" placeholder="Email" name="email" autocomplete="off" required></p>
            <p>Mot de passe:<input type="text"class="placeTexte" placeholder="Mot de passe" name="motDePasse" autocomplete="new-password" required></p>
            
            <button type="button" class="btn_Quitter" id="btnQuitter">Quitter</button>
            <script>
                document.getElementById("btnQuitter").addEventListener("click", function() {
                    // Code à exécuter lorsque le bouton est cliqué
                    window.location.href = "../routeurs/routeur.php?onglet=accueil";
                });                
            </script>            
            <button type="submit" class="btn_Valider">Valider</button>
        </form>
    </section>
</section>
</body>
</html>