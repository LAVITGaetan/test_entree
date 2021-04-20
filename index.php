<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
        <!-- Icone de navigateur-->
        <link rel="icon" type="image/png" sizes="32x32" href="image/logo_yellow.png">
</head>

<body>

<div class="connexion_container">
    <!-- Titre de la page -->
    <h1 class="titre_connexion">Bienvenue sur la page de connexion</h1>

    <!-- Formulaire de connexion -->
    <form class="formulaire_connexion" method="post">

        <!-- Logo -->
        <div class="formulaire_logo">
            <img class="logo_formulaire" src="image/logo_yellow.png" alt="logo du formulaire">
        </div>

        <!-- Champ de saisi du pseudo -->
        <label class="connexion_label" for="pseudo">Pseudo
            <input class="connexion_entree" id="pseudo" type="text" name="pseudo">
        </label>

        <!-- Champ de saisi du mot de passe -->
        <label class="connexion_label" for="mot_de_passe">Mot de passe
            <input class="connexion_entree" id="mot_de_passe" type="password" name="mot_de_passe">
        </label>

        <!-- Bouton de validation du formulaire -->
        <input class="formulaire_bouton" type="submit" value="Se connecter" name="connecter">

    </form>
    <!-- Fin du formulaire de connexion -->

    <?php
    //Vérification des informations saisis par l'utilisateur et des informations de la table admin

    if (isset($_POST['connecter']) & !empty($_POST['pseudo']) & !empty($_POST['mot_de_passe'])) {
        //Récuperation de l'utilisateur via son pseudo
        $bdd = new PDO('mysql:host=127.0.0.1;dbname=cyber;charset=utf8', 'phpmyadmin', 'Workout974!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $reponse = $bdd->query('SELECT * FROM admin WHERE pseudo ="' . $_POST['pseudo'] . '"');
        while ($donnees = $reponse->fetch()) {
            $pseudo = $donnees['pseudo'];
            $mot_de_passe = $donnees['mot_de_passe'];
        }

        //Vérification du mot de passe
        //Si le mot de passe ne correspond pas afficher un message d'erreur
        $mot_de_passe_identique = password_verify($_POST['mot_de_passe'], $mot_de_passe);
        if (!$mot_de_passe_identique) {
            echo '<span class="alerte_message">Vos identifiants ne correspondent pas!</span>';
        } else {

            //Si le mot de passe correspond, crée une session et récupérer les données de l'utilisateur 
            //puis le rediriger vers la page d'espace membre
            if ($mot_de_passe_identique) {
                echo 'Vous êtes connecté';
                echo '<script> document.loaction.replace("accueil.php");';
            } else {
                echo '<span class="alerte_message">Vos identifiants ne correspondent pas!</span>';
            }
        }
    }
    ?>
    </div>
</body>

</html>