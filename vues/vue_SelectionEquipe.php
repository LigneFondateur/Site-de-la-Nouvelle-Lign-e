<?php
require_once('../classesPHP/classe_ConnexionBdd.php');

$connexionBdd = new ConnexionBdd();

// Exécution de la requête pour obtenir les équipes
$equipes = $connexionBdd->prepare("SELECT * FROM equipe", []);
                                                
?>
<section class="contourCarte">
    <section class="effetCarte"></section>
    <section class="carte">
        <div>
            <?php
            foreach ($equipes as $equipe){
                // Créer un formulaire pour chaque équipe avec un bouton pour sélectionner l'équipe
                echo '<form method="GET" action="../routeurs/routeur.php">';
                echo '  <input type="hidden" name="onglet" value="affichageEquipe">';
                echo '  <input type="hidden" name="idEquipe" value="' . $equipe->id . '">';
                echo '  <button class="btn_Selection" type="submit">Equipe ' . $equipe->nom .'</button>';
                echo '</form>';
            }
            ?>   
        </div>
    </section>
</section>
