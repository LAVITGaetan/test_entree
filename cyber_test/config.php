<?php
//connexion à la BDD
$bdd = new PDO('mysql:host=127.0.0.1;dbname=cyber;charset=utf8', 'phpmyadmin', 'Workout974!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
