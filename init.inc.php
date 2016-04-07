<?php

// creation de la base de donnée
// creation de l'architecture du site
// creation de init.inc.php

$mysqli = new mysqli("localhost", "root", "root", "lokisalle");

if($mysqli->connect_error) die ('Un problème est survenu lors de la connexion à la BDD : ' .$mysqli->connect_error);

/*SESSION*/
session_start();
/*CHEMIN*/
define("RACINE_SITE", "/LOKISALLE/");
/*VARIABLE*/
$contenu = '';
require_once("fonction.inc.php");
?>
