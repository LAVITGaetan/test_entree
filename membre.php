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
    <h1 class="titre_principal">Gestion des membres</h1>
    <h1 class="sous_titre">Ajouter un utilisateur</h1>
    <!-- Formulaire d'ajout de membre -->
    <form class="formulaire_ajout" method="post">

        <!-- Champ de saisi du nom -->
        <label class="ajout_label" for="nom">Nom
            <input class="ajout_entree" id="nom" type="text" name="nom">
        </label>

        <!-- Champ de saisi du prenom -->
        <label class="ajout_label" for="prenom">Prenom
            <input class="ajout_entree" id="prenom" type="text" name="prenom">
        </label>

        <!-- Bouton de validation du formulaire -->
        <input class="formulaire_bouton" type="submit" value="Ajouter un membre" name="ajouter">

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
        echo '<script> document.location.replace("membre.php");</script>';

        // Fermeture de la connexion à la BDD
        $bdd = null;
    }
    ?>


    <h1 class="sous_titre">Modifier ou supprimer un utilisateur</h1>
    <!-- Tableau des utilisateurs -->
    <table class="tableau">
        <thead>
            <tr>
                <th class="tableau_en-tete">Nom</th>
                <th class="tableau_en-tete">Prenom</th>
                <th class="tableau_en-tete"></th>
                <th class="tableau_en-tete"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Inserer les informations du membre dans la table correspondante
            include('config.php');
            $reponse = $bdd->query('SELECT * FROM utilisateur');
            while ($donnees = $reponse->fetch()) {
                echo '<form method="post">';
                //Récupérer l'id de l'utilisateur
                echo '<input type="hidden" name="id" value="' . $donnees['id'] . '">';
                echo '<tr>
                <td class="tableau_contenu"><input class="tableau_entree" value="' . $donnees['nom'] . '" name="nom"></td>
                <td class="tableau_contenu"><input class="tableau_entree" value="' . $donnees['prenom'] . '" name="prenom"></td>
                <td class="tableau_contenu"><input type="submit" class="formulaire_bouton" value="Modifier" name="modifier"></td>
                <td class="tableau_contenu"><input type="submit" class="formulaire_bouton" value="Supprimer" name="supprimer"></td>
                </tr>
                </form>';
            }
            ?>
        </tbody>

        <?php
        //Requete de modification des informations de l'utilisateur
        if (isset($_POST['modifier']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
            $requete = 'UPDATE utilisateur SET nom="' . $_POST['nom'] . '", prenom="' . $_POST['prenom'] . '" WHERE id="' . $_POST['id'] . '"';
            $resultat = $bdd->query($requete);

            // Fenetre JS affichant un message 
            echo '<script> alert("L\'utilisateur a bien été modifié");</script>';
            echo '<script> document.location.replace("membre.php");</script>';
        }

        //Requete de suppression de l'utilisateur
        if (isset($_POST['supprimer'])) {
            $requete = 'DELETE FROM utilisateur WHERE id="' . $_POST['id'] . '"';
            $resultat = $bdd->query($requete);

            // Fenetre JS affichant un message 
            echo '<script> alert("L\'utilisateur a bien été supprimé");</script>';
            echo '<script> document.location.replace("membre.php");</script>';
        }
        ?>
    </table>
    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>