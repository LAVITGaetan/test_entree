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
        echo '<script> document.location.replace("accueil.php");</script>';

        // Fermeture de la connexion à la BDD
        $bdd = null;
    }
    ?>

    <!-- Liste des poste disponible -->
    <h1 class="sous_titre">Liste des postes disponible</h1>
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
                <input type="submit" class="poste_action" name="attribuer" value="attribuer" />
                </form>
                </div>
                </div>';
        }
        ?>
    </div>

    
<!-- Liste des poste en cours d'utilisation -->
    <h1 class="sous_titre">Liste des postes en cours d'utilisation</h1>
    <div class="poste_container">

        <?php
        // Afficher les différents postes
        include('config.php');
        $reponse = $bdd->query('SELECT utilisateur.nom AS nom_utilisateur, utilisateur.prenom, poste.nom, poste.type, poste.id AS id_poste, reservation.id, reservation.id_poste, reservation.id_utilisateur, reservation.date, reservation.heure_debut, reservation.minute_debut, reservation.heure_fin, reservation.minute_fin FROM poste,utilisateur,reservation WHERE reservation.id_utilisateur = utilisateur.id AND reservation.id_poste = poste.id');
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
                <span class="poste_type">Utilisateur : ' . $donnees['nom_utilisateur'] . ' ' . $donnees['prenom'] . '</span>
                <span class="poste_type">Date : ' . $donnees['date'] . '</span>
                <span class="poste_type">Début : ' . $donnees['heure_debut'] . 'h' . $donnees['minute_debut'] . '</span>
                <span class="poste_type">Fin : ' . $donnees['heure_fin'] . 'h' . $donnees['minute_fin'] . '</span>
                <div class="poste_options">
                <form method="post" action="attribuer_poste.php?id_poste=' . $donnees['id'] . '&id_utilisateur=' . $donnees['id_utilisateur'] . '">
                <input type="hidden" name="id_poste" value="' . $donnees['id'] . '"/>
                <input type="submit" class="poste_action" name="attribuer" value="Attribuer" />
                </form>
                <form method="post">
                <input type="hidden" name="id_poste" value="' . $donnees['id_poste'] . '"/>
                <input type="hidden" name="id_reservation" value="' . $donnees['id'] . '"/>
                <input type="submit" class="poste_action" name="annuler" value="Annuler" />
                </form>
                </div>
                </div>';
        }

        if (isset($_POST['annuler'])) {
            $requete = 'DELETE FROM reservation WHERE id="' . $_POST['id_reservation'] . '"';
            $reponse = $bdd->query($requete);
            //modifier la disponibilite du poste
            $requete = 'UPDATE poste SET disponibilite = 1 WHERE id="' . $_POST['id_poste'] . '"';
            $reponse = $bdd->query($requete);
            //Fenetre JS affichant un message
            echo '<script>alert("La reservation a bien été annulée");</script>';
            //Raffraichir la page
            echo '<script> document.location.replace("accueil.php");</script>';
        }
        ?>
    </div>


    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>