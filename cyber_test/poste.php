<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des membres</title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
        <!-- Icone de navigateur-->
        <link rel="icon" type="image/png" sizes="32x32" href="image/logo_blue.png">
</head>

<body>
    <!-- inclure le fichier du menu à la page-->
    <?php
    include('menu.php');
    ?>

    <!-- Titre de la page -->
    <h1 class="titre_principal">Gestion des postes</h1>
    <h1 class="sous_titre">Ajouter un poste</h1>
    <!-- Formulaire d'ajout de postes -->
    <form class="formulaire_ajout" method="post">

        <!-- Champ de saisi du nom -->
        <label class="ajout_label" for="nom">Nom du poste
            <input class="ajout_entree" id="nom" type="text" name="nom">
        </label>

        <!-- Choix du type  -->
        <label class="ajout_label" for="prenom">Type de poste
            <select name="type" aria-disabled="disabled">
                <option value="gaming">Gaming</option>
                <option value="bureau">Bureau</option>
            </select>
        </label>

        <!-- Bouton de validation du formulaire -->
        <input class="formulaire_bouton" type="submit" value="Ajouter un poste" name="ajouter">

    </form>
    <!-- Fin du formulaire d'ajout de membre -->

    <!-- Requête d'insertion des postes -->
    <?php

    include('config.php');
    $reponse = $bdd->query('SELECT * FROM poste');

    // Si les champs sont remplis et que l'utilisateur envoie le formulaire
    if (
        isset($_POST['ajouter'])
        & !empty($_POST['nom'])
        & !empty($_POST['type'])
    ) {

        //Vérification des entrées de l'utilisateur
        $_POST['nom'] = htmlentities($_POST['nom'], ENT_QUOTES);
        $_POST['type'] = htmlentities($_POST['type'], ENT_QUOTES);

        // Requete d'insertion des données dans la table 'utilisateur'
        $requete = 'INSERT INTO poste VALUES(NULL, "' . $_POST['nom'] . '", "' . $_POST['type'] . '", NULL)';
        $resultat = $bdd->query($requete);

        // Fenetre JS affichant un message 
        echo '<script> alert("Le poste a bien été ajouté");</script>';
        header('REfresh:0;');

        // Fermeture de la connexion à la BDD
        $bdd = null;
    }
    ?>

    <div class="poste_container">
        <?php
        // Afficher les différents postes
        include('config.php');
        $reponse = $bdd->query('SELECT * FROM poste');
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
                <form method="post" action="modifier_poste.php?id_poste=' . $donnees['id'] . '">
                <input type="hidden" name="id_poste" value="' . $donnees['id'] . '" src="image/logo_modifier.png" />
                <input type="submit" class="poste_action" name="modifier" value="Modifier" />
                </form>
                <form method="post">
                <input type="hidden" name="id_poste" value="' . $donnees['id'] . '" src="image/logo_modifier.png" />
                <input type="submit" class="poste_action" name="supprimer" value="Supprimer" />
                </form>
                </div>
                </div>';
        }
        // Requete de suppression de poste
        if (isset($_POST['supprimer'])) {
            $requete = 'DELETE FROM poste WHERE id="' . $_POST['id_poste'] . '"';
            $resultat = $bdd->query($requete);
            echo '<script> alert("Le poste a bien été supprimé");</script>';
            header('Refresh:0;');
        }
        ?>
    </div>
    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>