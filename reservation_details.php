<?php
require_once("inc/init.inc.php");

//********* Recupératon de l'id pour afficher les informations de la salle selectionné *********//

if(isset($_GET['id_salle']))
{
  $resultat = executeRequete("SELECT * FROM salle WHERE id_salle='$_GET[id_salle]'");
}
if($resultat->num_rows == 0)
{
  header("location:_index.php");
  exit();
}
$salle = $resultat->fetch_assoc();
$contenu .= "<h3>$salle[titre]</h3><br>";
$contenu .= "<img src='$salle[photo]' width='300' height='200'/>";
$contenu .= "<p>Capacite : $salle[capacite]</p><br>";
$contenu .= "<p>Categorie : $salle[categorie]</p><br>";
$contenu .= "<p>pays: $salle[pays]</p><br>";
$contenu .= "<p>ville : $salle[ville]</p><br>";
$contenu .= "<p>Adresse : $salle[adresse]</p><br>";
$contenu .= "<p>Code postal : $salle[cp]</p><br>";

$contenu .= "<br /><a href='_index.php?categorie=" .$salle['id_salle']. "'>Retour vers la selection de : " .$salle['id_salle']."</a>";


require_once("inc/haut.inc.php");
require_once("inc/menu.inc.php");

echo $contenu;
require_once("inc/bas.inc.php");
?>
