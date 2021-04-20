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
    <h1 class="titre_principal">Modifier un poste</h1>
    <div class="poste_container">
        <?php
        // Afficher les différents postes
        include('config.php');
        $reponse = $bdd->query('SELECT * FROM poste WHERE id="' . $_GET['id_poste'] . '"');
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
                <span class="poste_type">' . $donnees['type'] . '</span>
                </div>';

            //Récupération du type du poste
            $nom = $donnees['nom'];

            //Récupération du type du poste
            if ($donnees['type'] == 'gaming') {
                $gaming = 1;
            } else {
                $bureau = 1;
            };
        }

        ?>
    </div>

    <!-- Formulaire de modification des postes -->
    <form class="formulaire_ajout" method="post">

        <!-- Champ de saisi du nom -->
        <label class="ajout_label" for="nom">Nom
            <input class="ajout_entree" id="nom" type="text" name="nom" value="<?php echo $nom; ?>">
        </label>

        <!-- Choix du type  -->
        <label class="ajout_label" for="prenom">Type de poste
            <select name="type" aria-disabled="disabled">
                <option value="gaming" <?php if (isset($gaming)) {
                                            echo 'selected';
                                        } ?>>Gaming</option>
                <option value="bureau" <?php if (isset($bureau)) {
                                            echo 'selected';
                                        } ?>>Bureau</option>
            </select>
        </label>

        <!-- Bouton de validation du formulaire -->
        <input class="formulaire_bouton" type="submit" value="Modifier le poste" name="modifier">

    </form>
    <!-- Fin du formulaire d'ajout de membre -->
<?php

    // Inserer les informations du membre dans la table correspondante
    include('config.php');
    $reponse = $bdd->query('SELECT * FROM utilisateur');

    // Si les champs sont remplis et que l'utilisateur envoie le formulaire
    if (
        isset($_POST['ajouter'])
        & !empty($_POST['nom'])
        & !empty($_POST['prenom'])
    ) {

        //Vérification des entrées de l'utilisateur
        $_POST['nom'] = htmlentities($_POST['nom'], ENT_QUOTES);
        $_POST['prenom'] = htmlentities($_POST['prenom'], ENT_QUOTES);

        // Requete d'insertion des données dans la table 'utilisateur'
        $requete = 'INSERT INTO utilisateur VALUES(NULL, "' . $_POST['nom'] . '", "' . $_POST['prenom'] . '")';
        $resultat = $bdd->query($requete);

        // Fenetre JS affichant un message 
        echo '<script> alert("L\'utilisateur a bien été ajouté");</script>';
        
        // Fermeture de la connexion à la BDD
        $bdd = null;
    }
    ?>
    <?php

    //Requete de modification
    include('config.php');
    $reponse = $bdd->query('SELECT * FROM poste WHERE id="' . $_GET['id_poste'] . '"');
    if (isset($_POST['modifier']) && !empty($_POST['nom']) && !empty($_POST['type'])) {
        $requete = 'UPDATE poste SET nom="' . $_POST['nom'] . '", type="' . $_POST['type'] . '" WHERE id="' . $_GET['id_poste'] . '"';
        $reponse = $bdd->query($requete);
        // Fenetre JS affichant un message 
        echo '<script> alert("Le poste a bien été modifié");</script>';
        header('Refresh:0;');
    }
    ?>

    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>