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
    <h1 class="sous_titre">Ajouter un poste</h1>
    <!-- Formulaire d'attribution de poste -->
    <form class="formulaire_ajout" method="post">

        <!-- id du poste -->
        <input type="hidden" class="ajout_entree" value="<?php echo $_GET['id_poste']; ?>" type="text" name="id_poste">

        <!-- id dee l'utilisateur -->
        <label class="ajout_label" for="prenom">Utilisateur
            <select name="id_utilisateur">
                <?php
                // Afficher les utilisateur
                include('config.php');
                $reponse = $bdd->query('SELECT * FROM utilisateur');
                while ($donnees = $reponse->fetch()) {
                    echo '<option value="' . $donnees['id'] . '">' . $donnees['nom'] . ' ' . $donnees['prenom'] . '</option>';
                }
                ?>
            </select>
        </label>

        <!-- Selection de la date  -->
        <label class="ajout_label" for="prenom">Date
            <input class="formulaire_entree" type="date" name="date">
        </label>
        <!-- Selection de l'heure de debut  -->
        <label class=" ajout_label">Heure début
            <input class="formulaire_entree" type="time" name="heure_debut">
        </label>

        <!-- Selection de l'heure de fin  -->
        <label class="ajout_label">Heure fin
            <input class="formulaire_entree" type="time" name="heure_fin">
        </label>

        <!-- Bouton de validation du formulaire -->
        <input class="formulaire_bouton" type="submit" value="Attribuer" name="Réserver">

    </form>
    <!-- Fin du formulaire d'ajout de membre -->
    <div class="poste_container">
        <?php
        // Afficher les différents postes
        include('config.php');
        $reponse = $bdd->query('SELECT utilisateur.nom AS nom_utilisateur, utilisateur.prenom,
        poste.nom, poste.type, poste.id, reservation.id_poste, reservation.id_utilisateur,
        reservation.date, reservation.heure_debut, reservation.heure_fin, reservation.id AS id_reservation FROM poste,utilisateur,reservation WHERE reservation.id_utilisateur = utilisateur.id
        AND reservation.id_poste = poste.id AND poste.id="' . $_GET['id_poste'] . '"');
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
                <span class="poste_type">Début : ' . $donnees['heure_debut'] . '</span>
                <span class="poste_type">Fin : ' . $donnees['heure_fin'] . '</span>
                <div class="poste_options">
                <form method="post" action="attribuer_poste.php?id_poste=' . $donnees['id'] . '">
                <input type="hidden" name="id_reservation" value="' . $donnees['id_reservation'] . '"/>
                <input type="submit" class="poste_action" name="attribuer" value="Attribuer" />
                </form>
                <form method="post">
                <input type="hidden" name="id_reservation" value="' . $donnees['id_reservation'] . '"/>
                <input type="submit" class="poste_action" name="annuler" value="Annuler" />
                </form>
                </div>
                </div>';
        }

        //Annuler une reservation
        if (isset($_POST['annuler'])) {
            $requete = 'DELETE FROM reservation WHERE id="' . $_POST['id_reservation'] . '"';
            $reponse = $bdd->query($requete);
            //Fenetre JS affichant un message
            echo '<script>alert("La reservation a bien été annulée");</script>';
            //Raffraichir la page
            echo '<script> document.location.replace("accueil.php");</script>';
        }

        //Attribuer un poste
        if (isset($_POST['attribuer']) && !empty($_POST['date']) && !empty($_POST['heure_debut']) && !empty($_POST['heure_fin'])) {
            $requete = 'INSERT INTO reservation VALUES(NULL, "' . $_POST['id_poste'] . '", "' . $_POST['id_utilisateur'] . '", "' . $_POST['date'] . '", "' . $_POST['heure_debut'] . '", "' . $_POST['heure_fin'] . '")';
            $reponse = $bdd->query($requete);
            //Modifier la disponibilite du poste
            $requete = 'UPDATE poste SET disponibilite = 0 WHERE id="' . $_POST['id_poste'] . '"';
            $reponse = $bdd->query($requete);

            //Fenetre JS affichant un message
            echo '<script>alert("L\'utilisateur a bien été attribué au poste");</script>';
            //Raffraichir la page
            echo '<script> document.location.replace("accueil.php");</script>';
        }

        ?>
    </div>
    <!-- Script JS -->
    <script src="script.js"></script>
</body>

</html>