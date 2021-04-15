<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
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
    <h1 class="titre_principal">Bienvenue sur la page d'accueil</h1>

    <!-- Cartes liens vers les différentes pages -->
    <div class="container_lien">
        <div class="lien_carte" onclick="location.href = 'attribution.php';"><span class="lien_carte_texte">Affecter à un poste</span></div>
        <div class="lien_carte" onclick="location.href = 'poste.php';"><span class="lien_carte_texte">Gérer les postes</span></div>
        <div class="lien_carte" onclick="location.href = 'membre.php';"><span class="lien_carte_texte">Gérer les membres</span></div>
    </div>

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

        // Fermeture de la connexion à la BDD
        $bdd = null;
    }
    ?>

    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>