<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des membres</title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Icone de navigateur-->
    <link rel="icon" type="image/png" sizes="32x32" href="image/logo_yellow.png">
</head>

<body>
    <!-- inclure le fichier du menu à la page-->
    <?php
    include('menu.php');
    ?>

    <!-- Titre de la page -->
    <h1 class="titre_principal">Affecter des utilisateurs aux postes</h1>
    <div class="poste_container">
    <?php
        // Afficher les différents postes
        include('config.php');
        $reponse = $bdd->query('SELECT * FROM poste WHERE disponibilite = 1');
        while ($donnees = $reponse->fetch()) {

            //Verification du type du poste
            if ($donnees['type'] == 'gaming') {
                $image = 'gaming';
            } else {
                $image = 'bureau';
            };

            //Affichage du poste
            echo '<div class="poste_carte">
                <span class="poste_nom">' . $donnees['nom'] . '</span>
                <img class="poste_logo" src="image/logo_' . $image . '.png">
                <span class="poste_type">Type : ' . $donnees['type'] . '</span>
                <div class="poste_options">
                <form method="post" action="attribuer_poste.php?id_poste=' . $donnees['id'] . '">
                <input type="hidden" name="id_poste" value="' . $donnees['id'] . '"/>
                <input type="submit" class="poste_action" name="attribuer" value="Réserver" />
                </form>
                </div>
                </div>';
        }
        ?>
    </div>
    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>